<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lop_qualified_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_id')->constrained('lop_qualified_imports')->onDelete('cascade');
            $table->string('no')->nullable();
            $table->string('project')->nullable();
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

    public function down(): void
    {
        Schema::dropIfExists('lop_qualified_data');
    }
};
