<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $users = User::all();

        foreach ($products as $product) {
            foreach ($users->take(rand(1, 5)) as $user) {
                Order::create([
                    'product_id' => $product->id,
                    'buyer_id' => $user->id,
                    'quantity' => rand(1, 10),
                    'status' => 'pending',
                    'order_type' => rand(0, 1) ? 'individual' : 'merge',
                    'merge_buy_quantity_per_buyer' => null, // Update if needed for merge buys
                ]);
            }
        }
    }
}
