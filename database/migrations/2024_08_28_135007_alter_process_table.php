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
        Schema::table('process', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->unsignedBigInteger('delete_by')->nullable()->default(1)->change();
            $table->foreign('delete_by')->references('id')->on('users');
            $table->unsignedBigInteger('create_by');
            $table->foreign('create_by')->references('id')->on('users');
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
