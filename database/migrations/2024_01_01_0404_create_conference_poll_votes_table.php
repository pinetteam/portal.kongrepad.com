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
        Schema::create('conference_poll_votes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('poll_id')->index(); // Heavy indexed for vote counting
            $table->uuid('option_id')->index(); // Heavy indexed for option counting
            $table->uuid('participant_id');
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('voted_at')->useCurrent()->index(); // Optimized timestamp for vote ordering
            $table->json('metadata')->nullable();
            
            // Optimized timestamps - only track creation for performance
            $table->timestamp('created_at')->useCurrent();
            // Skip updated_at for write performance

            // Foreign keys with ON DELETE CASCADE for performance
            $table->foreign('poll_id')->references('id')->on('conference_polls')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('conference_poll_options')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
            
            // Constraint to prevent duplicate votes
            $table->unique(['poll_id', 'participant_id'], 'poll_participant_unique_vote');
            
            // High-performance indexes for vote counting and analytics
            $table->index(['poll_id', 'voted_at'], 'votes_poll_time');
            $table->index(['option_id', 'voted_at'], 'votes_option_time');
            $table->index(['poll_id', 'option_id', 'voted_at'], 'votes_poll_option_time');
            $table->index(['participant_id', 'voted_at'], 'votes_participant_activity');
            
            // Partitioning hint for large datasets
            $table->index(['voted_at', 'poll_id'], 'votes_time_poll_partition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_poll_votes');
    }
}; 