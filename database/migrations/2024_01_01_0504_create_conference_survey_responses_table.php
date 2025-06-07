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
        Schema::create('conference_survey_responses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('survey_id')->index(); // Heavy indexed for survey queries
            $table->uuid('participant_id')->nullable()->index(); // Nullable for anonymous responses
            $table->string('session_token', 100)->nullable()->index(); // For anonymous response tracking
            $table->boolean('is_completed')->default(false)->index(); // Response completion status
            $table->datetime('started_at')->useCurrent()->index(); // Response start time
            $table->datetime('completed_at')->nullable()->index(); // Response completion time
            $table->decimal('completion_time', 8, 2)->nullable()->index(); // Time taken in minutes
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('device_type', 20)->nullable()->index(); // mobile, tablet, desktop
            
            // Response data - stored as JSON for flexibility
            $table->json('responses')->nullable(); // All question responses
            $table->decimal('score', 8, 2)->nullable()->index(); // For scored surveys/quizzes
            $table->string('grade', 10)->nullable()->index(); // A, B, C, etc.
            
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent(); // Optimized for write performance
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign keys
            $table->foreign('survey_id')->references('id')->on('conference_surveys')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
            
            // Prevent duplicate responses (unless allowed)
            $table->index(['survey_id', 'participant_id'], 'responses_survey_participant');
            $table->index(['survey_id', 'session_token'], 'responses_survey_session');
            
            // High-performance compound indexes for response analysis
            $table->index(['survey_id', 'is_completed', 'completed_at'], 'responses_survey_completed');
            $table->index(['participant_id', 'is_completed'], 'responses_participant_completed');
            $table->index(['survey_id', 'score', 'is_completed'], 'responses_survey_score_completed');
            $table->index(['completion_time', 'is_completed'], 'responses_completion_time');
            $table->index(['device_type', 'is_completed'], 'responses_device_completed');
            $table->index(['started_at', 'completed_at'], 'responses_time_range');
            
            // Analytics and reporting indexes
            $table->index(['survey_id', 'started_at'], 'responses_survey_started');
            $table->index(['grade', 'score'], 'responses_grade_score');
            $table->index(['completed_at', 'survey_id'], 'responses_completed_survey');
            
            // Time-based partitioning indexes
            $table->index(['created_at', 'survey_id'], 'responses_created_survey_partition');
            $table->index(['started_at', 'is_completed'], 'responses_started_completed_partition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_survey_responses');
    }
}; 