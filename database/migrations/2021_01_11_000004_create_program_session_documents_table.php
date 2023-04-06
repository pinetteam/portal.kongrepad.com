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
        Schema::create('program_session_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_session_id')->index();
            $table->unsignedBigInteger('document_id')->index();
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->timestamps();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->softDeletes();
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('document_id')->on('documents')->references('id');
            $table->foreign('program_session_id')->on('program_sessions')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_session_documents');
    }
};
