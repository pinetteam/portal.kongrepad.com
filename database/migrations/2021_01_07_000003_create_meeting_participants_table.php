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
        Schema::create('meeting_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meeting_id')->index();
            $table->string('username', 127)->unique();
            $table->string('title', 255)->nullable();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('identification_number', 255)->nullable();
            $table->string('organisation', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->unsignedBigInteger('phone_country_id')->index()->nullable();
            $table->string('phone', 31)->nullable();
            $table->string('password', 255);
            $table->ipAddress('last_login_ip')->nullable();
            $table->string('last_login_agent', 511)->nullable();
            $table->dateTime('last_login_datetime')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->enum('type', ['agent', 'attendee', 'team'])->default('attendee');
            $table->boolean('gdpr_consent')->default(0)->comment('0=not-approved;1=approved');
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('edited_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('edited_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('meeting_id')->on('meetings')->references('id');
            $table->foreign('phone_country_id')->on('system_countries')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_participants');
    }
};
