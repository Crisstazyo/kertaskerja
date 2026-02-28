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
        Schema::table('scalling_telda', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['commitment', 'real']);
            
            // Add columns for 9 Telda locations
            // Each telda has commitment and real
            $table->decimal('lubuk_pakam_commitment', 15, 2)->nullable();
            $table->decimal('lubuk_pakam_real', 15, 2)->nullable();
            
            $table->decimal('binjai_commitment', 15, 2)->nullable();
            $table->decimal('binjai_real', 15, 2)->nullable();
            
            $table->decimal('siantar_commitment', 15, 2)->nullable();
            $table->decimal('siantar_real', 15, 2)->nullable();
            
            $table->decimal('kisaran_commitment', 15, 2)->nullable();
            $table->decimal('kisaran_real', 15, 2)->nullable();
            
            $table->decimal('kabanjahe_commitment', 15, 2)->nullable();
            $table->decimal('kabanjahe_real', 15, 2)->nullable();
            
            $table->decimal('rantau_prapat_commitment', 15, 2)->nullable();
            $table->decimal('rantau_prapat_real', 15, 2)->nullable();
            
            $table->decimal('toba_commitment', 15, 2)->nullable();
            $table->decimal('toba_real', 15, 2)->nullable();
            
            $table->decimal('sibolga_commitment', 15, 2)->nullable();
            $table->decimal('sibolga_real', 15, 2)->nullable();
            
            $table->decimal('padang_sidempuan_commitment', 15, 2)->nullable();
            $table->decimal('padang_sidempuan_real', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scalling_telda', function (Blueprint $table) {
            // Drop all telda columns
            $table->dropColumn([
                'lubuk_pakam_commitment', 'lubuk_pakam_real',
                'binjai_commitment', 'binjai_real',
                'siantar_commitment', 'siantar_real',
                'kisaran_commitment', 'kisaran_real',
                'kabanjahe_commitment', 'kabanjahe_real',
                'rantau_prapat_commitment', 'rantau_prapat_real',
                'toba_commitment', 'toba_real',
                'sibolga_commitment', 'sibolga_real',
                'padang_sidempuan_commitment', 'padang_sidempuan_real',
            ]);
            
            // Restore old columns
            $table->decimal('commitment', 15, 2)->default(0);
            $table->decimal('real', 15, 2)->nullable();
        });
    }
};
