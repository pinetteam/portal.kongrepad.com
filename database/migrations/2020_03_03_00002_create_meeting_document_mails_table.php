<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_document_mails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id')->index();
            $table->unsignedBigInteger('participant_id')->index();
            $table->timestamps();
            $table->foreign('document_id')->on('meeting_documents')->references('id');
            $table->foreign('participant_id')->on('meeting_participants')->references('id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('meeting_document_mails');
    }
};
