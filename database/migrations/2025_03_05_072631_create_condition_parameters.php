<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ConditionType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('condition_parameters', function (Blueprint $table) {
            $table->id();
            $table->enum('condition_type', array_column(ConditionType::cases(), 'value'));
            $table->timestamps();
        });

        // Modify processtasks table
        Schema::table('processtasks', function (Blueprint $table) {
            $table->dropColumn('is_loop');
            $table->enum('condition_type', array_column(ConditionType::cases(), 'value'))->nullable()->after('task_action');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condition_parameters');

        // Revert processtasks table changes
        Schema::table('processtasks', function (Blueprint $table) {
            $table->boolean('is_loop')->default(false);
            $table->dropColumn('condition_type');
            $table->dropSoftDeletes();
        });
    }
};
