<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Katılımcıların topladığı puanlar
        Schema::create('conference_score_game_points', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('qr_code_id');
            $table->uuid('participant_id');
            $table->integer('points'); // Alınan puan
            $table->string('action')->nullable(); // qr_scan, session_attend, poll_vote, question_ask
            $table->string('ip_address', 45)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('qr_code_id')->references('id')->on('conference_score_game_qr_codes')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
            
            $table->unique(['qr_code_id', 'participant_id']); // Aynı QR'dan birden fazla puan almasın
            $table->index(['participant_id', 'points']);
            $table->index(['qr_code_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conference_score_game_points');
    }
}; 