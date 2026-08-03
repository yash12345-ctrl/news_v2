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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 32);
            $table->string('last_name', 32)->nullable();
            $table->tinyInteger('gender')->nullable()->default(1);
            $table->date('dob')->nullable();
            $table->integer('age')->unsigned()->nullable();
            $table->string('phone', 12)->unique()->nullable();
            $table->string('email', 64)->unique()->nullable();
            $table->string('password', 255);
            $table->string('photo', 255)->nullable();
            $table->tinyInteger('lang')->default(1);
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->unsignedBigInteger('address_id')->unsigned()->nullable();
            $table->string('remember_token', 256)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->timestamps();

            $table->index('first_name');
            $table->index('last_name');
            $table->index('phone');
            $table->index('email');
            $table->index('status');

            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
