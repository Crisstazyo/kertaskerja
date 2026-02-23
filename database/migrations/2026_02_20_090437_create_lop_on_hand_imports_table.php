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
        Schema::create('lop_on_hand_imports', function (Blueprint $table) {
            $table->id();
            $table->string('uploaded_by'); // Admin email who uploaded
            $table->string('file_name');
            $table->integer('total_rows')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lop_on_hand_imports');
    }
};
