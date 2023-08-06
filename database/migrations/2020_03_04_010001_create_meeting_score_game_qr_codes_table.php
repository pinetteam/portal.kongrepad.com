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
        Schema::create('meeting_score_game_qr_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('score_game_id')->index();
            $table->string('title', 511);
            $table->text('code');
            $table->binary('logo')->nullable();
            $table->unsignedBigInteger('point');
            $table->datetime('start_at');
            $table->datetime('finish_at');
            $table->boolean('participation_for_agent')->default(0)->comment('0=passive;1=active');
            $table->boolean('participation_for_attendee')->default(1)->comment('0=passive;1=active');
            $table->boolean('participation_for_team')->default(0)->comment('0=passive;1=active');
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('updated_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('score_game_id')->on('meeting_score_games')->references('id');
        });
        DB::statement('ALTER TABLE meeting_score_game_qr_codes MODIFY logo MEDIUMBLOB NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_score_game_qr_codes');
    }
};
