<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conference_survey_question_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('question_id');
            $table->string('text');
            $table->string('value')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_other_option')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('conference_survey_questions')->onDelete('cascade');
            
            $table->index(['question_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conference_survey_question_options');
    }
}; 