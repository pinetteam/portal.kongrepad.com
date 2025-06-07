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
        Schema::create('conference_session_speakers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('session_id')->index();
            $table->uuid('participant_id')->nullable()->index();
            
            // Speaker information (simplified)
            $table->string('speaker_type', 15)->default('internal')->index(); // internal, external
            $table->string('role', 20)->default('presenter')->index(); // presenter, moderator, keynote
            $table->integer('presentation_order')->default(1)->index();
            $table->integer('duration_minutes')->default(20);
            
            // External speaker details (essential only)
            $table->string('external_name', 150)->nullable(); // Reduced from 200
            $table->string('external_email', 255)->nullable();
            $table->string('title', 100)->nullable(); // Reduced from 200
            $table->string('institution', 200)->nullable(); // Reduced from 300
            $table->string('position', 150)->nullable(); // Reduced from 200
            $table->string('country_code', 2)->nullable();
            
            // Professional info (essential only)
            $table->text('bio')->nullable();
            $table->json('specializations')->nullable();
            $table->string('linkedin_url', 250)->nullable(); // Reduced from 300
            $table->string('website_url', 250)->nullable(); // Reduced from 300
            
            // Visual materials (simplified)
            $table->string('photo_path', 300)->nullable(); // Reduced from 500
            
            // Presentation details (simplified)
            $table->string('presentation_title', 250)->nullable(); // Reduced from 500
            $table->text('presentation_abstract')->nullable();
            $table->string('presentation_language', 5)->default('en');
            $table->string('presentation_type', 20)->default('oral'); // Reduced from 30
            
            // Basic technical requirements
            $table->boolean('needs_projector')->default(true);
            $table->boolean('needs_microphone')->default(true);
            $table->text('special_requirements')->nullable();
            
            // Speaker status (simplified)
            $table->string('status', 15)->default('invited')->index(); // invited, confirmed, declined
            $table->datetime('confirmed_at')->nullable();
            $table->boolean('attended')->default(false);
            
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('session_id', 'fk_session_speakers_session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            $table->foreign('participant_id', 'fk_session_speakers_participant_id')->references('id')->on('conference_participants')->onDelete('set null');
            $table->foreign('country_code', 'fk_session_speakers_country_code')->references('code')->on('system_countries')->onDelete('set null');
            
            // Essential indexes only (reduced from 15+ to 6)
            $table->unique(['session_id', 'participant_id', 'role'], 'speakers_session_participant_role_unique');
            $table->index(['session_id', 'presentation_order'], 'speakers_session_order');
            $table->index(['speaker_type', 'status'], 'speakers_type_status');
            $table->index(['role', 'session_id'], 'speakers_role_session');
            $table->index(['status', 'confirmed_at'], 'speakers_status_confirmed');
            $table->index(['attended', 'session_id'], 'speakers_attended_session');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_session_speakers');
    }
}; 