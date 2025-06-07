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
        Schema::create('conference_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->uuid('session_id')->nullable();
            $table->uuid('participant_id');
            $table->text('content');
            $table->string('status', 20)->default('pending')->index(); // pending, approved, rejected, archived
            $table->string('priority', 20)->default('normal')->index(); // low, normal, high, urgent
            $table->boolean('is_anonymous')->default(false)->index();
            $table->boolean('is_featured')->default(false)->index(); // For highlighting important questions
            $table->string('moderator_note', 1000)->nullable();
            $table->datetime('approved_at')->nullable()->index();
            $table->uuid('approved_by')->nullable();
            
            // Engagement metrics for sorting
            $table->integer('likes_count')->default(0)->index(); // For question popularity
            $table->integer('views_count')->default(0)->index(); // For engagement tracking
            $table->datetime('last_activity_at')->nullable()->index(); // For activity-based sorting
            
            $table->json('tags')->nullable(); // For categorization
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            
            // High-performance compound indexes for real-time Q&A
            $table->index(['conference_id', 'status', 'is_featured'], 'questions_conference_status_featured');
            $table->index(['session_id', 'status', 'priority'], 'questions_session_status_priority');
            $table->index(['status', 'approved_at', 'priority'], 'questions_status_approved_priority');
            $table->index(['conference_id', 'likes_count', 'status'], 'questions_conference_likes_status');
            $table->index(['session_id', 'last_activity_at', 'status'], 'questions_session_activity_status');
            $table->index(['participant_id', 'status', 'created_at'], 'questions_participant_status_created');
            $table->index(['is_anonymous', 'status', 'session_id'], 'questions_anonymous_status_session');
            $table->index(['priority', 'status', 'created_at'], 'questions_priority_status_created');
            
            // Performance indexes for moderation
            $table->index(['status', 'created_at'], 'questions_moderation_queue');
            $table->index(['approved_by', 'approved_at', 'status'], 'questions_moderation_tracking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_questions');
    }
}; 