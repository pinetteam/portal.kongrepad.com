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
        Schema::create('conference_screens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->uuid('venue_id');
            $table->uuid('session_id')->nullable()->index();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->string('screen_code', 30)->unique()->index();
            
            // Screen configuration (simplified)
            $table->string('type', 20)->index(); // timer, presentation, questions, polls
            $table->string('layout', 20)->default('default')->index(); // default, fullscreen, split
            $table->string('orientation', 15)->default('landscape'); // landscape, portrait
            
            // Visual settings (essential only)
            $table->string('background_color', 7)->default('#000000');
            $table->string('font_color', 7)->default('#FFFFFF');
            $table->integer('font_size')->default(48);
            $table->string('theme', 20)->default('dark')->index();
            
            // Connection management (simplified)
            $table->string('websocket_channel', 50)->unique()->index(); // Reduced from 100
            $table->string('connection_status', 15)->default('disconnected')->index(); // Reduced from 20
            $table->datetime('last_connected_at')->nullable();
            
            // Current display state (essential only)
            $table->string('current_content_type', 30)->nullable()->index(); // Reduced from 50
            $table->json('current_data')->nullable();
            $table->datetime('content_updated_at')->nullable();
            $table->boolean('auto_sync')->default(true);
            
            // Control settings
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_controllable')->default(true);
            $table->integer('sort_order')->default(0)->index();
            
            $table->json('settings')->nullable(); // Merged all settings
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('conference_id', 'fk_screens_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('venue_id', 'fk_screens_venue_id')->references('id')->on('conference_venues')->onDelete('cascade');
            $table->foreign('session_id', 'fk_screens_session_id')->references('id')->on('conference_sessions')->onDelete('set null');
            
            // Essential indexes only (reduced from 15 to 6)
            $table->index(['conference_id', 'venue_id'], 'screens_conference_venue');
            $table->index(['venue_id', 'type'], 'screens_venue_type');
            $table->index(['connection_status', 'last_connected_at'], 'screens_connection');
            $table->index(['session_id', 'auto_sync'], 'screens_session_sync');
            $table->index(['current_content_type', 'is_active'], 'screens_content_active');
            $table->index(['type', 'is_active'], 'screens_type_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_screens');
    }
}; 