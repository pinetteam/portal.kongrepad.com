<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meeting_hall_program_debates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort_order')->nullable();
            $table->unsignedBigInteger('program_id')->index();
            $table->string('code', 255)->nullable();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->dateTime('voting_started_at')->nullable();
            $table->dateTime('voting_finished_at')->nullable();
            $table->boolean('on_vote')->default(0)->comment('0=passive;1=active');
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('updated_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('program_id')->on('meeting_hall_programs')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_program_debates');
    }
};
