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
        Schema::create('visitors_summary', function (Blueprint $table) {
            $table->id();
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->integer('visitor_count');
            $table->integer('returning_visit_count');
            $table->timestamps();

            $table->index('day');
            $table->index('month');
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors_summary');
    }
};
