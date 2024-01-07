<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 127);
            $table->string('title', 255);
            $table->binary('icon')->nullable();
            $table->binary('logo')->nullable();
            $table->enum('language', ['en', 'tr'])->default('en');
            $table->enum('type', ['demo', 'full_access'])->default('full_access');
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE customers MODIFY logo MEDIUMBLOB NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
