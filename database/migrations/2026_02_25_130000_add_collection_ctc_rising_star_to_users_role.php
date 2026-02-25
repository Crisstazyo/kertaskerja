<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check database type
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'mysql') {
            // For MySQL, modify the ENUM column to add new role values
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'government', 'private', 'soe', 'sme', 'collection', 'ctc', 'rising-star') NOT NULL DEFAULT 'government'");
        } else {
            // For other databases (like SQLite), we need a different approach
            // Add a temporary column
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_temp')->nullable();
            });
            
            // Copy data
            DB::table('users')->update(['role_temp' => DB::raw('role')]);
            
            // Drop old column and rename new column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
            
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('role_temp', 'role');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'mysql') {
            // Revert to original ENUM values
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'government', 'private', 'soe', 'sme') NOT NULL DEFAULT 'government'");
        }
    }
};
