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
        // CTC On Hand Import
        Schema::create('lop_ctc_on_hand_imports', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->integer('total_rows');
            $table->integer('month');
            $table->integer('year');
            $table->string('uploaded_by');
            $table->timestamps();
        });

        // CTC On Hand Data
        Schema::create('lop_ctc_on_hand_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_id');
            $table->integer('no')->nullable();
            $table->string('project')->nullable();
            $table->string('id_lop')->nullable();
            $table->string('cc')->nullable();
            $table->string('nipnas')->nullable();
            $table->string('am')->nullable();
            $table->string('mitra')->nullable();
            $table->string('plan_bulan_billcom_p_2025')->nullable();
            $table->string('est_nilai_bc')->nullable();
            $table->timestamps();

            $table->foreign('import_id')
                  ->references('id')
                  ->on('lop_ctc_on_hand_imports')
                  ->onDelete('cascade');
        });

        // CTC Qualified Import
        Schema::create('lop_ctc_qualified_imports', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->integer('total_rows');
            $table->integer('month');
            $table->integer('year');
            $table->string('uploaded_by');
            $table->timestamps();
        });

        // CTC Qualified Data
        Schema::create('lop_ctc_qualified_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_id');
            $table->integer('no')->nullable();
            $table->string('project')->nullable();
            $table->string('id_lop')->nullable();
            $table->string('cc')->nullable();
            $table->string('nipnas')->nullable();
            $table->string('am')->nullable();
            $table->string('mitra')->nullable();
            $table->string('plan_bulan_billcom_p_2025')->nullable();
            $table->string('est_nilai_bc')->nullable();
            $table->timestamps();

            $table->foreign('import_id')
                  ->references('id')
                  ->on('lop_ctc_qualified_imports')
                  ->onDelete('cascade');
        });

        // CTC Correction Import
        Schema::create('lop_ctc_correction_imports', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->integer('total_rows');
            $table->integer('month');
            $table->integer('year');
            $table->string('uploaded_by');
            $table->timestamps();
        });

        // CTC Correction Data
        Schema::create('lop_ctc_correction_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_id');
            $table->integer('no')->nullable();
            $table->string('project')->nullable();
            $table->string('id_lop')->nullable();
            $table->string('cc')->nullable();
            $table->string('nipnas')->nullable();
            $table->string('am')->nullable();
            $table->string('mitra')->nullable();
            $table->string('plan_bulan_billcom_p_2025')->nullable();
            $table->string('est_nilai_bc')->nullable();
            $table->timestamps();

            $table->foreign('import_id')
                  ->references('id')
                  ->on('lop_ctc_correction_imports')
                  ->onDelete('cascade');
        });

        // CTC Initiated Data
        Schema::create('lop_ctc_initiated_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_id');
            $table->integer('no')->nullable();
            $table->string('project')->nullable();
            $table->string('id_lop')->nullable();
            $table->string('cc')->nullable();
            $table->string('nipnas')->nullable();
            $table->string('am')->nullable();
            $table->string('mitra')->nullable();
            $table->string('plan_bulan_billcom_p_2025')->nullable();
            $table->string('est_nilai_bc')->nullable();
            $table->timestamps();

            $table->foreign('import_id')
                  ->references('id')
                  ->on('lop_ctc_on_hand_imports')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lop_ctc_initiated_data');
        Schema::dropIfExists('lop_ctc_correction_data');
        Schema::dropIfExists('lop_ctc_correction_imports');
        Schema::dropIfExists('lop_ctc_qualified_data');
        Schema::dropIfExists('lop_ctc_qualified_imports');
        Schema::dropIfExists('lop_ctc_on_hand_data');
        Schema::dropIfExists('lop_ctc_on_hand_imports');
    }
};
