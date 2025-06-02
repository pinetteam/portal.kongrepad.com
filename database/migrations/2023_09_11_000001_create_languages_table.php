<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 5);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // En ve TR için varsayılan dilleri ekle
        DB::table('languages')->insert([
            [
                'name' => 'English',
                'code' => 'en',
                'is_active' => true,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Türkçe',
                'code' => 'tr',
                'is_active' => true,
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
}; 