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
        Schema::create('meeting_surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort_order')->nullable();
            $table->unsignedBigInteger('meeting_id')->index();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->boolean('on_air')->default(0)->comment('0=passive;1=active');
            $table->boolean('status')->default(0)->comment('0=passive;1=active');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('edited_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('edited_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('meeting_id')->on('meetings')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_surveys');
    }
};
