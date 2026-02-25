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
        // Billing Perdanan Table
        Schema::create('billing_perdanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('entry_date');
            $table->string('type'); // Baru/Koreksi
            $table->decimal('ratio', 10, 2)->nullable();
            $table->string('keterangan')->nullable();
            $table->text('description')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // C3MR Table
        Schema::create('c3mr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('entry_date');
            $table->string('type'); // Baru/Koreksi
            $table->decimal('ratio', 10, 2)->nullable();
            $table->string('keterangan')->nullable();
            $table->text('description')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // UTIP Data Table
        Schema::create('utip_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('entry_date');
            $table->string('type'); // Baru/Koreksi
            $table->string('category'); // New UTIP/Corrective UTIP
            $table->decimal('value', 10, 2)->nullable();
            $table->string('keterangan')->nullable();
            $table->text('description')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Collection Ratio Data Table
        Schema::create('collection_ratio_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('entry_date');
            $table->string('type'); // Baru/Koreksi
            $table->decimal('ratio', 10, 2)->nullable();
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
        Schema::dropIfExists('collection_ratio_data');
        Schema::dropIfExists('utip_data');
        Schema::dropIfExists('c3mr');
        Schema::dropIfExists('billing_perdanan');
    }
};
