<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_hall_screen_timers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('screen_id')->index();
            $table->unsignedBigInteger('started_at')->nullable();
            $table->double('time')->index()->default(0);
            $table->double('time_left')->index()->default(0);
            $table->boolean('status')->default(0)->comment('0=passive;1=active');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('updated_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('screen_id')->on('meeting_hall_screens')->references('id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_screen_timers');
    }
};
