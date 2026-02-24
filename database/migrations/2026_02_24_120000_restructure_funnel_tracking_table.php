<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Restructure funnel_tracking to match the new business requirements
     */
    public function up(): void
    {
        Schema::table('funnel_tracking', function (Blueprint $table) {
            // F0 - Remove f0_lead, keep only f0_inisiasi_solusi
            if (Schema::hasColumn('funnel_tracking', 'f0_lead')) {
                $table->dropColumn('f0_lead');
            }
            
            // F1 - Add f1_tech_budget (moved from f0_technical_proposal)
            if (!Schema::hasColumn('funnel_tracking', 'f1_tech_budget')) {
                $table->boolean('f1_tech_budget')->default(false)->after('f0_inisiasi_solusi');
            }
            
            // F2 - Add new columns
            if (!Schema::hasColumn('funnel_tracking', 'f2_p0_p1')) {
                $table->boolean('f2_p0_p1')->default(false)->after('f1_tech_budget');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f2_p2')) {
                $table->boolean('f2_p2')->default(false)->after('f2_p0_p1');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f2_p3')) {
                $table->boolean('f2_p3')->default(false)->after('f2_p2');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f2_p4')) {
                $table->boolean('f2_p4')->default(false)->after('f2_p3');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f2_offering')) {
                $table->boolean('f2_offering')->default(false)->after('f2_p4');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f2_p5')) {
                $table->boolean('f2_p5')->default(false)->after('f2_offering');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f2_proposal')) {
                $table->boolean('f2_proposal')->default(false)->after('f2_p5');
            }
            
            // F3 - Add new columns
            if (!Schema::hasColumn('funnel_tracking', 'f3_p6')) {
                $table->boolean('f3_p6')->default(false)->after('f2_proposal');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f3_p7')) {
                $table->boolean('f3_p7')->default(false)->after('f3_p6');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f3_submit')) {
                $table->boolean('f3_submit')->default(false)->after('f3_p7');
            }
            
            // F4 - Keep f4_negosiasi
            
            // F5 - Add new columns
            if (!Schema::hasColumn('funnel_tracking', 'f5_sk_mitra')) {
                $table->boolean('f5_sk_mitra')->default(false)->after('f4_negosiasi');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f5_ttd_kontrak')) {
                $table->boolean('f5_ttd_kontrak')->default(false)->after('f5_sk_mitra');
            }
            if (!Schema::hasColumn('funnel_tracking', 'f5_p8')) {
                $table->boolean('f5_p8')->default(false)->after('f5_ttd_kontrak');
            }
            
            // DELIVERY - Add new columns
            if (!Schema::hasColumn('funnel_tracking', 'delivery_kontrak')) {
                $table->boolean('delivery_kontrak')->default(false)->after('f5_p8');
            }
            if (!Schema::hasColumn('funnel_tracking', 'delivery_baut_bast')) {
                $table->string('delivery_baut_bast')->nullable()->after('delivery_kontrak');
            }
            // delivery_baso already exists
            // delivery_billing_complete already exists
            // delivery_nilai_billcomp already exists
        });
        
        // Migrate data from old columns to new columns
        DB::statement('UPDATE funnel_tracking SET f1_tech_budget = f0_technical_proposal WHERE f0_technical_proposal = 1');
        DB::statement('UPDATE funnel_tracking SET f2_p0_p1 = f1_p0_p1_juskeb WHERE f1_p0_p1_juskeb = 1');
        DB::statement('UPDATE funnel_tracking SET f2_p2 = f2_p2_evaluasi WHERE f2_p2_evaluasi = 1');
        DB::statement('UPDATE funnel_tracking SET f2_p3 = f2_p3_permintaan_harga WHERE f2_p3_permintaan_harga = 1');
        DB::statement('UPDATE funnel_tracking SET f2_p4 = f2_p4_rapat_penjelasan WHERE f2_p4_rapat_penjelasan = 1');
        DB::statement('UPDATE funnel_tracking SET f2_offering = f2_offering_harga WHERE f2_offering_harga = 1');
        DB::statement('UPDATE funnel_tracking SET f2_p5 = f2_p5_evaluasi_sph WHERE f2_p5_evaluasi_sph = 1');
        DB::statement('UPDATE funnel_tracking SET f2_proposal = f3_propos_al WHERE f3_propos_al = 1');
        DB::statement('UPDATE funnel_tracking SET f3_p6 = f3_p6_klarifikasi WHERE f3_p6_klarifikasi = 1');
        DB::statement('UPDATE funnel_tracking SET f3_p7 = f3_p7_penetapan WHERE f3_p7_penetapan = 1');
        DB::statement('UPDATE funnel_tracking SET f3_submit = f3_submit_proposal WHERE f3_submit_proposal = 1');
        DB::statement('UPDATE funnel_tracking SET f5_sk_mitra = f4_surat_kesanggupan WHERE f4_surat_kesanggupan = 1');
        DB::statement('UPDATE funnel_tracking SET f5_ttd_kontrak = f5_kontrak_layanan WHERE f5_kontrak_layanan = 1');
        DB::statement('UPDATE funnel_tracking SET f5_p8 = f4_p8_surat_pemenang WHERE f4_p8_surat_pemenang = 1');
        
        // Drop foreign key constraint before dropping updated_by column
        Schema::table('funnel_tracking', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
        });
        
        // Drop old columns
        Schema::table('funnel_tracking', function (Blueprint $table) {
            $table->dropColumn([
                'f0_technical_proposal',
                'f1_p0_p1_juskeb',
                'f2_p2_evaluasi',
                'f2_p3_permintaan_harga',
                'f2_p4_rapat_penjelasan',
                'f2_offering_harga',
                'f2_p5_evaluasi_sph',
                'f3_propos_al',
                'f3_p6_klarifikasi',
                'f3_p7_penetapan',
                'f3_submit_proposal',
                'f4_surat_kesanggupan',
                'f4_p8_surat_pemenang',
                'f5_kontrak_layanan',
                'updated_by',
                'last_updated_at',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funnel_tracking', function (Blueprint $table) {
            // Add back old columns
            $table->boolean('f0_lead')->default(false);
            $table->boolean('f0_technical_proposal')->default(false);
            $table->boolean('f1_p0_p1_juskeb')->default(false);
            $table->boolean('f2_p2_evaluasi')->default(false);
            $table->boolean('f2_p3_permintaan_harga')->default(false);
            $table->boolean('f2_p4_rapat_penjelasan')->default(false);
            $table->boolean('f2_offering_harga')->default(false);
            $table->boolean('f2_p5_evaluasi_sph')->default(false);
            $table->boolean('f3_propos_al')->default(false);
            $table->boolean('f3_p6_klarifikasi')->default(false);
            $table->boolean('f3_p7_penetapan')->default(false);
            $table->boolean('f3_submit_proposal')->default(false);
            $table->boolean('f4_surat_kesanggupan')->default(false);
            $table->boolean('f4_p8_surat_pemenang')->default(false);
            $table->boolean('f5_kontrak_layanan')->default(false);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('last_updated_at')->nullable();
            
            // Drop new columns
            $table->dropColumn([
                'f1_tech_budget',
                'f2_p0_p1',
                'f2_p2',
                'f2_p3',
                'f2_p4',
                'f2_offering',
                'f2_p5',
                'f2_proposal',
                'f3_p6',
                'f3_p7',
                'f3_submit',
                'f5_sk_mitra',
                'f5_ttd_kontrak',
                'f5_p8',
                'delivery_kontrak',
                'delivery_baut_bast',
            ]);
        });
    }
};
