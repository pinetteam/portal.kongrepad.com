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
        // QR code-based point collection system
        Schema::create('conference_score_game_qr_codes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('score_game_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('code')->unique(); // QR code value
            $table->integer('points'); // Points to be awarded from this QR code
            $table->datetime('start_at'); // QR code activation time
            $table->datetime('end_at'); // QR code deactivation time
            $table->boolean('is_active')->default(true);
            $table->boolean('is_single_use')->default(false); // Single use only?
            $table->integer('max_scans')->nullable(); // Maximum scan count
            $table->integer('current_scans')->default(0); // Current scan count
            $table->string('location')->nullable(); // QR code location
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('score_game_id')->references('id')->on('conference_score_games')->onDelete('cascade');
            
            $table->index(['score_game_id', 'is_active']);
            $table->index(['code', 'is_active']);
            $table->index(['start_at', 'end_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_score_game_qr_codes');
    }
}; 