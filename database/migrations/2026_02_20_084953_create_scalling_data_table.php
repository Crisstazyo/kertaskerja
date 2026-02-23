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
        Schema::create('scalling_data', function (Blueprint $table) {
            $table->id();
            $table->string('uploaded_by'); // Admin email who uploaded 
            $table->string('file_name'); // Original file name
            $table->json('data'); // JSON data from Excel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scalling_data');
    }
};
