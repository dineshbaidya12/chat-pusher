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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->bigInteger('sender')->unsigned();
            $table->bigInteger('reciever')->unsigned();
            $table->foreign('sender')->references('id')->on('users');
            $table->foreign('reciever')->references('id')->on('users');
            $table->enum('status', ['seen', 'unseen', 'deleted'])->default('unseen');
            $table->timestamp('time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
