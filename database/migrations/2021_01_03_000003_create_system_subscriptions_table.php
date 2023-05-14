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
        Schema::create('system_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('group', 255);
            $table->string('route', 255)->unique();
            $table->unsignedInteger('sort_order')->nullable();
            $table->string('title', 255);
            $table->string('code', 511);
            $table->boolean('extension');
            $table->unsignedInteger('duration')->default(0)->comment('days');
            $table->double('price');
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_subscriptions');
    }
};
