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
        Schema::create('scalling_gov_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scalling_data_id')->constrained('scalling_data')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Gov user who filled it
            $table->integer('row_index'); // Which row in the scalling data this response is for
            $table->json('response_data'); // JSON data filled by gov user
            $table->enum('status', ['draft', 'submitted'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scalling_gov_responses');
    }
};
