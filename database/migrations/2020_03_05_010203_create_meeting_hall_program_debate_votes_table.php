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
        Schema::create('meeting_hall_program_debate_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('debate_id')->index();
            $table->unsignedBigInteger('team_id')->index();
            $table->unsignedBigInteger('participant_id')->index();
            $table->timestamps();
            $table->foreign('debate_id')->on('meeting_hall_program_debates')->references('id');
            $table->foreign('team_id')->on('meeting_hall_program_debate_teams')->references('id');
            $table->foreign('participant_id')->on('meeting_participants')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_program_debate_votes');
    }
};
