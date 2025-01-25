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
        Schema::create('file_img', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_task_id')->nullable()->constrained('processTasks')->onDelete('cascade');
            $table->text('filename');
            $table->text('original_name');
            $table->text('file_path');
            $table->unsignedInteger('file_index');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_img');
    }
};
