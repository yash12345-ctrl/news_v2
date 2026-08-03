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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->integer('set_number')->default(1);
            $table->integer('point')->default(1);
            $table->integer('question_number');
            $table->integer('question_time')->default(1);
            $table->tinyInteger('media_type')->default(1);
            $table->string('media_url', 255)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->unsignedBigInteger('exam_id');
            $table->timestamps();

            $table->index('exam_id');

            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
