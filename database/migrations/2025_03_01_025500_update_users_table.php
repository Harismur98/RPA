<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add delete_by column with default value 1
            $table->unsignedBigInteger('delete_by')->default(1);
            
            // Add role_id column and foreign key
            $table->unsignedBigInteger('role_id')->after('id')->default(3); // Default to User role (id: 3)
            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('restrict'); // Prevent deletion of roles that are in use
            
            // Add soft deletes if not already present
            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Update existing users to have Super Admin role (optional)
        DB::table('users')->where('id', 1)->update(['role_id' => 1]); // First user as Super Admin
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['role_id']);
            
            // Drop columns
            $table->dropColumn('role_id');
            $table->dropColumn('delete_by');
            
            // Drop soft deletes if we added it
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
}; 