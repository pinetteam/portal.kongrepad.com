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
        // System routes - for authorization and menu structure
        Schema::create('system_routes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('group'); // general, conference, reporting, user-management, system
            $table->string('code')->unique(); // Route code
            $table->string('route'); // Laravel route name
            $table->string('name'); // Display name
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Menu icon
            $table->string('method')->default('GET'); // HTTP method
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_auth')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('permissions')->nullable(); // Required permissions
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['group', 'is_active', 'sort_order']);
            $table->index(['is_active', 'requires_auth']);
            $table->index('method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_routes');
    }
}; 