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
        Schema::create('custom_columns', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // government, private, soe
            $table->string('column_name');
            $table->string('column_label');
            $table->string('column_type')->default('text'); // text, number, date, etc
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_columns');
    }
};
