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
            $table->unsignedBigInteger('owner_id')->index();
            $table->string('title', 255);
            $table->boolean('on_screen')->default(0)->comment('0=passive;1=active');
            $table->timestamps();
            $table->boolean('status')->default(0)->comment('0=passive;1=active');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('edited_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('edited_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('session_id')->on('meeting_hall_program_sessions')->references('id');
            $table->foreign('owner_id')->on('meeting_participants')->references('id');
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
