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
        Schema::create('meeting_hall_program_session_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort_order')->nullable();
            $table->unsignedBigInteger('session_id')->index();
            $table->unsignedBigInteger('questioner_id')->index();
            $table->string('question', 511);
            $table->boolean('is_hidden_name')->default(0)->comment('0=no;1=yes');
            $table->boolean('selected_for_show')->default(0)->comment('0=no;1=yes');
            $table->timestamps();
            $table->foreign('session_id')->on('meeting_hall_program_sessions')->references('id');
            $table->foreign('questioner_id')->on('meeting_participants')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_program_session_questions');
    }
};
