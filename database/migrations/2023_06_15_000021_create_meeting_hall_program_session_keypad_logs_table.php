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
        Schema::create('meeting_hall_program_session_keypad_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('keypad_id')->constrained('meeting_hall_program_session_keypads', 'id')->onDelete('cascade');
            $table->string('action')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_program_session_keypad_logs');
    }
}; 