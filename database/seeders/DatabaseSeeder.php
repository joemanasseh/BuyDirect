<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed manufacturers, products, and orders
        $this->call([
            ManufacturersSeeder::class,
            ProductsSeeder::class,
            OrdersSeeder::class,
            MergeBuySeeder::class,
        ]);
    }
}
