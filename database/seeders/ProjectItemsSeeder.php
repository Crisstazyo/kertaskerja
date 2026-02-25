<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('project_items')->insert([
            [
                'id' => 1,
                'unit_scope' => 'Scaling Gov',
                'indicator' => 'On Hands',
                'denom' => 'lop',
                'commitment_amount' => 100,
                'commitment_rp_million' => 12.5,
                'real_amount' => 90,
                'real_rp_amount' => 11.2,
                'fairness' => 0.95,
                'ach' => 90.0,
                'score' => 4.5,
                'created_at' => $now->subDays(10),
                'updated_at' => $now->subDays(2),
            ],
            [
                'id' => 2,
                'unit_scope' => 'Scaling Gov',
                'indicator' => 'Qualified',
                'denom' => 'lop',
                'commitment_amount' => 200,
                'commitment_rp_million' => 50.0,
                'real_amount' => 180,
                'real_rp_amount' => 45.7,
                'fairness' => 0.88,
                'ach' => 90.0,
                'score' => 4.2,
                'created_at' => $now->subDays(8),
                'updated_at' => $now->subDays(1),
            ],
            [
                'id' => 3,
                'unit_scope' => 'Scaling Gov',
                'indicator' => 'Initiated',
                'denom' => 'lop',
                'commitment_amount' => 50,
                'commitment_rp_million' => 3.2,
                'real_amount' => 50,
                'real_rp_amount' => 3.2,
                'fairness' => 1.00,
                'ach' => 100.0,
                'score' => 5.0,
                'created_at' => $now->subDays(30),
                'updated_at' => $now->subDays(5),
            ],
            [
                'id' => 4,
                'unit_scope' => 'Scaling Gov',
                'indicator' => 'Correction',
                'denom' => 'lop',
                'commitment_amount' => 120,
                'commitment_rp_million' => 7.8,
                'real_amount' => 60,
                'real_rp_amount' => 3.9,
                'fairness' => 0.65,
                'ach' => 50.0,
                'score' => 2.5,
                'created_at' => $now->subDays(3),
                'updated_at' => $now->subDays(1),
            ],
            [
                'id' => 5,
                'unit_scope' => 'Scope E',
                'indicator' => 'Indicator 5',
                'denom' => 'lop',
                'commitment_amount' => 10,
                'commitment_rp_million' => 1.1,
                'real_amount' => 8,
                'real_rp_amount' => 0.9,
                'fairness' => 0.82,
                'ach' => 80.0,
                'score' => 3.8,
                'created_at' => $now->subDays(12),
                'updated_at' => $now->subDays(2),
            ],
        ]);
    }
}
