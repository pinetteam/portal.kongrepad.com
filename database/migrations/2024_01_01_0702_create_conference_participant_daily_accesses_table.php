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
        // Participant daily access tracking - for analytics
        Schema::create('conference_participant_daily_accesses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('participant_id');
            $table->date('access_date'); // Access date
            $table->integer('session_count')->default(0); // Number of sessions attended that day
            $table->integer('total_minutes')->default(0); // Total active time that day (minutes)
            $table->integer('question_count')->default(0); // Number of questions asked that day
            $table->integer('poll_count')->default(0); // Number of polls participated that day
            $table->integer('login_count')->default(0); // Number of logins that day
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
            
            $table->unique(['participant_id', 'access_date'], 'participant_daily_access_unique');
            $table->index(['access_date', 'total_minutes'], 'daily_access_date_minutes_idx');
            $table->index(['access_date', 'session_count'], 'daily_access_date_sessions_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_participant_daily_accesses');
    }
}; 