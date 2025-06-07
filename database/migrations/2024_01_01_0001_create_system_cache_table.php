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
        Schema::create('system_cache', function (Blueprint $table) {
            $table->string('key', 500)->primary();
            $table->uuid('tenant_id')->nullable()->index();
            $table->mediumText('value');
            $table->integer('expiration')->index();
            
            // Composite index for tenant-based cache queries
            $table->index(['tenant_id', 'expiration']);
            
            // Additional performance indexes
            $table->index(['expiration', 'key'], 'cache_expiration_key');
        });
        
        // Set table engine and charset for performance
        DB::statement('ALTER TABLE system_cache ENGINE = InnoDB');
        DB::statement('ALTER TABLE system_cache CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci');
        
        // Add table comment
        DB::statement("ALTER TABLE system_cache COMMENT = 'Optimized cache table for high-performance operations'");

        Schema::create('system_cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->uuid('tenant_id')->nullable()->index();
            $table->string('owner');
            $table->integer('expiration');
            
            // Composite index for tenant-based locks
            $table->index(['tenant_id', 'expiration']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_cache');
        Schema::dropIfExists('system_cache_locks');
    }
}; 