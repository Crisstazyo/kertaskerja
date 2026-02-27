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
        Schema::table('visiting_gm_data', function (Blueprint $table) {
            $table->decimal('ratio_aktual', 5, 2)->nullable()->after('target_ratio');
        });

        Schema::table('visiting_am_data', function (Blueprint $table) {
            $table->decimal('ratio_aktual', 5, 2)->nullable()->after('target_ratio');
        });

        Schema::table('visiting_hotd_data', function (Blueprint $table) {
            $table->decimal('ratio_aktual', 5, 2)->nullable()->after('target_ratio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visiting_gm_data', function (Blueprint $table) {
            $table->dropColumn('ratio_aktual');
        });

        Schema::table('visiting_am_data', function (Blueprint $table) {
            $table->dropColumn('ratio_aktual');
        });

        Schema::table('visiting_hotd_data', function (Blueprint $table) {
            $table->dropColumn('ratio_aktual');
        });
    }
};
