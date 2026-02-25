<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create government user
        \App\Models\User::create([
            'name' => 'Government User',
            'email' => 'government@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'government',
        ]);

        // Create private user
        \App\Models\User::create([
            'name' => 'Private User',
            'email' => 'private@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'private',
        ]);

        // Create SOE user
        \App\Models\User::create([
            'name' => 'SOE User',
            'email' => 'soe@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'soe',
        ]);

        // Create SME user
        \App\Models\User::create([
            'name' => 'SME User',
            'email' => 'sme@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'sme',
        ]);
    }
}
