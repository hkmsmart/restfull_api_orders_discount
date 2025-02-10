<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        Discount::create([
            'name' => '10% Discount Over 1000',
            'type' => 'percentage',
            'value' => 10,
            'min_total' => 1000
        ]);

        Discount::create([
            'name' => 'Buy 5 Get 1 Free - Category 2',
            'type' => 'free_item',
            'category_id' => 2,
            'min_quantity' => 6
        ]);

        Discount::create([
            'name' => '20% Off Cheapest in Category 1',
            'type' => 'percentage',
            'value' => 20,
            'category_id' => 1,
            'min_quantity' => 2
        ]);
    }
}
