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
        Schema::create('conference_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id')->index();
            $table->uuid('program_id')->index();
            $table->uuid('venue_id')->index();
            $table->string('title', 300);
            $table->text('description')->nullable();
            
            // Session information (simplified)
            $table->string('session_code', 30)->nullable()->index(); // Reduced from 50
            $table->string('presentation_type', 20)->default('oral')->index(); // Reduced from 30
            $table->string('language', 5)->default('en')->index();
            
            // Timing
            $table->datetime('start_at')->index();
            $table->datetime('end_at')->index();
            $table->integer('duration_minutes')->index();
            
            // Session management (simplified)
            $table->string('type', 20)->default('presentation')->index(); // Reduced from 30
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_live')->default(false)->index();
            $table->boolean('allow_questions')->default(true);
            $table->boolean('allow_polls')->default(true);
            $table->integer('sort_order')->default(0)->index();
            
            // Essential content only
            $table->text('abstract')->nullable();
            $table->json('keywords')->nullable();
            
            // Session chair (simplified)
            $table->string('chair_name', 150)->nullable(); // Reduced from 200
            $table->string('chair_institution', 200)->nullable(); // Reduced from 300
            
            // Media (essential only)
            $table->string('stream_url', 300)->nullable(); // Reduced from 500
            $table->string('recording_url', 300)->nullable(); // Reduced from 500
            $table->json('documents')->nullable();
            
            // Performance tracking (essential only)
            $table->integer('participants_count')->default(0)->index();
            $table->integer('questions_count')->default(0);
            $table->datetime('last_activity_at')->nullable()->index();
            
            $table->json('settings')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('conference_id', 'fk_sessions_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('program_id', 'fk_sessions_program_id')->references('id')->on('conference_programs')->onDelete('cascade');
            $table->foreign('venue_id', 'fk_sessions_venue_id')->references('id')->on('conference_venues')->onDelete('cascade');
            
            // Essential indexes only (reduced from 18 to 8)
            $table->index(['program_id', 'sort_order'], 'sessions_program_sort');
            $table->index(['conference_id', 'start_at'], 'sessions_conference_start');
            $table->index(['venue_id', 'start_at'], 'sessions_venue_start');
            $table->index(['presentation_type', 'is_active'], 'sessions_type_active');
            $table->index(['session_code', 'conference_id'], 'sessions_code_conference');
            $table->index(['type', 'is_active'], 'sessions_type_status');
            $table->index(['is_live', 'conference_id'], 'sessions_live_conference');
            $table->index(['last_activity_at', 'is_live'], 'sessions_activity_live');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_sessions');
    }
}; 