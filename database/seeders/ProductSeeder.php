<?php

namespace Database\Seeders;

use App\Enums\CategoryEnum;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = CategoryEnum::values();

        for ($i = 1; $i <= 50; $i++) {
            Product::create([
                'product_code' => 'P' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'name' => 'Product ' . $i,
                'category' => $categories[array_rand($categories)],
                'price' => mt_rand(1000, 100000) / 100,
            ]);
        }
    }
}
