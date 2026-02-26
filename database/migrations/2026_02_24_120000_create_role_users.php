<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create users for each role
        // NOTE: Hanya gunakan role yang didukung oleh kolom enum di tabel users
        $users = [
            [
                'name' => 'Government User',
                'email' => 'government@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'government',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Private User',
                'email' => 'private@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'private',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SOE User',
                'email' => 'soe@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'soe',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SME User',
                'email' => 'sme@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'sme',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Collection User',
                'email' => 'collection1@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'collection',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CTC User',
                'email' => 'ctc@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'ctc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rising Star User',
                'email' => 'risingstar1@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'rising-star',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            // Only insert if email doesn't exist
            if (!DB::table('users')->where('email', $user['email'])->exists()) {
                DB::table('users')->insert($user);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->whereIn('email', [
            'government@gmail.com',
            'private@gmail.com',
            'soe@gmail.com',
            'sme@gmail.com',
        ])->delete();
    }
};
