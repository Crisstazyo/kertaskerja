<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funnel_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('data_type'); // 'on_hand', 'qualified', 'koreksi', 'initiate'
            $table->unsignedBigInteger('data_id'); // ID dari tabel data yang terkait
            
            // F0 - Lead
            $table->boolean('f0_lead')->default(false);
            $table->boolean('f0_inisiasi_solusi')->default(false);
            $table->boolean('f0_technical_proposal')->default(false);
            
            // F1 - Opportunity
            $table->boolean('f1_p0_p1_juskeb')->default(false);
            
            // F2 - Self Assessment & Management Solution
            $table->boolean('f2_p2_evaluasi')->default(false);
            $table->boolean('f2_p3_permintaan_harga')->default(false);
            $table->boolean('f2_p4_rapat_penjelasan')->default(false);
            $table->boolean('f2_offering_harga')->default(false);
            $table->boolean('f2_p5_evaluasi_sph')->default(false);
            
            // F3 - Project Assessment (RPA)
            $table->boolean('f3_propos_al')->default(false);
            $table->boolean('f3_p6_klarifikasi')->default(false);
            $table->boolean('f3_p7_penetapan')->default(false);
            $table->boolean('f3_submit_proposal')->default(false);
            
            // F4 - Negosiasi
            $table->boolean('f4_negosiasi')->default(false);
            $table->boolean('f4_surat_kesanggupan')->default(false);
            $table->boolean('f4_p8_surat_pemenang')->default(false);
            
            // F5 - Win
            $table->boolean('f5_kontrak_layanan')->default(false);
            
            // DELIVERY
            $table->boolean('delivery_billing_complete')->default(false);
            $table->string('delivery_nilai_billcomp')->nullable();
            $table->string('delivery_baso')->nullable();
            
            $table->timestamps();
            
            // Index untuk query lebih cepat
            $table->index(['data_type', 'data_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funnel_tracking');
    }
};
