<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_score_game_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qr_code_id')->index();
            $table->unsignedBigInteger('participant_id')->index();
            $table->unsignedBigInteger('point');
            $table->timestamps();
            $table->foreign('qr_code_id')->on('meeting_score_game_qr_codes')->references('id');
            $table->foreign('participant_id')->on('meeting_participants')->references('id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('meeting_score_game_points');
    }
};
