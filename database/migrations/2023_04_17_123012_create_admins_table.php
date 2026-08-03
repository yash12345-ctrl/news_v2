<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {

            $table->id();
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->tinyInteger('gender');
            $table->string('phone', 12)->unique();
            $table->string('email', 64)->unique();
            $table->string('password', 255);
            $table->string('photo', 255)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->tinyInteger('role');
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
            
            $table->index('first_name');
            $table->index('last_name');
            $table->index('phone');
            $table->index('email');
        });

        Admin::create([
            'first_name'    => 'Admin',
            'last_name'     => 'User',
            'gender'        => 1,
            'phone'         => '9931900000',
            'email'         => 'admin@akhbar.com',
            'password'      => '$2y$10$m10VlTg6o2yYt3SRW92AZOJBIoPNmAWP2/x7nuzt17rgqVhWWzMbW',
            'role'          => 1,
            'photo'         => env('APP_URL') . '/assets/img/avatar-male.jpg',
        ]);
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
