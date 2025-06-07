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
        Schema::create('conference_screen_timers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('screen_id')->index();
            $table->uuid('session_id')->nullable()->index();
            $table->string('timer_name', 100); // Reduced from 200
            $table->string('timer_type', 20)->default('presentation')->index(); // presentation, qa, break
            
            // Core timer data
            $table->integer('duration_seconds')->index();
            $table->integer('elapsed_seconds')->default(0);
            $table->string('status', 15)->default('stopped')->index(); // stopped, running, paused, finished
            
            // Control timestamps (optimized)
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_updated_at')->useCurrent();
            
            // Essential display settings only
            $table->string('warning_color', 7)->default('#FFA500');
            $table->string('critical_color', 7)->default('#FF0000');
            $table->integer('warning_at_seconds')->nullable();
            
            // Basic settings
            $table->boolean('auto_start')->default(false);
            $table->boolean('sound_enabled')->default(true);
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('screen_id', 'fk_timers_screen_id')->references('id')->on('conference_screens')->onDelete('cascade');
            $table->foreign('session_id', 'fk_timers_session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            
            // ONLY essential indexes (reduced from 25+ to 5)
            $table->index(['screen_id', 'status'], 'timers_screen_status');
            $table->index(['session_id', 'timer_type'], 'timers_session_type');
            $table->index(['status', 'last_updated_at'], 'timers_status_updated');
            $table->index(['auto_start', 'session_id'], 'timers_auto_session');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_screen_timers');
    }
}; 