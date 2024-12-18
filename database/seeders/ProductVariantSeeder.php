<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $products = Product::all();
        $variants = Variant::all();

        foreach ($products as $product) {
            // Setiap produk memiliki beberapa varian acak
            $assignedVariants = $variants->random(rand(2, 4));

            foreach ($assignedVariants as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_id' => $variant->id,
                    'price' => $faker->randomElement([1000, 5000, 10000, 20000, 30000, 40000, 50000, 60000, 70000, 80000, 90000, 100000]),
                    'stock' => $faker->numberBetween(1, 100),
                ]);
            }
        }
    }
}
