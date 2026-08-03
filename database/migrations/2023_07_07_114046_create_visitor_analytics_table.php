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
        Schema::create("visitor_analytics", function (Blueprint $table) {
            $table->string("uuid", 64)->unique();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string("state", 64)->nullable();
            $table->string("ip_address", 32)->nullable();
            $table->unsignedBigInteger("visit_count")->default(0);
            $table->tinyInteger("source")->default(1);
            $table->timestamp("last_visited_at");

            $table->index("uuid");
            $table->index("state");
            $table->index("visit_count");
            $table->index("source");
            $table->index("last_visited_at");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_analytics');
    }
};
