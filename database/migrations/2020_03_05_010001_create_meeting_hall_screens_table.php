<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_hall_screens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hall_id')->index();
            $table->string('code', 255)->nullable();
            $table->string('title', 511);
            $table->text('description')->nullable();
            $table->enum('type', ['chair', 'document', 'questions', 'speaker']);
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('updated_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('hall_id')->on('meeting_halls')->references('id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_screens');
    }
};
