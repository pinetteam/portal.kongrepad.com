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
        Schema::create('meeting_participant_daily_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id')->index();
            $table->date('day');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('participant_id')->on('meeting_participants')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_participant_daily_accesses');
    }
};
