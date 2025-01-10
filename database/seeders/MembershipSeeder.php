<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Membership;


class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Membership::insert([
            [
                'name' => 'Paket Bulanan',
                'duration_days' => 30,
                'daily_limit' => 10,
                'price' => 99000,
                'is_popular' => false,
            ],
            [
                'name' => 'Paket 6 Bulan',
                'duration_days' => 180,
                'daily_limit' => 30,
                'price' => 499000,
                'is_popular' => true,
            ],
            [
                'name' => 'Paket Tahunan',
                'duration_days' => 365,
                'daily_limit' => 50,
                'price' => 899000,
                'is_popular' => false,
            ],
        ]);
    }
}
