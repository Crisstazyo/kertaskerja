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
        // Update all 4 PSAK tables
        $tables = ['psak_government', 'psak_private', 'psak_soe', 'psak_sme'];
        
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                // Drop old complex columns
                $table->dropColumn([
                    'nc_step14_commitment_ssl',
                    'nc_step14_real_ssl',
                    'nc_step14_commitment_rp',
                    'nc_step14_real_rp',
                    'nc_step5_commitment_ssl',
                    'nc_step5_real_ssl',
                    'nc_step5_commitment_rp',
                    'nc_step5_real_rp',
                    'nc_konfirmasi_commitment_ssl',
                    'nc_konfirmasi_real_ssl',
                    'nc_konfirmasi_commitment_rp',
                    'nc_konfirmasi_real_rp',
                    'nc_splitbill_commitment_ssl',
                    'nc_splitbill_real_ssl',
                    'nc_splitbill_commitment_rp',
                    'nc_splitbill_real_rp',
                    'nc_crvariable_commitment_ssl',
                    'nc_crvariable_real_ssl',
                    'nc_crvariable_commitment_rp',
                    'nc_crvariable_real_rp',
                    'nc_unidentified_commitment_ssl',
                    'nc_unidentified_real_ssl',
                    'nc_unidentified_commitment_rp',
                    'nc_unidentified_real_rp',
                ]);
                
                // Add simple 4 fields
                $table->decimal('commitment_ssl', 20, 2)->default(0)->after('tanggal');
                $table->decimal('real_ssl', 20, 2)->default(0)->after('commitment_ssl');
                $table->decimal('commitment_rp', 20, 2)->default(0)->after('real_ssl');
                $table->decimal('real_rp', 20, 2)->default(0)->after('commitment_rp');
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
                // Drop simple columns
                $table->dropColumn(['commitment_ssl', 'real_ssl', 'commitment_rp', 'real_rp']);
                
                // Restore old complex columns
                $table->decimal('nc_step14_commitment_ssl', 20, 2)->default(0);
                $table->decimal('nc_step14_real_ssl', 20, 2)->default(0);
                $table->decimal('nc_step14_commitment_rp', 20, 2)->default(0);
                $table->decimal('nc_step14_real_rp', 20, 2)->default(0);
                $table->decimal('nc_step5_commitment_ssl', 20, 2)->default(0);
                $table->decimal('nc_step5_real_ssl', 20, 2)->default(0);
                $table->decimal('nc_step5_commitment_rp', 20, 2)->default(0);
                $table->decimal('nc_step5_real_rp', 20, 2)->default(0);
                $table->decimal('nc_konfirmasi_commitment_ssl', 20, 2)->default(0);
                $table->decimal('nc_konfirmasi_real_ssl', 20, 2)->default(0);
                $table->decimal('nc_konfirmasi_commitment_rp', 20, 2)->default(0);
                $table->decimal('nc_konfirmasi_real_rp', 20, 2)->default(0);
                $table->decimal('nc_splitbill_commitment_ssl', 20, 2)->default(0);
                $table->decimal('nc_splitbill_real_ssl', 20, 2)->default(0);
                $table->decimal('nc_splitbill_commitment_rp', 20, 2)->default(0);
                $table->decimal('nc_splitbill_real_rp', 20, 2)->default(0);
                $table->decimal('nc_crvariable_commitment_ssl', 20, 2)->default(0);
                $table->decimal('nc_crvariable_real_ssl', 20, 2)->default(0);
                $table->decimal('nc_crvariable_commitment_rp', 20, 2)->default(0);
                $table->decimal('nc_crvariable_real_rp', 20, 2)->default(0);
                $table->decimal('nc_unidentified_commitment_ssl', 20, 2)->default(0);
                $table->decimal('nc_unidentified_real_ssl', 20, 2)->default(0);
                $table->decimal('nc_unidentified_commitment_rp', 20, 2)->default(0);
                $table->decimal('nc_unidentified_real_rp', 20, 2)->default(0);
            });
        }
    }
};
