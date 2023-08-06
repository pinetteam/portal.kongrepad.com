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
        Schema::create('meeting_survey_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('survey_id')->index();
            $table->unsignedBigInteger('question_id')->index();
            $table->unsignedBigInteger('option_id')->index();
            $table->unsignedBigInteger('participant_id')->index();
            $table->timestamps();
            $table->foreign('survey_id')->on('meeting_surveys')->references('id');
            $table->foreign('question_id')->on('meeting_survey_questions')->references('id');
            $table->foreign('option_id')->on('meeting_survey_question_options')->references('id');
            $table->foreign('participant_id')->on('meeting_participants')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_survey_votes');
    }
};
