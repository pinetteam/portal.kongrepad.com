<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_sessions', function (Blueprint $table) {
            $table->string('id', 255)->primary(); // Session ID - primary key
            $table->uuid('user_id')->nullable()->index(); // User association for logged-in users
            $table->uuid('tenant_id')->nullable()->index(); // Multi-tenant session tracking
            $table->string('ip_address', 45)->nullable()->index(); // Client IP for security
            $table->text('user_agent')->nullable(); // Browser/device info
            $table->longText('payload'); // Session data
            $table->integer('last_activity')->index(); // Unix timestamp for activity tracking
            
            // Additional session tracking for performance
            $table->boolean('is_active')->default(true)->index(); // Active session flag
            $table->string('device_type', 20)->nullable()->index(); // mobile, tablet, desktop
            $table->datetime('created_at')->nullable(); // Session creation time
            $table->datetime('expires_at')->nullable()->index(); // Session expiration
            
            // High-performance compound indexes for session management
            $table->index(['user_id', 'last_activity'], 'sessions_user_activity');
            $table->index(['tenant_id', 'last_activity'], 'sessions_tenant_activity');
            $table->index(['ip_address', 'last_activity'], 'sessions_ip_activity');
            $table->index(['is_active', 'last_activity'], 'sessions_active_activity');
            $table->index(['device_type', 'last_activity'], 'sessions_device_activity');
            $table->index(['expires_at', 'is_active'], 'sessions_expiry_active');
            
            // Session cleanup indexes
            $table->index(['last_activity', 'expires_at'], 'sessions_cleanup');
            $table->index(['created_at', 'tenant_id'], 'sessions_created_tenant');
            
            // Security monitoring indexes
            $table->index(['user_id', 'ip_address', 'last_activity'], 'sessions_user_ip_activity');
            $table->index(['tenant_id', 'ip_address'], 'sessions_tenant_ip');
        });
        
        // Set table engine for performance
        DB::statement('ALTER TABLE system_sessions ENGINE = InnoDB');
        DB::statement("ALTER TABLE system_sessions COMMENT = 'Optimized Laravel session table for high-concurrency applications'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_sessions');
    }
}; 