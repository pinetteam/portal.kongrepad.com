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
        Schema::create('system_countries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code', 2)->unique(); // ISO 2-letter code
            $table->string('code_3', 3)->unique(); // ISO 3-letter code
            $table->string('phone_code', 10)->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->string('flag_emoji', 10)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Indexes for common queries
            $table->index(['is_active', 'sort_order']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_countries');
    }
}; 