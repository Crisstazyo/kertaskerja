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
        Schema::create('rising_star_types', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Menyimpan nomor rising star dari 1-4
            $table->string('name')->unique(); // menyimpan sub menu rising star
            $table->timestamps();
        });
        DB::table('rising_star_types')->insert([
            [
                'type' => '1',
                'name' => 'Visiting AM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => '1',
                'name' => 'Visiting GM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => '1',
                'name' => 'Visiting HOTD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => '2',
                'name' => 'Profilling Maps AM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => '2',
                'name' => 'Profilling Overall HOTD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => '3',
                'name' => 'Kecukupan LOP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => '4',
                'name' => 'AOSODOMORO 0-3 Bulan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => '4',
                'name' => 'AOSODOMORO > 3 Bulan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rising_star_types');
    }
};
