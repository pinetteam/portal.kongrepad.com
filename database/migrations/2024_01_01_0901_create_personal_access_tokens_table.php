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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('tokenable');
            $table->string('name', 50);
            $table->string('token', 64)->unique()->index();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamps();

            $table->index(['tokenable_type', 'tokenable_id'], 'tokens_tokenable');
            $table->index(['token', 'expires_at'], 'tokens_token_expiry');
            $table->index(['last_used_at', 'tokenable_id'], 'tokens_activity');
            $table->index(['expires_at', 'created_at'], 'tokens_cleanup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
