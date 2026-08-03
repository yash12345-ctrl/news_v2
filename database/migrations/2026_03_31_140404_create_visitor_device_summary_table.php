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
        Schema::create('visitor_device_summary', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visitor_summary_id');
            $table->tinyInteger('device');
            $table->integer('device_count');
            $table->timestamps();

            $table->index('visitor_summary_id');
            $table->foreign('visitor_summary_id')->references('id')->on('visitors_summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_device_summary');
    }
};
