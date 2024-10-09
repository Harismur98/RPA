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
        Schema::create('job_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('process_id');
            $table->foreign('process_id')->references('id')->on('process');
            $table->unsignedBigInteger('vm_id');
            $table->foreign('vm_id')->references('id')->on('vm_lists');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('table_job_template');
    }
};
