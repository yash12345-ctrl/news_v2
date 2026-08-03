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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('title', 256);
            $table->string('description', 1024);
            $table->string('question', 256);
            $table->string('media_url', 256);
            $table->tinyInteger('media_kind')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamp('published_at');
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
