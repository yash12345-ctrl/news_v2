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
        Schema::create('digital_ads_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertiser_id');
            $table->unsignedBigInteger('digital_ad_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('viewed')->default(1);
            $table->tinyInteger('clicked')->default(1);
            $table->timestamp('created_at');

            $table->index('advertiser_id');
            $table->index('digital_ad_id');
            $table->index('user_id');
            $table->index('viewed');
            $table->index('clicked');
            $table->index('created_at');

            $table->foreign('advertiser_id')->references('id')->on('advertisers');
            $table->foreign('digital_ad_id')->references('id')->on('digital_ads');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_ads_analytics');
    }
};
