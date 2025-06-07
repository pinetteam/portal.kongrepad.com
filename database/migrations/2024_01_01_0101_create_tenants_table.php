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
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 200);
            $table->string('slug', 100)->unique()->index(); // Heavy indexed for domain resolution
            $table->string('domain', 150)->unique()->index(); // Heavy indexed for subdomain resolution
            $table->string('email', 255);
            $table->string('phone', 20)->nullable();
            $table->text('description')->nullable();
            $table->string('logo_path', 500)->nullable();
            $table->string('favicon_path', 500)->nullable();
            $table->string('status', 20)->default('active')->index(); // active, suspended, expired, trial
            $table->string('plan_type', 30)->default('basic')->index(); // basic, premium, enterprise
            $table->integer('max_conferences')->default(5)->index(); // Plan limitations
            $table->integer('max_participants')->default(1000)->index();
            $table->datetime('trial_ends_at')->nullable()->index(); // Trial expiration
            $table->datetime('subscription_expires_at')->nullable()->index(); // Subscription expiration
            $table->boolean('is_active')->default(true)->index(); // Quick active check
            
            // Performance tracking
            $table->integer('conferences_count')->default(0)->index(); // Current conference count
            $table->datetime('last_activity_at')->nullable()->index(); // Last tenant activity
            
            $table->json('settings')->nullable(); // Tenant-specific configurations
            $table->json('features')->nullable(); // Enabled features
            $table->json('branding')->nullable(); // Custom branding settings
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // High-performance compound indexes for tenant resolution
            $table->index(['slug', 'is_active'], 'tenants_slug_active');
            $table->index(['domain', 'is_active'], 'tenants_domain_active');
            $table->index(['status', 'plan_type'], 'tenants_status_plan');
            $table->index(['trial_ends_at', 'status'], 'tenants_trial_status');
            $table->index(['subscription_expires_at', 'status'], 'tenants_subscription_status');
            $table->index(['last_activity_at', 'is_active'], 'tenants_activity_tracking');
            $table->index(['conferences_count', 'max_conferences'], 'tenants_conference_limits');
            
            // Business intelligence indexes
            $table->index(['plan_type', 'status', 'created_at'], 'tenants_plan_status_created');
            $table->index(['status', 'last_activity_at'], 'tenants_status_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}; 