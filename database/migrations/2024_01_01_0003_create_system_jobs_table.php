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
        Schema::create('system_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue', 100)->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts')->default(0)->index();
            $table->unsignedInteger('reserved_at')->nullable()->index();
            $table->unsignedInteger('available_at')->index();
            $table->unsignedInteger('created_at')->index();
            
            // High-performance compound indexes for job processing
            $table->index(['queue', 'reserved_at'], 'jobs_queue_reserved');
            $table->index(['queue', 'available_at', 'reserved_at'], 'jobs_queue_available_reserved');
            $table->index(['available_at', 'reserved_at'], 'jobs_available_reserved');
            $table->index(['created_at', 'queue'], 'jobs_created_queue');
            $table->index(['attempts', 'reserved_at'], 'jobs_attempts_reserved');
        });
        
        // Add table comment for optimization
        DB::statement("ALTER TABLE system_jobs COMMENT = 'Optimized job queue table for high-throughput processing'");

        Schema::create('system_job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('tenant_id')->nullable()->index();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
            
            // Index for tenant-based batch queries
            $table->index(['tenant_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_jobs');
        Schema::dropIfExists('system_job_batches');
    }
}; 