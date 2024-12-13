<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert([
            [
                'name' => 'Smartphone X100',
                'description' => 'A high-end smartphone with cutting-edge features.',
                'price' => 999.99,
                'minimum_order_quantity' => 10,
                'available_quantity' => 500,
                'manufacturer_id' => 1, // Assuming TechnoCorp
                'merge_buy_limit' => 20,
                'merge_buy_price' => 899.99,
                'merge_buy_quantity' => 5,
                'merge_buy_city' => 'Lagos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Organic Fertilizer',
                'description' => 'Eco-friendly fertilizer for sustainable farming.',
                'price' => 19.99,
                'minimum_order_quantity' => 50,
                'available_quantity' => 1000,
                'manufacturer_id' => 2, // Assuming GreenGrow
                'merge_buy_limit' => 30,
                'merge_buy_price' => 15.99,
                'merge_buy_quantity' => 10,
                'merge_buy_city' => 'Abuja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brake Pads',
                'description' => 'Durable and reliable brake pads for all vehicles.',
                'price' => 49.99,
                'minimum_order_quantity' => 20,
                'available_quantity' => 300,
                'manufacturer_id' => 3, // Assuming AutoMotivePlus
                'merge_buy_limit' => null,
                'merge_buy_price' => null,
                'merge_buy_quantity' => null,
                'merge_buy_city' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
