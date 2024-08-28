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
        Schema::create('vm_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('api_key');
            $table->time('last_handshake');
            $table->unsignedBigInteger('delete_by');
            $table->foreign('delete_by')->references('id')->on('users');
            $table->unsignedBigInteger('create_by');
            $table->foreign('create_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
