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
        Schema::create('enews_papers', function (Blueprint $table) {

            $table->id();
            $table->string('title', 128);
            $table->string('subtitle', 256)->nullable();
            $table->string('description', 512)->nullable();
            $table->string('slug', 256)->unique();
            $table->string('image_url', 256)->nullable();
            $table->integer('pages')->default('0');
            $table->integer('edition');
            $table->unsignedBigInteger('admin_id');
            $table->tinyInteger('status')->default('1');
            $table->timestamps();

            $table->index('slug');
            $table->index('admin_id');
            $table->index('status');

            $table->foreign('admin_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enews_papers');
    }
};
