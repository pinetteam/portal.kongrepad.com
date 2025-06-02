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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('group')->default('common');
            $table->timestamps();
            
            // Aynı dil ve grup için benzersiz key olmalı
            $table->unique(['language_id', 'key', 'group']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
}; 