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
        // Visiting Data Table
        Schema::create('visiting_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['komitmen', 'realisasi']);
            $table->integer('month');
            $table->integer('year');
            $table->timestamp('entry_date');
            $table->enum('category', ['visiting_gm', 'visiting_am', 'visiting_hotd']);
            $table->decimal('target_ratio', 5, 2)->nullable();
            $table->decimal('ratio_aktual', 5, 2)->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'type', 'month', 'year', 'category']);
        });

        // Profiling Data Table
        Schema::create('profiling_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['komitmen', 'realisasi']);
            $table->integer('month');
            $table->integer('year');
            $table->timestamp('entry_date');
            $table->enum('category', ['profiling_maps_am', 'profiling_overall_hotd']);
            $table->decimal('target_ratio', 5, 2)->nullable();
            $table->decimal('ratio_aktual', 5, 2)->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'type', 'month', 'year', 'category']);
        });

        // Kecukupan LOP Data Table
        Schema::create('kecukupan_lop_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['komitmen', 'realisasi']);
            $table->integer('month');
            $table->integer('year');
            $table->timestamp('entry_date');
            $table->decimal('target_ratio', 5, 2)->nullable();
            $table->decimal('ratio_aktual', 5, 2)->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'type', 'month', 'year']);
        });

        // Paid CT0 Data Table
        Schema::create('paid_ct0_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['komitmen', 'realisasi']);
            $table->integer('month');
            $table->integer('year');
            $table->timestamp('entry_date');
            $table->string('region', 50);
            $table->decimal('nominal', 15, 2);
            $table->timestamps();
            
            $table->index(['user_id', 'type', 'month', 'year', 'region']);
        });

        // Combat Churn Data Table
        Schema::create('combat_churn_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['komitmen', 'realisasi']);
            $table->integer('month');
            $table->integer('year');
            $table->timestamp('entry_date');
            $table->enum('category', ['winback', 'sales_hsi', 'churn']);
            $table->string('region', 50);
            $table->integer('quantity');
            $table->timestamps();
            
            $table->index(['user_id', 'type', 'month', 'year', 'category', 'region']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combat_churn_data');
        Schema::dropIfExists('paid_ct0_data');
        Schema::dropIfExists('kecukupan_lop_data');
        Schema::dropIfExists('profiling_data');
        Schema::dropIfExists('visiting_data');
    }
};
