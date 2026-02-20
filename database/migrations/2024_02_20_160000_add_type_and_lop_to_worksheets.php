<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('worksheets', function (Blueprint $table) {
            $table->enum('type', ['scalling', 'psak'])->default('scalling')->after('role');
            $table->enum('lop_category', ['on_hand', 'qualified', 'initiate', 'koreksi'])->nullable()->after('type');
            
            // Drop old unique constraint
            $table->dropUnique(['month', 'year', 'role']);
            
            // Add new unique constraint with type and lop_category
            $table->unique(['month', 'year', 'role', 'type', 'lop_category']);
        });
    }

    public function down()
    {
        Schema::table('worksheets', function (Blueprint $table) {
            $table->dropUnique(['month', 'year', 'role', 'type', 'lop_category']);
            $table->dropColumn(['type', 'lop_category']);
            $table->unique(['month', 'year', 'role']);
        });
    }
};
