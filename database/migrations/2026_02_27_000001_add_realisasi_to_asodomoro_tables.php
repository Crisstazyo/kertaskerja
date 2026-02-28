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
        Schema::table('asodomoro_0_3_bulan_data', function (Blueprint $table) {
            $table->decimal('realisasi', 5, 2)->default(0)->after('year');
        });

        Schema::table('asodomoro_above_3_bulan_data', function (Blueprint $table) {
            $table->decimal('realisasi', 5, 2)->default(0)->after('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asodomoro_0_3_bulan_data', function (Blueprint $table) {
            $table->dropColumn('realisasi');
        });

        Schema::table('asodomoro_above_3_bulan_data', function (Blueprint $table) {
            $table->dropColumn('realisasi');
        });
    }
};
