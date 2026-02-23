<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lop_koreksi_imports', function (Blueprint $table) {
            $table->id();
            $table->string('uploaded_by');
            $table->string('file_name');
            $table->integer('total_rows')->default(0);
            $table->enum('entity_type', ['government', 'private', 'soe']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lop_koreksi_imports');
    }
};
