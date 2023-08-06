
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
        Schema::create('meeting_hall_program_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort_order')->nullable();
            $table->unsignedBigInteger('program_id')->index();
            $table->unsignedBigInteger('speaker_id')->index();
            $table->unsignedBigInteger('document_id')->index()->nullable();
            $table->string('code', 255)->nullable();
            $table->string('title', 511);
            $table->text('description')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->boolean('is_started')->default(0)->comment('0=passive;1=active');
            $table->unsignedInteger('questions_limit')->default(0);
            $table->boolean('questions_allowed')->default(0)->comment('0=passive;1=active');
            $table->boolean('questions_auto_start')->default(0)->comment('0=passive;1=active');
            $table->boolean('is_questions_started')->default(0)->comment('0=passive;1=active');
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('updated_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('program_id')->on('meeting_hall_programs')->references('id');
            $table->foreign('speaker_id')->on('meeting_participants')->references('id');
            $table->foreign('document_id')->on('meeting_documents')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_program_sessions');
    }
};
