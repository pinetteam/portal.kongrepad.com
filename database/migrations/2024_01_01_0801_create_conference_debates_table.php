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
        Schema::create('conference_debates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->uuid('session_id')->nullable();
            $table->string('title', 250);
            $table->text('description')->nullable();
            $table->string('topic', 500);
            $table->string('status', 15)->default('scheduled')->index();
            $table->string('type', 20)->default('traditional')->index();
            $table->datetime('start_at')->nullable()->index();
            $table->datetime('end_at')->nullable()->index();
            $table->integer('time_limit')->default(30);
            $table->boolean('allow_audience_votes')->default(true);
            $table->boolean('is_moderated')->default(true);
            
            // Essential tracking only
            $table->integer('total_votes')->default(0)->index();
            $table->integer('teams_count')->default(2);
            $table->datetime('last_activity_at')->nullable();
            
            $table->json('rules')->nullable();
            $table->json('settings')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('conference_id', 'fk_debates_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('session_id', 'fk_debates_session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            
            // Essential indexes only (reduced from 13+ to 6)
            $table->index(['conference_id', 'status'], 'debates_conference_status');
            $table->index(['session_id', 'status'], 'debates_session_status');
            $table->index(['type', 'status'], 'debates_type_status');
            $table->index(['start_at', 'end_at'], 'debates_time_range');
            $table->index(['total_votes', 'status'], 'debates_votes_status');
            $table->index(['last_activity_at', 'status'], 'debates_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_debates');
    }
}; 