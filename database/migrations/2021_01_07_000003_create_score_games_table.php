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
        Schema::create('score_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meeting_id')->index();
            $table->string('title', 511);
            $table->datetime('start_at');
            $table->datetime('finish_at');
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->json('types');
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->softDeletes();
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('meeting_id')->on('meetings')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('score_games');
    }
};
