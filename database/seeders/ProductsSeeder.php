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
            // Bulk Buy Products
            [
                'name' => 'Smartphone X100',
                'description' => 'A high-end smartphone with cutting-edge features.',
                'price' => 999.99,
                'product_type' => 'bulk',  // Bulk buy type
                'minimum_order_quantity' => 10,
                'available_quantity' => 500,
                'manufacturer_id' => 1, // Assuming TechnoCorp
                'merge_buy_limit' => 0, // Default for bulk
                'merge_buy_price' => 0, // Default for bulk
                'merge_buy_quantity' => 0, // Default for bulk
                'merge_buy_city' => '', // Default for bulk
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wireless Earbuds Pro',
                'description' => 'Noise-cancelling wireless earbuds with premium sound quality.',
                'price' => 199.99,
                'product_type' => 'bulk',  // Bulk buy type
                'minimum_order_quantity' => 15,
                'available_quantity' => 800,
                'manufacturer_id' => 2, // Assuming SoundMaster
                'merge_buy_limit' => 0, // Default for bulk
                'merge_buy_price' => 0, // Default for bulk
                'merge_buy_quantity' => 0, // Default for bulk
                'merge_buy_city' => '', // Default for bulk
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Merge Buy Products
            [
                'name' => 'Organic Fertilizer',
                'description' => 'Eco-friendly fertilizer for sustainable farming.',
                'price' => 19.99,
                'product_type' => 'merge',  // Merge buy type
                'minimum_order_quantity' => 50,
                'available_quantity' => 1000,
                'manufacturer_id' => 5, // Assuming GreenGrow
                'merge_buy_limit' => 20,
                'merge_buy_price' => 18.99,
                'merge_buy_quantity' => 50,
                'merge_buy_city' => 'Abuja',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brake Pads',
                'description' => 'Durable and reliable brake pads for all vehicles.',
                'price' => 49.99,
                'product_type' => 'merge',  // Merge buy type
                'minimum_order_quantity' => 20,
                'available_quantity' => 300,
                'manufacturer_id' => 6, // Assuming AutoMotivePlus
                'merge_buy_limit' => 15,
                'merge_buy_price' => 45.99,
                'merge_buy_quantity' => 30,
                'merge_buy_city' => 'Lagos',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Luxury Kitchen Set',
                'description' => 'A premium kitchen set designed for high-end chefs.',
                'price' => 1999.99,
                'product_type' => 'merge',  // Merge buy type
                'minimum_order_quantity' => 5,
                'available_quantity' => 100,
                'manufacturer_id' => 7, // Assuming EliteKitchens
                'merge_buy_limit' => 5,
                'merge_buy_price' => 1799.99,
                'merge_buy_quantity' => 20,
                'merge_buy_city' => 'Lagos',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Air Conditioner Model X',
                'description' => 'Energy-efficient air conditioner for home and office.',
                'price' => 599.99,
                'product_type' => 'merge',  // Merge buy type
                'minimum_order_quantity' => 10,
                'available_quantity' => 150,
                'manufacturer_id' => 8, // Assuming CoolBreeze
                'merge_buy_limit' => 10,
                'merge_buy_price' => 550.00,
                'merge_buy_quantity' => 30,
                'merge_buy_city' => 'Abuja',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
