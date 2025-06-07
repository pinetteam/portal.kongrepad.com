<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Session başlatma/durdurma logları
        Schema::create('conference_session_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('session_id');
            $table->uuid('created_by'); // Kim işlemi yaptı
            $table->string('action'); // start, stop, pause, resume
            $table->text('note')->nullable(); // İsteğe bağlı not
            $table->json('metadata')->nullable();
            $table->timestamp('created_at');

            $table->foreign('session_id')->references('id')->on('conference_sessions')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['session_id', 'action', 'created_at']);
            $table->index(['created_by', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conference_session_logs');
    }
}; 