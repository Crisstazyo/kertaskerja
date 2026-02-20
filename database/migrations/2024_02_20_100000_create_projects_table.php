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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role'); // government, private, soe
            
            // Basic Info Columns
            $table->string('project_name')->nullable();
            $table->string('id_lop')->nullable();
            $table->string('oc')->nullable();
            $table->string('nipnas')->nullable();
            $table->string('am')->nullable();
            $table->string('mitra')->nullable();
            
            // Lead Funnel (F0)
            $table->string('pra_bahan_eskplorasi')->nullable();
            $table->string('est_nilai_rkp')->nullable();
            
            // Project Health (F1)
            $table->string('project_health')->nullable();
            $table->text('tender_budget_description')->nullable();
            $table->string('kop_m_vendor')->nullable();
            
            // Self Assessment (F2)
            $table->string('p2_evaluasi_tender')->nullable();
            $table->string('p2_evaluasi_bakal_calon')->nullable();
            $table->string('p2_penawaran_harga')->nullable();
            $table->string('p4_hasil_pejelasan')->nullable();
            $table->string('offering_harga_final')->nullable();
            $table->string('p5_evaluasi_bill_mix')->nullable();
            
            // Project Assessment RPA (F3)
            $table->string('p6_notifikasi')->nullable();
            $table->string('p7_negosiasi')->nullable();
            $table->string('p7_negosiasi_dokumen_penawaran')->nullable();
            $table->text('p7_negosiasi_addendum')->nullable();
            
            // Negosiasi (F4)
            $table->string('negosiasi')->nullable();
            $table->string('persiapan_kontrak')->nullable();
            
            // Delivery (F5)
            $table->string('surat')->nullable();
            $table->string('tanda')->nullable();
            $table->string('pr_surat')->nullable();
            
            // Billing Sample
            $table->string('kontrak_tanda_tangan_baut')->nullable();
            $table->string('baut')->nullable();
            $table->string('rabo')->nullable();
            
            // Additional
            $table->text('keterangan')->nullable();
            $table->json('custom_fields')->nullable(); // For dynamic columns
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
