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
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Create government user
        \App\Models\User::updateOrCreate(
            ['email' => 'government@gmail.com'],
            [
                'name' => 'Government User',
                'password' => bcrypt('password'),
                'role' => 'government',
            ]
        );

        // Create private user
        \App\Models\User::updateOrCreate(
            ['email' => 'private@gmail.com'],
            [
                'name' => 'Private User',
                'password' => bcrypt('password'),
                'role' => 'private',
            ]
        );

        // Create SOE user
        \App\Models\User::updateOrCreate(
            ['email' => 'soe@gmail.com'],
            [
                'name' => 'SOE User',
                'password' => bcrypt('password'),
                'role' => 'soe',
            ]
        );

        // Create SME user
        \App\Models\User::updateOrCreate(
            ['email' => 'sme@gmail.com'],
            [
                'name' => 'SME User',
                'password' => bcrypt('password'),
                'role' => 'sme',
            ]
        );

        // Create CTC user
        \App\Models\User::updateOrCreate(
            ['email' => 'ctc@gmail.com'],
            [
                'name' => 'CTC User',
                'password' => bcrypt('password'),
                'role' => 'ctc',
            ]
        );

        // Create Collection user
        \App\Models\User::updateOrCreate(
            ['email' => 'collection@gmail.com'],
            [
                'name' => 'Collection User',
                'password' => bcrypt('password'),
                'role' => 'collection',
            ]
        );

        // Create RisingStar user
        \App\Models\User::updateOrCreate(
            ['email' => 'risingstar@gmail.com'],
            [
                'name' => 'RisingStar User',
                'password' => bcrypt('password'),
                'role' => 'rising-star',
            ]
        );
    }
}
