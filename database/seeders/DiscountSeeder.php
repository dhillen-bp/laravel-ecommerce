<?php

namespace Database\Seeders;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::create([
            'code' => 'NEW2025',
            'name' => 'New Year Sale',
            'description' => 'Celebrate the New Year with amazing discounts.',
            'amount' => null,
            'percentage' => 50,
            'type' => 'percentage',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(10),
            'is_active' => true,
            'claim_limit' => 50,
            'claimed' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
