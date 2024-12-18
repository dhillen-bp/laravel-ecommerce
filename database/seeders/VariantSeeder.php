<?php

namespace Database\Seeders;

use App\Models\Variant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $variants = ['Small', 'Medium', 'Large', 'Red', 'Blue', 'Green'];

        foreach ($variants as $variant) {
            Variant::create([
                'name' => $variant,
                'image' => $faker->imageUrl(200, 200, 'variant', true), // Gambar dummy
            ]);
        }
    }
}
