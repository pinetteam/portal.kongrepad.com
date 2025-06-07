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
        // Document email notifications - tracks which documents were sent to which participants
        Schema::create('conference_document_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_id')->index();
            $table->uuid('participant_id')->index();
            $table->string('notification_type')->default('email'); // email, sms, push
            $table->string('status')->default('pending'); // pending, sent, failed, bounced
            $table->string('email_address'); // Email address where document was sent
            $table->datetime('sent_at')->nullable();
            $table->datetime('opened_at')->nullable(); // Email open time
            $table->datetime('downloaded_at')->nullable(); // Document download time
            $table->text('error_message')->nullable(); // Error message if failed
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['document_id', 'status']);
            $table->index(['participant_id', 'status']);
            $table->index(['notification_type', 'status']);
            $table->index('sent_at');

            // Foreign keys
            $table->foreign('document_id', 'fk_doc_notifications_document_id')->references('id')->on('conference_documents')->onDelete('cascade');
            $table->foreign('participant_id', 'fk_doc_notifications_participant_id')->references('id')->on('conference_participants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_document_notifications');
    }
}; 