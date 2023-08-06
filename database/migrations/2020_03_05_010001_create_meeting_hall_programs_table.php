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
        Schema::create('meeting_hall_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hall_id')->index();
            $table->unsignedInteger('sort_order')->nullable();
            $table->string('code', 255)->nullable();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->binary('logo')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->enum('type', ['debate', 'other', 'session'])->default('session');
            $table->boolean('on_air')->default(0)->comment('0=passive;1=active');
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
        DB::statement('ALTER TABLE meeting_hall_programs MODIFY logo MEDIUMBLOB NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_programs');
    }
};
