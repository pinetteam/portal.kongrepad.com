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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id')->nullable()->index(); // Multi-tenant settings
            $table->string('key', 100)->index(); // Setting key
            $table->longText('value')->nullable(); // Setting value (can be large JSON)
            $table->string('type', 20)->default('string')->index(); // string, json, boolean, integer, decimal, file
            $table->text('description')->nullable();
            $table->string('category', 50)->default('general')->index(); // general, email, payment, security, features
            $table->string('group', 50)->nullable()->index(); // Sub-grouping within category
            $table->boolean('is_public')->default(false)->index(); // Can be accessed by frontend
            $table->boolean('is_encrypted')->default(false); // Sensitive data encryption
            $table->boolean('is_system')->default(false)->index(); // System-wide vs tenant-specific
            $table->boolean('is_readonly')->default(false); // Cannot be modified via UI
            $table->integer('sort_order')->default(0)->index(); // Display order
            
            // Validation and constraints
            $table->json('validation_rules')->nullable(); // Validation rules
            $table->json('allowed_values')->nullable(); // Predefined options (for enums)
            $table->string('default_value', 1000)->nullable(); // Default value
            $table->text('help_text')->nullable(); // Help text for UI
            
            // Versioning and audit
            $table->string('version', 10)->default('1.0');
            $table->boolean('requires_restart')->default(false); // System restart required
            $table->datetime('last_modified_at')->nullable()->index();
            $table->uuid('modified_by')->nullable(); // User who modified
            
            // Environment specific
            $table->string('environment', 20)->default('all')->index(); // all, production, staging, development
            $table->boolean('is_feature_flag')->default(false)->index(); // Feature toggle
            
            $table->json('metadata')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('tenant_id', 'fk_system_settings_tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            
            $table->unique(['tenant_id', 'key', 'environment'], 'system_settings_unique');
            $table->index(['tenant_id', 'category', 'is_public'], 'system_settings_tenant_category_public');
            $table->index(['category', 'group', 'sort_order'], 'system_settings_category_group_sort');
            $table->index(['is_system', 'is_public'], 'system_settings_system_public');
            $table->index(['is_feature_flag', 'environment'], 'system_settings_feature_env');
            $table->index(['last_modified_at', 'modified_by'], 'system_settings_audit');
            $table->index(['type', 'category'], 'system_settings_type_category');
            $table->index(['requires_restart', 'last_modified_at'], 'system_settings_restart_tracking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
}; 