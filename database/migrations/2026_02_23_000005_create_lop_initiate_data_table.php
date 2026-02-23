<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lop_initiate_data', function (Blueprint $table) {
            $table->id();
            $table->enum('entity_type', ['government', 'private', 'soe']);
            $table->string('created_by');
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
        Schema::dropIfExists('lop_initiate_data');
    }
};
