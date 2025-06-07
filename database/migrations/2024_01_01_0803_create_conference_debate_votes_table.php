<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conference_debate_votes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('debate_id')->index(); // Heavy indexed for debate queries
            $table->uuid('participant_id')->index(); // Voter identification
            $table->uuid('team_id')->nullable()->index(); // Which team/side voted for
            $table->string('vote_type', 20)->index(); // for, against, neutral, abstain
            $table->string('vote_phase', 30)->default('final')->index(); // initial, mid_debate, final
            $table->timestamp('voted_at')->useCurrent()->index(); // Vote timestamp
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->integer('confidence_level')->nullable()->index(); // 1-10 confidence rating
            $table->text('comment')->nullable(); // Optional vote comment
            
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent(); // Optimized for write performance
            // Skip updated_at for maximum write performance

            // Foreign keys
            $table->foreign('debate_id')->references('id')->on('conference_debates')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('conference_debate_teams')->onDelete('set null');
            
            // Prevent duplicate votes in same phase
            $table->unique(['debate_id', 'participant_id', 'vote_phase'], 'unique_debate_participant_phase_vote');
            
            // High-performance compound indexes for vote counting
            $table->index(['debate_id', 'vote_type', 'voted_at'], 'debate_votes_debate_type_time');
            $table->index(['debate_id', 'vote_phase', 'vote_type'], 'debate_votes_debate_phase_type');
            $table->index(['team_id', 'vote_type', 'voted_at'], 'debate_votes_team_type_time');
            $table->index(['participant_id', 'voted_at'], 'debate_votes_participant_time');
            $table->index(['vote_type', 'confidence_level'], 'debate_votes_type_confidence');
            $table->index(['vote_phase', 'voted_at'], 'debate_votes_phase_time');
            
            // Real-time vote tracking indexes
            $table->index(['debate_id', 'voted_at'], 'debate_votes_debate_time');
            $table->index(['voted_at', 'vote_type'], 'debate_votes_time_type');
            $table->index(['debate_id', 'team_id', 'vote_type'], 'debate_votes_debate_team_type');
            
            // Analytics indexes
            $table->index(['confidence_level', 'vote_type'], 'debate_votes_confidence_type');
            $table->index(['vote_phase', 'confidence_level'], 'debate_votes_phase_confidence');
            
            // Partitioning hint for large datasets
            $table->index(['voted_at', 'debate_id'], 'debate_votes_time_debate_partition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_debate_votes');
    }
}; 