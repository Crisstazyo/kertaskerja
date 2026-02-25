<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_items', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('unit_scope')->nullable();
            $table->string('indicator')->nullable();
            $table->string('denom')->nullable();

            $table->bigInteger('commitment_amount')->nullable();
            $table->decimal('commitment_rp_million', 16, 2)->nullable();
            $table->bigInteger('real_amount')->nullable();
            $table->decimal('real_rp_amount', 16, 2)->nullable();

            $table->decimal('fairness', 8, 4)->nullable();
            $table->decimal('ach', 8, 4)->nullable();
            $table->decimal('score', 8, 4)->nullable();

            // extra columns referenced in view
            $table->string('status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_items');
    }
};
