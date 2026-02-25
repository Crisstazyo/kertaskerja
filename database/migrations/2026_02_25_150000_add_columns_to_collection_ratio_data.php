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
        Schema::table('collection_ratio_data', function (Blueprint $table) {
            $table->string('segment')->after('type')->nullable(); // SME, GOV, PRIVATE, SOE
            $table->decimal('target_ratio', 10, 2)->after('ratio')->nullable();
            $table->decimal('ratio_aktual', 10, 2)->after('target_ratio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collection_ratio_data', function (Blueprint $table) {
            $table->dropColumn(['segment', 'target_ratio', 'ratio_aktual']);
        });
    }
};
