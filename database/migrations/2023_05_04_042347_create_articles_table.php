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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title_en', 128);
            $table->string('title_ur', 128);
            $table->string('content_short_en', 256)->nullable();
            $table->string('content_short_ur', 256)->nullable();
            $table->text('content_en', 512);
            $table->text('content_ur', 512);
            $table->string('slug', 256)->unique();
            $table->string('article_url', 256);
            $table->string('image_url', 256)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('admin_id');
            $table->integer('views')->unsigned()->default('0');
            $table->tinyInteger('status')->default('1');
            $table->timestamp('published_at')->nullable();
            $table->integer('flag')->unsigned()->default('0');      // 1 = main, 2 = popular
            $table->timestamps();

            $table->index('slug');
            $table->index('category_id');
            $table->index('admin_id');
            $table->index('status');

            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
