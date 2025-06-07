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
        Schema::create('conference_venues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id')->index();
            $table->string('name', 150);
            $table->string('code', 15)->nullable()->index();
            $table->text('description')->nullable();
            $table->string('type', 20)->default('hall')->index();
            $table->integer('capacity')->default(0)->index();
            $table->string('location', 200)->nullable();
            $table->string('floor', 15)->nullable();
            $table->string('building', 80)->nullable();
            
            // Essential equipment only
            $table->boolean('has_projector')->default(false);
            $table->boolean('has_microphone')->default(false);
            $table->boolean('has_wifi')->default(true);
            $table->boolean('is_accessible')->default(true);
            
            // Contact info (simplified)
            $table->string('contact_person', 100)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_email', 255)->nullable();
            
            // Basic visual
            $table->string('image_path', 300)->nullable();
            
            // Status management
            $table->boolean('is_active')->default(true)->index();
            $table->string('status', 15)->default('available')->index();
            
            // Essential tracking only
            $table->integer('sessions_count')->default(0);
            $table->datetime('last_used_at')->nullable();
            
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('conference_id', 'fk_venues_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            
            // PRODUCTION OPTIMIZED: Essential indexes only
            $table->index(['conference_id', 'is_active'], 'venues_conference_active');
            $table->index(['code', 'conference_id'], 'venues_code_conference');
            $table->index(['type', 'capacity'], 'venues_type_capacity');
            $table->index(['status', 'is_active'], 'venues_status_active');
            $table->index(['capacity', 'type'], 'venues_capacity_type');
            $table->index(['last_used_at', 'conference_id'], 'venues_usage_conference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_venues');
    }
}; 