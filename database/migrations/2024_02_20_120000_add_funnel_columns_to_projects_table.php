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
        Schema::table('projects', function (Blueprint $table) {
            // Static columns
            $table->string('cc')->nullable()->after('id_lop');
            $table->string('phn_bulan_billcomp')->nullable()->after('mitra');
            $table->string('est_nilai_bc')->nullable()->after('phn_bulan_billcomp');
            
            // F0 - Lead
            $table->string('f0_inisiasi_solusi')->nullable();
            
            // F1 - Opportunity
            $table->string('f1_technical_budget')->nullable();
            
            // F2 - Self Assessment
            $table->string('f2_p0_p1_jukbok')->nullable();
            $table->string('f2_p3_permintaan_penawaran')->nullable();
            $table->string('f2_p4_rapat_penjelasan')->nullable();
            $table->string('f2_p5_evaluasi_sph')->nullable();
            
            // F3 - Project Assessment
            $table->string('f3_p6_klarifikasi_negosiasi')->nullable();
            $table->string('f3_p7_penetapan_mitra')->nullable();
            $table->string('f3_submit_proposal')->nullable();
            
            // F5 - Win
            $table->string('f5_p8_surat_penetapan')->nullable();
            
            // DELIVERY
            $table->string('del_kontrak_layanan')->nullable();
            $table->string('del_baso')->nullable();
            
            // BILLING COMPLETE
            $table->string('billing_complete')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'cc',
                'phn_bulan_billcomp',
                'est_nilai_bc',
                'f0_inisiasi_solusi',
                'f1_technical_budget',
                'f2_p0_p1_jukbok',
                'f2_p3_permintaan_penawaran',
                'f2_p4_rapat_penjelasan',
                'f2_p5_evaluasi_sph',
                'f3_p6_klarifikasi_negosiasi',
                'f3_p7_penetapan_mitra',
                'f3_submit_proposal',
                'f5_p8_surat_penetapan',
                'del_kontrak_layanan',
                'del_baso',
                'billing_complete',
            ]);
        });
    }
};
