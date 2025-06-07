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
        Schema::create('conference_participants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->string('username', 80)->unique();
            $table->string('email', 255);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->string('phone', 20)->nullable();
            $table->string('organization', 150)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar_path', 300)->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('language', 5)->default('en');
            $table->string('type', 15)->default('attendee')->index();
            $table->string('status', 15)->default('pending')->index();
            $table->boolean('is_active')->default(true)->index();
            $table->datetime('approved_at')->nullable();
            $table->uuid('approved_by')->nullable();
            $table->datetime('last_seen_at')->nullable()->index();
            $table->string('last_ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->json('permissions')->nullable();
            $table->json('settings')->nullable();
            $table->json('metadata')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('conference_id', 'fk_participants_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('country_code', 'fk_participants_country_code')->references('code')->on('system_countries')->onDelete('set null');
            $table->foreign('approved_by', 'fk_participants_approved_by')->references('id')->on('users')->onDelete('set null');
            
            $table->index(['conference_id', 'status', 'is_active'], 'participants_conference_status_active');
            $table->index(['conference_id', 'type', 'is_active'], 'participants_conference_type_active');
            $table->index(['email', 'conference_id'], 'participants_email_conference');
            $table->index(['username', 'is_active'], 'participants_username_active');
            $table->index(['last_seen_at', 'is_active'], 'participants_activity_tracking');
            $table->index(['status', 'approved_at'], 'participants_approval_tracking');
            $table->index(['type', 'status', 'conference_id'], 'participants_type_status_conference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_participants');
    }
}; 