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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id')->nullable()->index(); // For multi-tenancy
            $table->string('username', 80)->unique(); // Reduced from 100
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('first_name', 80); // Reduced from 100
            $table->string('last_name', 80); // Reduced from 100
            $table->string('phone', 20)->nullable();
            $table->string('avatar_path', 300)->nullable(); // Reduced from 500
            $table->string('status', 15)->default('active')->index(); // Reduced from 20
            $table->datetime('last_login_at')->nullable()->index();
            $table->string('last_ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable(); // Reduced from 500
            $table->boolean('is_super_admin')->default(false)->index();
            $table->boolean('force_password_change')->default(false);
            $table->datetime('password_changed_at')->nullable();
            $table->integer('failed_login_attempts')->default(0)->index();
            $table->datetime('locked_until')->nullable()->index();
            $table->json('permissions')->nullable();
            $table->json('settings')->nullable();
            $table->json('metadata')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('tenant_id', 'fk_users_tenant_id')->references('id')->on('tenants')->onDelete('set null');
            
            // Essential indexes only (reduced from 10 to 6)
            $table->index(['email', 'status'], 'users_email_status');
            $table->index(['username', 'status'], 'users_username_status');
            $table->index(['tenant_id', 'status'], 'users_tenant_status');
            $table->index(['status', 'last_login_at'], 'users_status_activity');
            $table->index(['failed_login_attempts', 'locked_until'], 'users_security_lockout');
            $table->index(['is_super_admin', 'status'], 'users_super_admin_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}; 