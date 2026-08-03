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
        Schema::create("auth_otps", function (Blueprint $table) {

            $table->id();
            // @NOTE(muktar): username can be email, phone or whatever developer decides
            $table->string("username");
            $table->string("otp");
            $table->timestamp("expires_at");
            $table->timestamp("created_at");

            $table->index('username');
            $table->index('otp');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_otps');
    }
};
