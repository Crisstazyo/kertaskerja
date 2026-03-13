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
        Schema::table('ct0s', function (Blueprint $table) {
            $table->timestamp('real_updated_at')->nullable()->after('real_ratio');
        });

        Schema::table('ctcs', function (Blueprint $table) {
            $table->timestamp('real_updated_at')->nullable()->after('real_ratio');
        });
    }

    public function down(): void
    {
        Schema::table('ct0s', function (Blueprint $table) {
            $table->dropColumn('real_updated_at');
        });

        Schema::table('ctcs', function (Blueprint $table) {
            $table->dropColumn('real_updated_at');
        });
    }
};
