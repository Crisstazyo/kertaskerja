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
        // Asodomoro 0-3 Bulan Data Table
        Schema::create('asodomoro_0_3_bulan_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('entry_date');
            $table->string('type'); // Baru/Koreksi
            $table->integer('jml_asodomoro')->nullable();
            $table->decimal('nilai_bc', 15, 2)->nullable();
            $table->string('keterangan')->nullable();
            $table->text('description')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Asodomoro Above 3 Bulan Data Table
        Schema::create('asodomoro_above_3_bulan_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('entry_date');
            $table->string('type'); // Baru/Koreksi
            $table->integer('jml_asodomoro')->nullable();
            $table->decimal('nilai_bc', 15, 2)->nullable();
            $table->string('keterangan')->nullable();
            $table->text('description')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asodomoro_above_3_bulan_data');
        Schema::dropIfExists('asodomoro_0_3_bulan_data');
    }
};
