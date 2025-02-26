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
        Schema::create('processExceptions', function (Blueprint $table) {
            $table->id();
            $table->string('exception_name');
            $table->integer('confidence');
            $table->integer('order');
            $table->boolean('is_loop');
            $table->boolean('is_stop_task');
            $table->string('value');
            $table->unsignedBigInteger('step_id');
            $table->foreign('step_id')->references('id')->on('process_step_exceptions');
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
