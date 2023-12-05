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
        Schema::create('meeting_hall_program_session_question_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id')->index();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->enum('action', ['select', 'deselect']);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('question_id')->on('meeting_hall_program_session_questions')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_program_session_question_logs');
    }
};
