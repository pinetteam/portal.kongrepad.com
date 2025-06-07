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
        Schema::create('conference_surveys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->uuid('session_id')->nullable();
            $table->string('title', 250);
            $table->text('description')->nullable();
            $table->string('type', 20)->default('feedback')->index();
            $table->string('status', 15)->default('draft')->index();
            $table->datetime('start_at')->nullable()->index();
            $table->datetime('end_at')->nullable()->index();
            $table->boolean('is_anonymous')->default(true)->index();
            $table->boolean('is_mandatory')->default(false);
            $table->boolean('allow_multiple_responses')->default(false);
            $table->string('target_audience', 30)->default('all')->index();
            $table->integer('max_responses')->nullable();
            
            $table->integer('responses_count')->default(0)->index();
            $table->datetime('last_response_at')->nullable();
            
            $table->json('settings')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('conference_id', 'fk_surveys_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('session_id', 'fk_surveys_session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            
            $table->index(['conference_id', 'status'], 'surveys_conference_status');
            $table->index(['session_id', 'status'], 'surveys_session_status');
            $table->index(['type', 'target_audience'], 'surveys_type_audience');
            $table->index(['start_at', 'end_at'], 'surveys_time_range');
            $table->index(['responses_count', 'status'], 'surveys_responses_status');
            $table->index(['is_anonymous', 'status'], 'surveys_anonymous_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_surveys');
    }
}; 