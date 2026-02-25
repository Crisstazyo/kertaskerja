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
        Schema::create('lop_private_correction_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_id')->constrained('lop_private_correction_imports')->onDelete('cascade');
            $table->integer('no');
            $table->string('project');
            $table->string('id_lop')->nullable();
            $table->string('cc')->nullable();
            $table->string('nipnas')->nullable();
            $table->string('am')->nullable();
            $table->string('mitra')->nullable();
            $table->string('plan_bulan_billcom_p_2025')->nullable();
            $table->string('est_nilai_bc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lop_private_correction_data');
    }
};
