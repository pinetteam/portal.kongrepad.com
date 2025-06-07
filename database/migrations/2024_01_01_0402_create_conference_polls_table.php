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
        Schema::create('conference_polls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->uuid('session_id')->nullable();
            $table->string('title', 500);
            $table->text('description')->nullable();
            $table->string('type', 20)->default('single')->index(); // single, multiple, rating, text
            $table->string('status', 20)->default('draft')->index(); // draft, active, ended, archived
            $table->boolean('is_anonymous')->default(false)->index();
            $table->boolean('show_results')->default(true);
            $table->boolean('allow_multiple_votes')->default(false);
            $table->datetime('start_at')->nullable()->index(); // For scheduled polls
            $table->datetime('end_at')->nullable()->index();
            $table->integer('max_votes')->nullable();
            
            // Real-time counters for performance
            $table->integer('total_votes')->default(0)->index(); // Cached count for performance
            $table->integer('total_participants')->default(0)->index(); // Unique voters count
            $table->datetime('last_vote_at')->nullable()->index(); // For activity tracking
            
            $table->json('settings')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            
            // High-performance compound indexes
            $table->index(['conference_id', 'status', 'start_at'], 'polls_conference_status_start');
            $table->index(['session_id', 'status', 'is_anonymous'], 'polls_session_status_anonymous');
            $table->index(['status', 'start_at', 'end_at'], 'polls_status_time_range');
            $table->index(['conference_id', 'total_votes', 'last_vote_at'], 'polls_activity_tracking');
            $table->index(['type', 'status', 'conference_id'], 'polls_type_status_conference');
            $table->index(['is_anonymous', 'show_results', 'status'], 'polls_display_settings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_polls');
    }
}; 