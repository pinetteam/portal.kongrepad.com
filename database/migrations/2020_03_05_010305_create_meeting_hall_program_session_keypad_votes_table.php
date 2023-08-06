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
        Schema::create('meeting_hall_program_session_keypad_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('option_id')->index();
            $table->unsignedBigInteger('participant_id')->index();
            $table->timestamps();
            $table->foreign('option_id')->on('meeting_hall_program_session_keypad_options')->references('id');
            $table->foreign('participant_id')->on('meeting_participants')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_program_session_keypad_votes');
    }
};
