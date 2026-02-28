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
        // Delete users with ctc and rising-star roles
        DB::table('users')->whereIn('email', ['ctc@gmail.com', 'risingstar@gmail.com'])->delete();
        
        // Check database type
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'mysql') {
            // For MySQL, modify the ENUM column to remove ctc and rising-star values
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'government', 'private', 'soe', 'sme', 'collection') NOT NULL DEFAULT 'government'");
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
        // Check database type
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'mysql') {
            // For MySQL, restore the ENUM column with ctc and rising-star values
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'government', 'private', 'soe', 'sme', 'collection', 'ctc', 'rising-star') NOT NULL DEFAULT 'government'");
        } else {
            // For other databases, restore would require the same complex approach
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_temp')->nullable();
            });
            
            DB::table('users')->update(['role_temp' => DB::raw('role')]);
            
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
            
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('role_temp', 'role');
            });
        }
        
        // Recreate users for ctc and rising-star roles
        DB::table('users')->insert([
            [
                'name' => 'CTC User',
                'email' => 'ctc@gmail.com',
                'password' => bcrypt('password123'),
                'role' => 'ctc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rising Star User',
                'email' => 'risingstar@gmail.com',
                'password' => bcrypt('password123'),
                'role' => 'rising-star',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
};
