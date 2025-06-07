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
        Schema::create('conference_poll_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('poll_id')->index(); // Heavy indexed for poll queries
            $table->string('text', 1000); // Poll option text
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->string('color', 7)->nullable(); // Hex color for charts
            $table->string('image_path', 500)->nullable(); // Option image
            
            // Real-time vote counting - cached for performance
            $table->integer('votes_count')->default(0)->index(); // Cached vote count
            $table->decimal('votes_percentage', 5, 2)->default(0.00)->index(); // Cached percentage
            $table->datetime('last_vote_at')->nullable()->index(); // Last vote time for this option
            
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent(); // Optimized timestamp
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Foreign keys
            $table->foreign('poll_id')->references('id')->on('conference_polls')->onDelete('cascade');
            
            // High-performance compound indexes for poll management
            $table->index(['poll_id', 'sort_order', 'is_active'], 'poll_options_poll_sort_active');
            $table->index(['poll_id', 'votes_count'], 'poll_options_poll_votes');
            $table->index(['votes_count', 'poll_id'], 'poll_options_votes_poll');
            $table->index(['poll_id', 'votes_percentage'], 'poll_options_poll_percentage');
            $table->index(['last_vote_at', 'poll_id'], 'poll_options_last_vote_poll');
            $table->index(['is_active', 'sort_order'], 'poll_options_active_sort');
            
            // Real-time polling indexes
            $table->index(['poll_id', 'votes_count', 'sort_order'], 'poll_options_poll_votes_sort');
            $table->index(['votes_percentage', 'votes_count'], 'poll_options_percentage_votes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_poll_options');
    }
}; 