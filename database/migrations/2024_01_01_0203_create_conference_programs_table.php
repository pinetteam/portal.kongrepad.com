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
        Schema::create('conference_programs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id')->index();
            $table->string('title', 250);
            $table->text('description')->nullable();
            $table->string('program_code', 30)->nullable()->index();
            $table->string('type', 20)->default('session')->index();
            $table->string('track', 80)->nullable()->index();
            $table->string('language', 5)->default('en')->index();
            
            // Basic classification (simplified)
            $table->string('category', 80)->nullable()->index();
            $table->json('keywords')->nullable();
            
            // Timing and scheduling (essential only)
            $table->date('program_date')->index();
            $table->time('start_time')->index();
            $table->time('end_time')->index();
            $table->integer('duration_minutes')->index();
            $table->integer('sort_order')->default(0)->index();
            
            // Program management (simplified)
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_published')->default(false)->index();
            $table->integer('max_participants')->nullable()->index();
            $table->string('status', 15)->default('scheduled')->index();
            
            // Coordinator (essential only)
            $table->string('coordinator_name', 150)->nullable();
            $table->string('coordinator_email', 255)->nullable();
            
            // Materials (simplified)
            $table->string('banner_image', 300)->nullable();
            $table->json('materials')->nullable();
            
            // Performance tracking (essential only)
            $table->integer('participants_count')->default(0)->index();
            $table->datetime('last_activity_at')->nullable()->index();
            
            $table->json('settings')->nullable(); // Consolidated settings
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('conference_id', 'fk_programs_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            
            // Essential indexes only (reduced from 15+ to 7)
            $table->index(['conference_id', 'program_date'], 'programs_conference_date');
            $table->index(['conference_id', 'is_active'], 'programs_conference_active');
            $table->index(['type', 'status'], 'programs_type_status');
            $table->index(['program_date', 'start_time'], 'programs_date_time');
            $table->index(['status', 'is_published'], 'programs_status_published');
            $table->index(['participants_count', 'max_participants'], 'programs_capacity');
            $table->index(['last_activity_at', 'status'], 'programs_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_programs');
    }
}; 