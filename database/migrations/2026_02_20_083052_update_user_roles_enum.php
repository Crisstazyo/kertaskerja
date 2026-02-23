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
        // Update role enum to only have 'gov' and 'admin'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('gov', 'admin') DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to old values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('government', 'private', 'soe', 'admin') DEFAULT NULL");
    }
};
