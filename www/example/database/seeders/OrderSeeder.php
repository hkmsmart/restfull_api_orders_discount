<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/orders.json'));
        $data = json_decode($json, true);
        foreach ($data as $item) {
            $order = Order::create([
                'customer_id' => $item['customerId'],
                'total'       => $item['total'],
            ]);

            foreach ($item['items'] as $pItem) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $pItem['productId'],
                    'quantity'   => $pItem['quantity'],
                    'unit_price' => $pItem['unitPrice'],
                    'total'      => $pItem['total'],
                ]);
            }
        }
    }
}
