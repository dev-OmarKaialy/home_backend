<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'Window Cleaning', 'category_id' => 1, 'price' => 50.00, 'description' => 'Professional window cleaning'],
            ['name' => 'Carpet Cleaning', 'category_id' => 1, 'price' => 80.00, 'description' => 'Deep cleaning for carpets'],
            ['name' => 'Leak Fixing', 'category_id' => 2, 'price' => 100.00, 'description' => 'Fixing pipe leaks and blockages'],
            ['name' => 'Electrical Wiring', 'category_id' => 3, 'price' => 200.00, 'description' => 'Professional home wiring services'],
            ['name' => 'Wall Painting', 'category_id' => 4, 'price' => 150.00, 'description' => 'Indoor and outdoor wall painting'],
            ['name' => 'Furniture Assembly', 'category_id' => 5, 'price' => 120.00, 'description' => 'Assembling wooden furniture'],
        ];

        Service::insert($services);
    }
}
