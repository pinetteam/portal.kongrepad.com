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
        Schema::create('conferences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id')->index(); // Heavy indexed for multi-tenancy
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('slug', 100)->unique()->index();
            $table->string('status', 15)->default('draft')->index();
            $table->string('type', 25)->default('conference')->index();
            $table->datetime('start_date')->index();
            $table->datetime('end_date')->index();
            $table->string('timezone', 30)->default('UTC');
            $table->string('language', 5)->default('en')->index();
            $table->boolean('is_public')->default(false)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('require_approval')->default(true)->index();
            $table->integer('max_participants')->nullable()->index();
            
            // Essential counters only (removed redundant ones)
            $table->integer('participants_count')->default(0)->index();
            $table->datetime('last_activity_at')->nullable()->index();
            
            // Conference content (optimized paths)
            $table->string('cover_image_path', 300)->nullable();
            $table->string('logo_path', 300)->nullable();
            $table->json('organizers')->nullable();
            $table->json('contact_info')->nullable();
            
            // Configuration
            $table->json('settings')->nullable(); // Merged features, branding into settings
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('tenant_id', 'fk_conferences_tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            
            // Essential indexes only (reduced from 16 to 8)
            $table->index(['tenant_id', 'status', 'start_date'], 'conferences_tenant_status_start');
            $table->index(['status', 'is_public', 'start_date'], 'conferences_status_public_start');
            $table->index(['type', 'status'], 'conferences_type_status');
            $table->index(['is_featured', 'status'], 'conferences_featured_status');
            $table->index(['start_date', 'end_date'], 'conferences_date_range');
            $table->index(['participants_count', 'max_participants'], 'conferences_capacity');
            $table->index(['last_activity_at', 'status'], 'conferences_activity');
            $table->index(['require_approval', 'status'], 'conferences_approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
}; 