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
    Schema::table('psaks', function (Blueprint $table) {
        $table->timestamp('real_updated_at')->nullable()->after('real_rp');
    });
}

public function down(): void
{
    Schema::table('psaks', function (Blueprint $table) {
        $table->dropColumn('real_updated_at');
    });
}
};
