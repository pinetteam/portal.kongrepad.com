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
        Schema::create('conference_survey_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('survey_id')->index();
            $table->string('question', 500); // Reduced from 1000
            $table->text('description')->nullable();
            $table->string('question_type', 20)->index(); // Reduced from 30, simplified types
            $table->boolean('is_required')->default(false)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            
            // Basic validation (simplified)
            $table->integer('min_length')->nullable();
            $table->integer('max_length')->nullable();
            $table->string('placeholder', 200)->nullable(); // Reduced from 500
            
            // Essential features only
            $table->boolean('allow_multiple')->default(false);
            $table->string('category', 50)->nullable()->index(); // Reduced from 100
            
            // Display settings (simplified)
            $table->string('help_text', 300)->nullable(); // Reduced from 1000
            
            // Essential tracking only
            $table->integer('responses_count')->default(0)->index();
            
            $table->json('options_data')->nullable(); // For dynamic options
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('survey_id', 'fk_survey_questions_survey_id')->references('id')->on('conference_surveys')->onDelete('cascade');
            
            // Essential indexes only (reduced from 12+ to 6)
            $table->index(['survey_id', 'sort_order'], 'survey_questions_survey_sort');
            $table->index(['survey_id', 'is_active'], 'survey_questions_survey_active');
            $table->index(['question_type', 'is_required'], 'survey_questions_type_required');
            $table->index(['category', 'is_active'], 'survey_questions_category_active');
            $table->index(['responses_count', 'survey_id'], 'survey_questions_responses_survey');
            $table->index(['allow_multiple', 'question_type'], 'survey_questions_multiple_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_survey_questions');
    }
}; 