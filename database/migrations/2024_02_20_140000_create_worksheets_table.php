<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('worksheets', function (Blueprint $table) {
            $table->id();
            $table->integer('month'); // 1-12
            $table->integer('year'); // 2024, 2025, etc
            $table->enum('role', ['government', 'private', 'soe']);
            $table->string('name')->nullable(); // Optional custom name
            $table->timestamps();
            
            // Unique constraint: one worksheet per month/year/role
            $table->unique(['month', 'year', 'role']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('worksheets');
    }
};
