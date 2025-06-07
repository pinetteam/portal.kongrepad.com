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
        // Simplified roles table
        Schema::create('user_roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id')->nullable()->index();
            $table->string('name', 50); // Reduced from 100
            $table->string('slug', 50)->index(); // Reduced from 100
            $table->text('description')->nullable();
            $table->string('level', 15)->default('user')->index(); // admin, manager, user
            $table->boolean('is_active')->default(true)->index();
            $table->json('permissions')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('tenant_id', 'fk_user_roles_tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            
            // Essential indexes only
            $table->unique(['tenant_id', 'slug'], 'roles_tenant_slug_unique');
            $table->index(['tenant_id', 'is_active'], 'roles_tenant_active');
            $table->index(['level', 'is_active'], 'roles_level_active');
        });

        // Simplified assignments table
        Schema::create('user_role_assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('role_id')->index();
            $table->uuid('tenant_id')->nullable()->index();
            $table->uuid('conference_id')->nullable()->index(); // Conference-specific roles
            $table->string('status', 15)->default('active')->index(); // active, suspended
            $table->datetime('assigned_at')->useCurrent();
            $table->datetime('expires_at')->nullable()->index();
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id', 'fk_role_assignments_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id', 'fk_role_assignments_role_id')->references('id')->on('user_roles')->onDelete('cascade');
            $table->foreign('tenant_id', 'fk_role_assignments_tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            
            // Essential indexes only
            $table->unique(['user_id', 'role_id', 'conference_id'], 'user_role_conference_unique');
            $table->index(['user_id', 'status'], 'assignments_user_status');
            $table->index(['tenant_id', 'status'], 'assignments_tenant_status');
            $table->index(['conference_id', 'status'], 'assignments_conference_status');
            $table->index(['expires_at', 'status'], 'assignments_expiry_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role_assignments');
        Schema::dropIfExists('user_roles');
    }
}; 