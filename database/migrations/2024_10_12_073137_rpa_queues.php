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
        Schema::create("rpa_queues", function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->foreign('job_id')->references('id')->on('job_templates');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('status');
            $table->unsignedBigInteger('delete_by')->nullable()->default(1);
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
