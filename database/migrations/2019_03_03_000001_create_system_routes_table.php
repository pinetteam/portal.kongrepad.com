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
        Schema::create('system_routes', function (Blueprint $table) {
            $table->id();
            $table->enum('group', ['general', 'meeting', 'reporting', 'user-management', 'system']);
            $table->unsignedInteger('sort_order')->nullable();
            $table->string('code', 63)->unique();
            $table->string('route', 255)->unique();
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
        Schema::dropIfExists('system_routes');
    }
};
