<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conference_participant_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id')->index(); // For conference-specific queries
            $table->uuid('participant_id')->index(); // For participant activity tracking
            $table->uuid('session_id')->nullable()->index(); // For session-specific tracking
            $table->string('action_type', 50)->index(); // login, logout, join_session, leave_session, ask_question, vote_poll, etc.
            $table->string('entity_type', 50)->nullable()->index(); // session, poll, question, document
            $table->uuid('entity_id')->nullable()->index(); // related entity ID
            $table->json('data')->nullable(); // action-specific data
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->decimal('session_duration', 8, 2)->nullable(); // in minutes, for session tracking
            
            // Optimized for write performance - only track creation time
            $table->timestamp('created_at')->useCurrent()->index(); // Heavy indexed for time-based queries
            // Skip updated_at for performance
            
            // Foreign keys with ON DELETE CASCADE for performance
            $table->foreign('conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            
            // High-performance compound indexes for analytics
            $table->index(['conference_id', 'action_type', 'created_at'], 'logs_conference_action_time');
            $table->index(['participant_id', 'action_type', 'created_at'], 'logs_participant_action_time');
            $table->index(['session_id', 'action_type', 'created_at'], 'logs_session_action_time');
            $table->index(['action_type', 'entity_type', 'created_at'], 'logs_action_entity_time');
            $table->index(['conference_id', 'created_at', 'action_type'], 'logs_conference_time_action');
            
            // Time-based partitioning indexes
            $table->index(['created_at', 'conference_id'], 'logs_time_conference_partition');
            $table->index(['created_at', 'participant_id'], 'logs_time_participant_partition');
        });
        
        // Add table comment for partitioning strategy
        DB::statement("ALTER TABLE conference_participant_logs COMMENT = 'Consider partitioning by created_at for large datasets'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_participant_logs');
    }
}; 