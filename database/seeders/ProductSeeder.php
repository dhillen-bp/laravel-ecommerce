<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 30; $i++) {
            Product::create([
                'name' => ucfirst($faker->unique()->word),
                'description' => $faker->sentence,
                'price' => $faker->numberBetween(1000, 1000000),
                'stock' => $faker->numberBetween(1, 100),
                'is_active' => $faker->randomElement([1, 0]),
            ]);
        }
    }
}
