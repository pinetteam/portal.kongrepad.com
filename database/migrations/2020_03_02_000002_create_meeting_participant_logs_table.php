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
        Schema::create('meeting_participant_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id')->index();
            $table->string('action', 511);
            $table->string('object', 511);
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
        Schema::dropIfExists('meeting_participant_logs');
    }
};
