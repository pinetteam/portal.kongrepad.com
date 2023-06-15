
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
        Schema::create('meeting_hall_program_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort_order')->nullable();
            $table->unsignedBigInteger('program_id')->index();
            $table->unsignedBigInteger('speaker_id')->index();
            $table->unsignedBigInteger('document_id')->index()->nullable();
            $table->boolean('document_sharing_via_email')->default(0)->comment('0=passive;1=active');
            $table->string('code', 255)->nullable();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->boolean('is_started')->default(0)->comment('0=passive;1=active');
            $table->boolean('is_questions_started')->default(0)->comment('0=passive;1=active');
            $table->boolean('questions')->default(0)->comment('0=passive;1=active');
            $table->boolean('questions_auto_start')->default(0)->comment('0=passive;1=active');
            $table->unsignedInteger('question_limit')->default(0);
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('edited_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('edited_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('program_id')->on('meeting_hall_programs')->references('id');
            $table->foreign('speaker_id')->on('meeting_participants')->references('id');
            $table->foreign('document_id')->on('meeting_documents')->references('id');
        });
        DB::statement('ALTER TABLE meeting_hall_programs MODIFY logo MEDIUMBLOB NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_hall_program_sessions');
    }
};
