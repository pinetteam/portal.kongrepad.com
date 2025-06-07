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
        // System languages - used with Laravel's built-in localization system (resources/lang/)
        Schema::create('system_languages', function (Blueprint $table) {
            $table->string('code', 5)->primary(); // Language code: en, tr, de, fr, etc.
            $table->string('name'); // English name: English, Turkish, German, French
            $table->string('native_name'); // Native name: English, Türkçe, Deutsch, Français
            $table->string('flag_icon')->nullable(); // Flag emoji or icon class
            $table->boolean('is_active')->default(true);
            $table->boolean('is_rtl')->default(false); // Right-to-left languages (Arabic, Hebrew)
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_languages');
    }
}; 