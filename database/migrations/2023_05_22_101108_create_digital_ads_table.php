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
        Schema::create('digital_ads', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 64)->unique();
            $table->string('title', 256);
            $table->text('description')->nullable();
            $table->string('cta_url', 256);
            $table->string('cta_text', 256)->nullable();
            $table->string('media_url', 256);
            $table->tinyInteger('media_kind');
            $table->tinyInteger('ad_kind')->default(1);
            $table->string('ad_url', 256);
            $table->unsignedBigInteger('advertiser_id');
            $table->integer('price');
            $table->tinyInteger('status')->default(1);
            $table->text('rejection_reason', 1024)->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index('uuid');
            $table->index('advertiser_id');
            $table->index('status');
            $table->index('ad_kind');

            $table->foreign('advertiser_id')->references('id')->on('advertisers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_ads');
    }
};
