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
        Schema::create('system_countries', function (Blueprint $table) {
            $table->id();
            $table->string('name',63);
            $table->string('code', 63);
            $table->string('short_name_2d', 2);
            $table->string('short_name_3d', 3);
            $table->string('phone_code', 7);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_countries');
    }
};
