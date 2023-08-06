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
        Schema::create('system_setting_variables', function (Blueprint $table) {
            $table->id();
            $table->enum('group', ['system', 'localisation', 'social'])->default('system');
            $table->unsignedInteger('sort_order')->nullable();
            $table->string('title', 255);
            $table->string('variable', 255);
            $table->enum('type', ['checkbox', 'date', 'datetime', 'email', 'number', 'radio', 'select', 'text', 'time'])->default('text');
            $table->json('type_variables')->nullable();
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
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
        Schema::dropIfExists('system_setting_variables');
    }
};
