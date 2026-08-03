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
        Schema::table('enews_paper_pages', function (Blueprint $table) {
            $table->string('page_sm_url', 256)->after('page_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enews_paper_pages', function (Blueprint $table) {
            $table->dropColumn('page_sm_url');
        });
    }
};
