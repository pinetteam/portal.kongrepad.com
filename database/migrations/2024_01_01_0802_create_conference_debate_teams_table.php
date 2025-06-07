<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conference_debate_teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('debate_id');
            $table->uuid('participant_id');
            $table->string('side'); // for, against, moderator
            $table->string('role')->default('speaker'); // speaker, lead, moderator
            $table->integer('speaking_order')->nullable();
            $table->integer('speaking_time_used')->default(0); // seconds
            $table->boolean('is_confirmed')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('debate_id')->references('id')->on('conference_debates')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
            
            $table->unique(['debate_id', 'participant_id']);
            $table->index(['debate_id', 'side', 'speaking_order']);
            $table->index(['participant_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conference_debate_teams');
    }
}; 