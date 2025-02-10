<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/products.json'));
        $data = json_decode($json, true);
        foreach ($data as $item) {
            Product::create([
                'name'        => ($item['name'] ?? null),
                'category'    => $item['category'],
                'price'       => $item['price'],
                'stock'       => $item['stock'],
                'description' => ($item['description'] ?? null),
            ]);
        }
    }
}
