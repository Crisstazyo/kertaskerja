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
        $tables = ['psak_government', 'psak_private', 'psak_soe', 'psak_sme'];
        
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->date('periode')->nullable()->after('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['psak_government', 'psak_private', 'psak_soe', 'psak_sme'];
        
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('periode');
            });
        }
    }
};
