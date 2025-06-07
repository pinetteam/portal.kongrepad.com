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
        // Tenant-specific settings - each customer's custom configurations
        Schema::create('tenant_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('key', 100)->index(); // Setting key
            $table->longText('value')->nullable(); // Setting value (can be JSON)
            $table->string('type', 20)->default('string')->index(); // string, json, boolean, integer, decimal
            $table->text('description')->nullable();
            $table->string('group', 50)->default('general')->index(); // general, email, payment, features, etc.
            $table->boolean('is_public')->default(false)->index(); // Can be accessed by frontend
            $table->boolean('is_encrypted')->default(false); // Sensitive data encryption
            $table->timestamps();

            // Foreign keys
            $table->foreign('tenant_id', 'fk_tenant_settings_tenant_id')->references('id')->on('tenants')->onDelete('cascade');

            $table->unique(['tenant_id', 'key'], 'tenant_settings_unique');
            $table->index(['tenant_id', 'group'], 'tenant_settings_group');
            $table->index(['tenant_id', 'is_public'], 'tenant_settings_public');
            $table->index(['type', 'group'], 'tenant_settings_type_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_settings');
    }
}; 