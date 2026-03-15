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
    Schema::table('hsis', function (Blueprint $table) {
        $table->timestamp('real_updated_at')->nullable()->after('real_ratio');
    });

    Schema::table('teldas', function (Blueprint $table) {
        $table->timestamp('real_updated_at')->nullable()->after('real_ratio');
    });
}

public function down(): void
{
    Schema::table('hsis', function (Blueprint $table) {
        $table->dropColumn('real_updated_at');
    });

    Schema::table('teldas', function (Blueprint $table) {
        $table->dropColumn('real_updated_at');
    });
}
};
