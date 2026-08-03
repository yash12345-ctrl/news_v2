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
        Schema::create('advertisers', function (Blueprint $table) {

            $table->id();
            $table->string('name', 32);
            $table->string('phone', 12)->unique();
            $table->string('email', 64)->unique();
            $table->string('password', 256);
            $table->string('logo_url', 255)->nullable();
            $table->string('company_name', 256)->nullable();
            $table->integer('company_size')->nullable();
            $table->integer('company_type')->default('1');
            $table->unsignedBigInteger('admin_id');
            $table->timestamps();

            $table->index('name');
            $table->index('admin_id');

            $table->foreign('admin_id')->references('id')->on('admins');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisers');
    }
};
