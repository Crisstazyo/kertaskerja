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

        // Create gov user
        \App\Models\User::create([
            'name' => 'Government User',
            'email' => 'gov@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'gov',
        ]);

        // Additional test users
        \App\Models\User::create([
            'name' => 'Gov User 2',
            'email' => 'gov2@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'gov',
        ]);

        \App\Models\User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
