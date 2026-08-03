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
        Schema::create('pg_payments', function (Blueprint $table) {

            $table->id();
            $table->integer('amount')->unsigned();
            $table->unsignedBigInteger('payment_id');
            $table->string('pg_payment_id', 128)->nullable();
            $table->tinyInteger('status')->default('0');

            $table->index('pg_payment_id');
            $table->index('payment_id');
            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pg_payments');
    }
};
