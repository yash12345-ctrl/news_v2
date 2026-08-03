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
        Schema::table('visitor_analytics', function (Blueprint $table) {
            $table->string("country", 128)->nullable();
            $table->tinyInteger("browser")->default(0);
            $table->tinyInteger("device")->default(0);
            $table->string("browser_other", 128)->nullable();

            $table->index('country');
            $table->index('browser');
            $table->index('device');
            $table->index('browser_other');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor_analytics', function (Blueprint $table) {
            $table->dropIndex(['country']);
            $table->dropIndex(['browser']);
            $table->dropIndex(['device']);

            $table->dropColumn([
                'country',
                'browser',
                'device',
                'created_at',
                'updated_at',
            ]);
        });
    }
};
