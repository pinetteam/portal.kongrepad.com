<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->index();
            $table->uuid('banner_name')->nullable();
            $table->string('banner_extension', 31)->nullable();
            $table->unsignedInteger('banner_size')->comment('(kb)')->nullable();
            $table->string('code', 511);
            $table->string('title', 511);
            $table->date('start_at');
            $table->date('finish_at');
            $table->boolean('status')->default(1)->comment('0=passive;1=active');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('created_by')->on('users')->references('id');
            $table->foreign('updated_by')->on('users')->references('id');
            $table->foreign('deleted_by')->on('users')->references('id');
            $table->foreign('customer_id')->on('customers')->references('id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
