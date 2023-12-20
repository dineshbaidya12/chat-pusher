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
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('first_user')->unsigned();
            $table->bigInteger('second_user')->unsigned();
            $table->foreign('first_user')->references('id')->on('users');
            $table->foreign('second_user')->references('id')->on('users');
            $table->enum('status', ['connected', 'requested', 'blocked'])->default('requested');
            $table->bigInteger('requested_by');
            $table->bigInteger('blocked_by')->nullable();
            $table->timestamp('connected_from')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
};
