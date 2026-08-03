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
        Schema::create('enews_paper_pages', function (Blueprint $table) {

            $table->id();
            $table->string('page_url', 256);
            $table->integer('page_number');
            $table->unsignedBigInteger('enews_paper_id');
            $table->timestamps();
            
            $table->foreign('enews_paper_id')->references('id')->on('enews_papers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enews_paper_pages');
    }
};
