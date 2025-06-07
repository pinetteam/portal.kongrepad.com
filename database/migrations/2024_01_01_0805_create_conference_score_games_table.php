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
        Schema::create('conference_score_games', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->uuid('session_id')->nullable();
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->string('type', 20)->default('qr_hunt')->index(); // qr_hunt, quiz, trivia, scavenger, networking
            $table->string('status', 15)->default('draft')->index(); // draft, active, paused, ended, archived
            $table->datetime('start_at')->nullable()->index();
            $table->datetime('end_at')->nullable()->index();
            $table->integer('max_points')->default(100)->index(); // Maximum possible points
            $table->integer('time_limit')->nullable(); // Time limit in minutes
            $table->boolean('is_team_based')->default(false);
            $table->integer('max_team_size')->nullable();
            
            // Essential tracking only
            $table->integer('participants_count')->default(0)->index();
            $table->integer('total_qr_codes')->default(0)->index();
            $table->datetime('last_activity_at')->nullable()->index();
            
            // Basic settings
            $table->boolean('show_leaderboard')->default(true);
            $table->string('scoring_method', 20)->default('points')->index(); // points, time_based, completion
            
            $table->json('game_rules')->nullable(); // Game-specific rules
            $table->json('settings')->nullable(); // Consolidated settings
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('conference_id', 'fk_score_games_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('session_id', 'fk_score_games_session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            
            // Essential indexes only (reduced from 15+ to 6)
            $table->index(['conference_id', 'status'], 'score_games_conference_status');
            $table->index(['session_id', 'status'], 'score_games_session_status');
            $table->index(['type', 'status'], 'score_games_type_status');
            $table->index(['start_at', 'end_at'], 'score_games_time_range');
            $table->index(['participants_count', 'status'], 'score_games_participants_status');
            $table->index(['last_activity_at', 'status'], 'score_games_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_score_games');
    }
}; 