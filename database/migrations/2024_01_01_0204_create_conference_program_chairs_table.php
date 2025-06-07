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
        Schema::create('conference_program_chairs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->uuid('program_id')->nullable()->index();
            $table->uuid('participant_id')->nullable()->index();
            
            // Chair information (simplified)
            $table->string('name', 150); // Reduced from 200
            $table->string('academic_title', 50)->nullable(); // Reduced from 100
            $table->string('position', 200)->nullable(); // Reduced from 300
            $table->string('institution', 200)->nullable(); // Reduced from 300
            $table->string('department', 150)->nullable(); // Reduced from 200
            $table->string('email', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar_path', 300)->nullable(); // Reduced from 500
            
            // Role and status (simplified)
            $table->string('chair_type', 20)->default('session')->index(); // Reduced from 30
            $table->string('role', 20)->default('chair')->index(); // Reduced from 30
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_main_chair')->default(false)->index();
            $table->boolean('show_in_program')->default(true)->index();
            
            // Contact links (simplified)
            $table->string('website_url', 300)->nullable(); // Reduced from 500
            $table->string('linkedin_url', 300)->nullable(); // Reduced from 500
            
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('conference_id', 'fk_chairs_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('program_id', 'fk_chairs_program_id')->references('id')->on('conference_programs')->onDelete('cascade');
            
            // Essential indexes only (reduced from 12 to 6)
            $table->unique(['conference_id', 'program_id', 'participant_id', 'chair_type'], 'unique_conference_program_participant_chair');
            $table->index(['conference_id', 'chair_type'], 'chairs_conference_type');
            $table->index(['program_id', 'role'], 'chairs_program_role');
            $table->index(['chair_type', 'is_main_chair'], 'chairs_type_main');
            $table->index(['show_in_program', 'sort_order'], 'chairs_show_sort');
            $table->index(['is_active', 'conference_id'], 'chairs_active_conference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_program_chairs');
    }
}; 