<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/customers.json'));
        $data = json_decode($json, true);
        foreach ($data as $item) {
            Customer::create([
                'name'        => ($item['name'] ?? null),
                'revenue'     => $item['revenue'],
                'since'       => $item['since'],
            ]);
        }
    }
}
