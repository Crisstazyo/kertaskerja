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
        Schema::create('psak_sme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            
            // Not Close Step 1-4
            $table->decimal('nc_step14_commitment_ssl', 20, 2)->default(0);
            $table->decimal('nc_step14_real_ssl', 20, 2)->default(0);
            $table->decimal('nc_step14_commitment_rp', 20, 2)->default(0);
            $table->decimal('nc_step14_real_rp', 20, 2)->default(0);
            
            // Not Close Step 5
            $table->decimal('nc_step5_commitment_ssl', 20, 2)->default(0);
            $table->decimal('nc_step5_real_ssl', 20, 2)->default(0);
            $table->decimal('nc_step5_commitment_rp', 20, 2)->default(0);
            $table->decimal('nc_step5_real_rp', 20, 2)->default(0);
            
            // Not Close Konfirmasi
            $table->decimal('nc_konfirmasi_commitment_ssl', 20, 2)->default(0);
            $table->decimal('nc_konfirmasi_real_ssl', 20, 2)->default(0);
            $table->decimal('nc_konfirmasi_commitment_rp', 20, 2)->default(0);
            $table->decimal('nc_konfirmasi_real_rp', 20, 2)->default(0);
            
            // Not Close Split Bill
            $table->decimal('nc_splitbill_commitment_ssl', 20, 2)->default(0);
            $table->decimal('nc_splitbill_real_ssl', 20, 2)->default(0);
            $table->decimal('nc_splitbill_commitment_rp', 20, 2)->default(0);
            $table->decimal('nc_splitbill_real_rp', 20, 2)->default(0);
            
            // Not Close CR Variable
            $table->decimal('nc_crvariable_commitment_ssl', 20, 2)->default(0);
            $table->decimal('nc_crvariable_real_ssl', 20, 2)->default(0);
            $table->decimal('nc_crvariable_commitment_rp', 20, 2)->default(0);
            $table->decimal('nc_crvariable_real_rp', 20, 2)->default(0);
            
            // Not Close Unidentified KB
            $table->decimal('nc_unidentified_commitment_ssl', 20, 2)->default(0);
            $table->decimal('nc_unidentified_real_ssl', 20, 2)->default(0);
            $table->decimal('nc_unidentified_commitment_rp', 20, 2)->default(0);
            $table->decimal('nc_unidentified_real_rp', 20, 2)->default(0);
            
            $table->timestamps();
            
            // Unique constraint: one entry per user per day
            $table->unique(['user_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psak_sme');
    }
};
