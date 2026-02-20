<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, convert empty strings to NULL for clean conversion
        DB::statement("UPDATE projects SET f0_inisiasi_solusi = NULL WHERE f0_inisiasi_solusi = ''");
        DB::statement("UPDATE projects SET f1_technical_budget = NULL WHERE f1_technical_budget = ''");
        DB::statement("UPDATE projects SET f2_p5_evaluasi_sph = NULL WHERE f2_p5_evaluasi_sph = ''");
        DB::statement("UPDATE projects SET f5_p8_surat_penetapan = NULL WHERE f5_p8_surat_penetapan = ''");
        DB::statement("UPDATE projects SET negosiasi = NULL WHERE negosiasi = ''");
        
        Schema::table('projects', function (Blueprint $table) {
            // Convert F0, F1 to boolean
            $table->boolean('f0_inisiasi_solusi')->nullable()->default(null)->change();
            $table->boolean('f1_technical_budget')->nullable()->default(null)->change();
            
            // Convert F2 P5 to boolean
            $table->boolean('f2_p5_evaluasi_sph')->nullable()->default(null)->change();
            
            // Convert F5 P8 (Surat Penetapan) to boolean
            $table->boolean('f5_p8_surat_penetapan')->nullable()->default(null)->change();
            
            // Convert F4 (Negosiasi/P9) to boolean
            $table->boolean('negosiasi')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Revert to string
            $table->string('f0_inisiasi_solusi')->nullable()->change();
            $table->string('f1_technical_budget')->nullable()->change();
            $table->string('f2_p5_evaluasi_sph')->nullable()->change();
            $table->string('f5_p8_surat_penetapan')->nullable()->change();
            $table->string('negosiasi')->nullable()->change();
        });
    }
};
