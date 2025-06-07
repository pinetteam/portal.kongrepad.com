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
        Schema::create('conference_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->uuid('session_id')->nullable();
            $table->string('title', 250);
            $table->text('content');
            $table->string('type', 20)->default('general')->index();
            $table->string('status', 15)->default('draft')->index();
            $table->string('priority', 15)->default('normal')->index();
            $table->datetime('published_at')->nullable()->index();
            $table->datetime('expires_at')->nullable()->index();
            $table->string('target_audience', 30)->default('all')->index();
            
            $table->integer('sent_count')->default(0)->index();
            $table->datetime('last_sent_at')->nullable();
            
            $table->json('notification_settings')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('conference_id', 'fk_notifications_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('session_id', 'fk_notifications_session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            
            $table->index(['conference_id', 'status'], 'notifications_conference_status');
            $table->index(['session_id', 'status'], 'notifications_session_status');
            $table->index(['status', 'published_at'], 'notifications_status_published');
            $table->index(['type', 'target_audience'], 'notifications_type_audience');
            $table->index(['priority', 'status'], 'notifications_priority_status');
            $table->index(['expires_at', 'status'], 'notifications_expiry_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_notifications');
    }
}; 