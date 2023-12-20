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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 190);
            $table->string('last_name', 190);
            $table->string('name', 190);
            $table->string('username', 190);
            $table->string('email');
            $table->string('password');
            $table->string('plain_pass');
            $table->string('profile_pic')->nullable();
            $table->enum('status', ['active', 'inactive', 'blocked', 'waiting'])->default('waiting');
            $table->enum('type', ['admin', 'user'])->default('user');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
