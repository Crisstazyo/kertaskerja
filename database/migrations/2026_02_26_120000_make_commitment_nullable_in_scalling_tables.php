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
        Schema::table('scalling_hsi_agency', function (Blueprint $table) {
            $table->integer('commitment')->nullable()->default(null)->comment('SSL')->change();
        });

        Schema::table('scalling_telda', function (Blueprint $table) {
            $table->decimal('commitment', 15, 2)->nullable()->default(null)->comment('Rupiah')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scalling_hsi_agency', function (Blueprint $table) {
            $table->integer('commitment')->default(0)->comment('SSL')->change();
        });

        Schema::table('scalling_telda', function (Blueprint $table) {
            $table->decimal('commitment', 15, 2)->default(0)->comment('Rupiah')->change();
        });
    }
};
