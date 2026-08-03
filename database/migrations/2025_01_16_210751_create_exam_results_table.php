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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('score');
            $table->integer('user_rank')->default(0);
            $table->integer('nattempted_question')->default(0);
            $table->integer('total_negative_marks')->default(0);
            $table->integer('total_correct_marks')->default(0);
            $table->integer('ncorrect_question')->default(0);
            $table->integer('nincorrect_question')->default(0);
            $table->tinyInteger('is_published')->default(0);
            $table->timestamps();

            $table->index('exam_id');
            $table->index('user_id');

            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
