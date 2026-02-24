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
        // First alter enum to include all values (existing + new)
        // Include 'gov' and 'admin' which exist in current data
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('government', 'private', 'soe', 'sme', 'admin', 'gov') NULL");
        
        // Then migrate 'gov' to 'government' for consistency
        DB::table('users')->where('role', 'gov')->update(['role' => 'government']);
        
        // Finally remove 'gov' from enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('government', 'private', 'soe', 'sme', 'admin') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('role', 'admin')->update(['role' => null]);
        DB::table('users')->where('role', 'sme')->update(['role' => null]);
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('government', 'private', 'soe') NULL");
    }
};
