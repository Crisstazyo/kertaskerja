<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lop_admin_notes', function (Blueprint $table) {
            $table->id();
            $table->enum('entity_type', ['government', 'private', 'soe']);
            $table->string('category'); // 'on_hand', 'qualified', 'koreksi', 'initiate'
            $table->integer('month');
            $table->integer('year');
            $table->text('note');
            $table->string('created_by');
            $table->timestamps();
            
            // Index untuk query
            $table->index(['entity_type', 'category', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lop_admin_notes');
    }
};
