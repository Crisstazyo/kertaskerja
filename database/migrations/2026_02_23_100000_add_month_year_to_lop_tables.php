<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lop_on_hand_imports', function (Blueprint $table) {
            $table->integer('month')->nullable()->after('entity_type');
            $table->integer('year')->nullable()->after('month');
        });
        
        Schema::table('lop_qualified_imports', function (Blueprint $table) {
            $table->integer('month')->nullable()->after('entity_type');
            $table->integer('year')->nullable()->after('month');
        });
        
        Schema::table('lop_koreksi_imports', function (Blueprint $table) {
            $table->integer('month')->nullable()->after('entity_type');
            $table->integer('year')->nullable()->after('month');
        });
        
        Schema::table('lop_initiate_data', function (Blueprint $table) {
            $table->integer('month')->nullable()->after('entity_type');
            $table->integer('year')->nullable()->after('month');
        });
    }

    public function down(): void
    {
        Schema::table('lop_on_hand_imports', function (Blueprint $table) {
            $table->dropColumn(['month', 'year']);
        });
        
        Schema::table('lop_qualified_imports', function (Blueprint $table) {
            $table->dropColumn(['month', 'year']);
        });
        
        Schema::table('lop_koreksi_imports', function (Blueprint $table) {
            $table->dropColumn(['month', 'year']);
        });
        
        Schema::table('lop_initiate_data', function (Blueprint $table) {
            $table->dropColumn(['month', 'year']);
        });
    }
};
