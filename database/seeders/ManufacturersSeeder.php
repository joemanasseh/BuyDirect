<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManufacturersSeeder extends Seeder
{
    public function run()
    {
        DB::table('manufacturers')->insert([
            // Manufacturer 1 - TechnoCorp
            ['name' => 'TechnoCorp', 'email' => 'contact@technocorp.com', 'description' => 'A leading manufacturer of electronics and gadgets.', 'phone' => null, 'address' => null, 'Rating' => 5, 'Review' => 'Excellent products', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Manufacturer 2 - GreenGrow
            ['name' => 'GreenGrow', 'email' => 'info@greengrow.com', 'description' => 'Suppliers of organic and eco-friendly agricultural products.', 'phone' => null, 'address' => null, 'Rating' => 4, 'Review' => 'Good quality organic products', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Manufacturer 3 - AutoMotivePlus
            ['name' => 'AutoMotivePlus', 'email' => 'support@automotiveplus.com', 'description' => 'Pioneers in automotive parts and solutions.', 'phone' => null, 'address' => null, 'Rating' => 4, 'Review' => 'Reliable automotive parts', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Manufacturer 4 - SoundMaster
            ['name' => 'SoundMaster', 'email' => 'sales@soundmaster.com', 'description' => 'Experts in audio and sound equipment.', 'phone' => null, 'address' => null, 'Rating' => 4, 'Review' => 'Clear and crisp audio products', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Manufacturer 5 - TechGiant
            ['name' => 'TechGiant', 'email' => 'info@techgiant.com', 'description' => 'Leading the way in consumer electronics and technology.', 'phone' => null, 'address' => null, 'Rating' => 5, 'Review' => 'Innovative and cutting-edge technology', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Manufacturer 6 - WatchCo
            ['name' => 'WatchCo', 'email' => 'contact@watchco.com', 'description' => 'Premium watches and timepieces for the discerning customer.', 'phone' => null, 'address' => null, 'Rating' => 5, 'Review' => 'Elegant designs and precision craftsmanship', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Manufacturer 7 - EliteKitchens
            ['name' => 'EliteKitchens', 'email' => 'support@elitekitchens.com', 'description' => 'Designing luxury kitchens for the elite and professionals.', 'phone' => null, 'address' => null, 'Rating' => 4, 'Review' => 'Top-notch kitchen designs', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Manufacturer 8 - CoolBreeze
            ['name' => 'CoolBreeze', 'email' => 'sales@coolbreeze.com', 'description' => 'Innovators in air conditioning and cooling solutions.', 'phone' => null, 'address' => null, 'Rating' => 4, 'Review' => 'Reliable cooling systems', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Manufacturer 9 - GameVision
            ['name' => 'GameVision', 'email' => 'info@gamevision.com', 'description' => 'Designing and producing cutting-edge gaming technology.', 'phone' => null, 'address' => null, 'Rating' => 5, 'Review' => 'The best gaming experience', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            // Manufacturer 10 - SmartHomeElectronics
            ['name' => 'SmartHomeElectronics', 'email' => 'support@smarthomeelectronics.com', 'description' => 'Creating innovative smart home solutions for modern living.', 'phone' => null, 'address' => null, 'Rating' => 4, 'Review' => 'Smart solutions for smarter living', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
