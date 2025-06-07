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
        Schema::create('conference_virtual_stands', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->string('company_name', 200);
            $table->string('contact_person', 150)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('website_url', 300)->nullable();
            $table->string('logo_path', 300)->nullable();
            $table->string('banner_path', 300)->nullable();
            $table->string('category', 80)->nullable()->index();
            $table->string('type', 20)->default('sponsor')->index();
            $table->string('tier', 15)->default('standard')->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->integer('sort_order')->default(0)->index();
            
            // Essential tracking only
            $table->integer('visits_count')->default(0)->index();
            $table->datetime('last_visit_at')->nullable();
            
            // Stand content (simplified)
            $table->json('products')->nullable();
            $table->json('documents')->nullable();
            $table->json('contact_info')->nullable();
            
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('conference_id', 'fk_virtual_stands_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            
            // Essential indexes only (reduced from 13+ to 6)
            $table->index(['conference_id', 'is_active'], 'stands_conference_active');
            $table->index(['category', 'is_active'], 'stands_category_active');
            $table->index(['type', 'tier'], 'stands_type_tier');
            $table->index(['is_featured', 'sort_order'], 'stands_featured_sort');
            $table->index(['visits_count', 'is_active'], 'stands_visits_active');
            $table->index(['last_visit_at', 'conference_id'], 'stands_visit_conference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_virtual_stands');
    }
}; 