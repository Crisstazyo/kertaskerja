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
        Schema::create('task_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id')->comment('References funnel_tracking.id');
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            
            // F0
            $table->boolean('f0_inisiasi_solusi')->default(false);
            // F1
            $table->boolean('f1_tech_budget')->default(false);
            // F2
            $table->boolean('f2_p0_p1')->default(false);
            $table->boolean('f2_p2')->default(false);
            $table->boolean('f2_p3')->default(false);
            $table->boolean('f2_p4')->default(false);
            $table->boolean('f2_offering')->default(false);
            $table->boolean('f2_p5')->default(false);
            $table->boolean('f2_proposal')->default(false);
            // F3
            $table->boolean('f3_p6')->default(false);
            $table->boolean('f3_p7')->default(false);
            $table->boolean('f3_submit')->default(false);
            // F4
            $table->boolean('f4_negosiasi')->default(false);
            // F5
            $table->boolean('f5_sk_mitra')->default(false);
            $table->boolean('f5_ttd_kontrak')->default(false);
            $table->boolean('f5_p8')->default(false);
            // DELIVERY
            $table->boolean('delivery_kontrak')->default(false);
            $table->string('delivery_baut_bast')->nullable();
            $table->string('delivery_baso')->nullable();
            $table->boolean('delivery_billing_complete')->default(false);
            $table->decimal('delivery_nilai_billcomp', 15, 2)->nullable();
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('task_id')->references('id')->on('funnel_tracking')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Unique constraint: one progress per task per user per date
            $table->unique(['task_id', 'user_id', 'tanggal'], 'task_user_date_unique');
            
            // Indexes for performance
            $table->index('tanggal');
            $table->index(['task_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_progress');
    }
};
