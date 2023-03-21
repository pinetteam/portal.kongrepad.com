<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('user_role_id')->index();
            $table->string('username', 255)->unique();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_country_code', 7)->nullable();
            $table->unsignedBigInteger('phone_country_id')->index()->nullable();
            $table->string('phone', 31)->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password', 255);
            $table->rememberToken();
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->ipAddress('register_ip')->nullable();
            $table->string('register_user_agent', 511)->nullable();
            $table->ipAddress('last_login_ip')->nullable();
            $table->string('last_login_agent', 511)->nullable();
            $table->dateTime('last_login_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('customer_id')->on('customers')->references('id');
            $table->foreign('user_role_id')->on('user_roles')->references('id');
            $table->foreign('phone_country_id')->on('system_countries')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
