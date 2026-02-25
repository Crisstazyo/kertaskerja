<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('funnel_tracking', function (Blueprint $table) {
            // Remove f0_lead column (as per user request: F0 should only have Inisiasi)
            // Keep f0_inisiasi_solusi
            
            // Add missing F1 fields used in views
            $table->boolean('f1_p0_p1')->default(false)->after('f0_inisiasi_solusi');
            $table->boolean('f1_juskeb')->default(false)->after('f1_p0_p1');
            $table->boolean('f1_bod_dm')->default(false)->after('f1_juskeb');
            
            // Add missing F2 fields used in views
            $table->boolean('f2_p2')->default(false)->after('f1_bod_dm');
            $table->boolean('f2_evaluasi')->default(false)->after('f2_p2');
            $table->boolean('f2_taf')->default(false)->after('f2_evaluasi');
            $table->boolean('f2_juskeb')->default(false)->after('f2_taf');
            $table->boolean('f2_bod_dm')->default(false)->after('f2_juskeb');
            
            // Add missing F3 fields used in views
            $table->boolean('f3_p3_1')->default(false)->after('f2_bod_dm');
            $table->boolean('f3_sph')->default(false)->after('f3_p3_1');
            $table->boolean('f3_juskeb')->default(false)->after('f3_sph');
            $table->boolean('f3_bod_dm')->default(false)->after('f3_juskeb');
            
            // Add missing F4 fields used in views
            $table->boolean('f4_p3_2')->default(false)->after('f3_bod_dm');
            $table->boolean('f4_pks')->default(false)->after('f4_p3_2');
            $table->boolean('f4_bast')->default(false)->after('f4_pks');
            
            // Add missing F5/DELIVERY fields used in views
            $table->boolean('f5_p4')->default(false)->after('f4_bast');
            $table->boolean('f5_p5')->default(false)->after('f5_p4');
            
            // Change delivery_nilai_billcomp to decimal for calculations
            $table->decimal('delivery_nilai_billcomp', 15, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('funnel_tracking', function (Blueprint $table) {
            $table->dropColumn([
                'f1_p0_p1',
                'f1_juskeb',
                'f1_bod_dm',
                'f2_p2',
                'f2_evaluasi',
                'f2_taf',
                'f2_juskeb',
                'f2_bod_dm',
                'f3_p3_1',
                'f3_sph',
                'f3_juskeb',
                'f3_bod_dm',
                'f4_p3_2',
                'f4_pks',
                'f4_bast',
                'f5_p4',
                'f5_p5',
            ]);
        });
    }
};
