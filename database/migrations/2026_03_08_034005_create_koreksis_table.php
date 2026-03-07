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
        Schema::create('koreksis', function (Blueprint $table) {
            $table->id();
            $table->integer('no')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->decimal('nilai_komitmen', 20, 2)->nullable();
            $table->enum('progress', ['done', 'on-progress'])->default('on-progress');
            $table->decimal('realisasi', 20, 2)->nullable();
            $table->unsignedBigInteger('imports_log_id')->nullable();
            $table->timestamps();
            $table->foreign('imports_log_id')->references('id')->on('scalling_imports')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koreksis');
    }
};
