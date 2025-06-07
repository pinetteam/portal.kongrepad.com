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
        Schema::create('conference_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('conference_id');
            $table->uuid('session_id')->nullable();
            $table->string('title', 250);
            $table->text('description')->nullable();
            $table->string('file_name', 255)->nullable();
            $table->string('file_path', 400)->nullable();
            $table->string('public_link', 400)->nullable();
            $table->string('file_type', 30)->index();
            $table->bigInteger('file_size')->nullable();
            $table->string('mime_type', 80)->nullable();
            $table->string('status', 15)->default('active')->index();
            $table->boolean('is_public')->default(false)->index();
            $table->boolean('is_downloadable')->default(true);
            $table->boolean('require_login')->default(true);
            $table->boolean('is_external')->default(false)->index();
            
            $table->integer('download_count')->default(0)->index();
            $table->datetime('last_downloaded_at')->nullable();
            
            $table->json('access_permissions')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('conference_id', 'fk_documents_conference_id')->references('id')->on('conferences')->onDelete('cascade');
            $table->foreign('session_id', 'fk_documents_session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            
            $table->index(['conference_id', 'status'], 'documents_conference_status');
            $table->index(['session_id', 'status'], 'documents_session_status');
            $table->index(['file_type', 'is_public'], 'documents_type_public');
            $table->index(['is_external', 'status'], 'documents_external_status');
            $table->index(['download_count', 'conference_id'], 'documents_popularity_conference');
            $table->index(['created_at', 'status'], 'documents_created_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_documents');
    }
}; 