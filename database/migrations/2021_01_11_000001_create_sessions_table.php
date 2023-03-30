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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id')->index()->nullable();
            $table->unsignedBigInteger('meeting_hall_id')->index()->nullable();
            $table->integer('sort_id')->nullable();
            $table->string('code', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->date('date')->nullable();
            $table->time('start_at', $precision = 0)->nullable();
            $table->time('finish_at', $precision = 0)->nullable();
            $table->enum('type', ['main-session', 'event', 'course', 'presentation', 'break', 'other'])->default('other');
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->softDeletes();
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('meeting_hall_id')->on('meeting_halls')->references('id');
            $table->foreign('session_id')->on('sessions')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
