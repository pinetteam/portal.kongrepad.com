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
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 255)->index(); // Heavy indexed for email lookups
            $table->string('token', 255)->index(); // Token for reset process
            $table->timestamp('created_at')->nullable()->index(); // Token creation time
            $table->timestamp('expires_at')->nullable()->index(); // Token expiration time
            $table->string('ip_address', 45)->nullable()->index(); // Request IP for security
            $table->string('user_agent', 500)->nullable(); // Browser info for security
            $table->boolean('is_used')->default(false)->index(); // Token usage status
            $table->datetime('used_at')->nullable()->index(); // When token was used
            $table->string('user_type', 20)->default('user')->index(); // user, participant
            $table->uuid('user_id')->nullable()->index(); // Associated user/participant ID
            
            // Security tracking
            $table->integer('attempts_count')->default(0)->index(); // Reset attempts
            $table->datetime('last_attempt_at')->nullable()->index(); // Last attempt time
            $table->string('reset_method', 20)->default('email')->index(); // email, sms
            
            // Primary key on email for performance
            $table->primary('email');
            
            // High-performance compound indexes for password reset security
            $table->index(['token', 'expires_at'], 'reset_tokens_token_expiry');
            $table->index(['email', 'is_used', 'expires_at'], 'reset_tokens_email_used_expiry');
            $table->index(['created_at', 'expires_at'], 'reset_tokens_created_expiry');
            $table->index(['is_used', 'used_at'], 'reset_tokens_used_time');
            $table->index(['ip_address', 'created_at'], 'reset_tokens_ip_created');
            $table->index(['user_type', 'user_id'], 'reset_tokens_user_type_id');
            $table->index(['attempts_count', 'last_attempt_at'], 'reset_tokens_attempts_tracking');
            
            // Security monitoring indexes
            $table->index(['email', 'attempts_count'], 'reset_tokens_email_attempts');
            $table->index(['ip_address', 'attempts_count'], 'reset_tokens_ip_attempts');
            $table->index(['created_at', 'ip_address'], 'reset_tokens_created_ip');
            
            // Cleanup indexes
            $table->index(['expires_at', 'is_used'], 'reset_tokens_cleanup');
            $table->index(['used_at', 'is_used'], 'reset_tokens_used_cleanup');
        });
        
        // Add table comment for security monitoring
        DB::statement("ALTER TABLE password_reset_tokens COMMENT = 'Optimized password reset tokens with security monitoring'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
}; 