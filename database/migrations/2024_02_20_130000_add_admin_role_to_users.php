<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // SQLite doesn't support modifying ENUM, so we need to recreate the column
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('government', 'private', 'soe', 'admin', 'sme', 'collection', 'ctc', 'rising-star') DEFAULT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('government', 'private', 'soe', 'sme', 'collection', 'ctc', 'rising-star') DEFAULT NULL");
    }
};
