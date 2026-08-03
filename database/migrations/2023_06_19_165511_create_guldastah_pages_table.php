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
        Schema::create('guldastah_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_url', 256);
            $table->integer('page_number');
            $table->unsignedBigInteger('guldastah_id');
            $table->timestamps();
            
            $table->foreign('guldastah_id')->references('id')->on('guldastahs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guldastah_pages');
    }
};
