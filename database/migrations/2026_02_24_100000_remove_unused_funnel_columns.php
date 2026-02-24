<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove columns that were incorrectly added and are not used by the application
     */
    public function up(): void
    {
        Schema::table('funnel_tracking', function (Blueprint $table) {
            // Drop F1 columns that are not used (app uses f1_p0_p1_juskeb instead)
            if (Schema::hasColumn('funnel_tracking', 'f1_p0_p1')) {
                $table->dropColumn('f1_p0_p1');
            }
            if (Schema::hasColumn('funnel_tracking', 'f1_juskeb')) {
                $table->dropColumn('f1_juskeb');
            }
            if (Schema::hasColumn('funnel_tracking', 'f1_bod_dm')) {
                $table->dropColumn('f1_bod_dm');
            }
            
            // Drop F2 columns that are not used (app uses f2_p2_evaluasi not f2_p2/f2_evaluasi)
            if (Schema::hasColumn('funnel_tracking', 'f2_p2')) {
                $table->dropColumn('f2_p2');
            }
            if (Schema::hasColumn('funnel_tracking', 'f2_evaluasi')) {
                $table->dropColumn('f2_evaluasi');
            }
            if (Schema::hasColumn('funnel_tracking', 'f2_taf')) {
                $table->dropColumn('f2_taf');
            }
            if (Schema::hasColumn('funnel_tracking', 'f2_juskeb')) {
                $table->dropColumn('f2_juskeb');
            }
            if (Schema::hasColumn('funnel_tracking', 'f2_bod_dm')) {
                $table->dropColumn('f2_bod_dm');
            }
            
            // Drop F3 columns that are not used (app uses original fields)
            if (Schema::hasColumn('funnel_tracking', 'f3_p3_1')) {
                $table->dropColumn('f3_p3_1');
            }
            if (Schema::hasColumn('funnel_tracking', 'f3_sph')) {
                $table->dropColumn('f3_sph');
            }
            if (Schema::hasColumn('funnel_tracking', 'f3_juskeb')) {
                $table->dropColumn('f3_juskeb');
            }
            if (Schema::hasColumn('funnel_tracking', 'f3_bod_dm')) {
                $table->dropColumn('f3_bod_dm');
            }
            
            // Drop F4 columns that are not used (app uses original fields)
            if (Schema::hasColumn('funnel_tracking', 'f4_p3_2')) {
                $table->dropColumn('f4_p3_2');
            }
            if (Schema::hasColumn('funnel_tracking', 'f4_pks')) {
                $table->dropColumn('f4_pks');
            }
            if (Schema::hasColumn('funnel_tracking', 'f4_bast')) {
                $table->dropColumn('f4_bast');
            }
            
            // Drop F5 columns that are not used (app uses f5_kontrak_layanan)
            if (Schema::hasColumn('funnel_tracking', 'f5_p4')) {
                $table->dropColumn('f5_p4');
            }
            if (Schema::hasColumn('funnel_tracking', 'f5_p5')) {
                $table->dropColumn('f5_p5');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funnel_tracking', function (Blueprint $table) {
            // Re-add the columns if rollback is needed
            $table->boolean('f1_p0_p1')->default(false);
            $table->boolean('f1_juskeb')->default(false);
            $table->boolean('f1_bod_dm')->default(false);
            $table->boolean('f2_p2')->default(false);
            $table->boolean('f2_evaluasi')->default(false);
            $table->boolean('f2_taf')->default(false);
            $table->boolean('f2_juskeb')->default(false);
            $table->boolean('f2_bod_dm')->default(false);
            $table->boolean('f3_p3_1')->default(false);
            $table->boolean('f3_sph')->default(false);
            $table->boolean('f3_juskeb')->default(false);
            $table->boolean('f3_bod_dm')->default(false);
            $table->boolean('f4_p3_2')->default(false);
            $table->boolean('f4_pks')->default(false);
            $table->boolean('f4_bast')->default(false);
            $table->boolean('f5_p4')->default(false);
            $table->boolean('f5_p5')->default(false);
        });
    }
};
