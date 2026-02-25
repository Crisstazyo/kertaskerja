<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CollectionCtcRisingStarUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            // Collection Users
            [
                'name' => 'Collection User 1',
                'email' => 'collection1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'collection',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Collection User 2',
                'email' => 'collection2@example.com',
                'password' => Hash::make('password123'),
                'role' => 'collection',
                'email_verified_at' => now(),
            ],
            
            // CTC Users
            [
                'name' => 'CTC User 1',
                'email' => 'ctc1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'ctc',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'CTC User 2',
                'email' => 'ctc2@example.com',
                'password' => Hash::make('password123'),
                'role' => 'ctc',
                'email_verified_at' => now(),
            ],
            
            // Rising Star Users
            [
                'name' => 'Rising Star User 1',
                'email' => 'risingstar1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'rising-star',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rising Star User 2',
                'email' => 'risingstar2@example.com',
                'password' => Hash::make('password123'),
                'role' => 'rising-star',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Collection, CTC, and Rising Star users created successfully!');
        $this->command->info('Default password for all users: password123');
    }
}
