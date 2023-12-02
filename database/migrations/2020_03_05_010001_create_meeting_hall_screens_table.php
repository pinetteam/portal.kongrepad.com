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
            $table->enum('type', ['chair', 'document', 'debate', 'keypad', 'questions', 'speaker', 'timer']);
            $table->uuid('background_name')->unique()->nullable();
            $table->string('background_extension')->nullable();
            $table->enum('font', ['Roboto', 'Hedvig Letters Serif', 'Open Sans', 'Montserrat', 'Nunito'])->default('Roboto');
            $table->unsignedInteger('font_size')->default(72);
            $table->unsignedInteger('current_object_id')->nullable();
            $table->string('font_color', 7)->default('#FFFFFF');
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
