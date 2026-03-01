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
    Schema::create('project_items', function (Blueprint $table) {
        $table->id();
        $table->string('unit_scope');
        $table->string('indicator');
        $table->string('denom');
        $table->integer('commitment_amount');
        $table->decimal('commitment_rp_million', 15, 2);
        $table->integer('real_amount');
        $table->decimal('real_rp_amount', 15, 2);
        $table->decimal('fairness', 5, 2);
        $table->decimal('ach', 5, 2);
        $table->decimal('score', 5, 2);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_items');
    }
};
