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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->integer('score')->default(0);
            $table->string('exam_pin', 6)->unique();
            $table->double('negative_score')->default(0);
            $table->integer('total_ques')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
