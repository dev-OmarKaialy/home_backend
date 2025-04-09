<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'Window Cleaning', 'category_id' => 1, 'price' => 50.00, 'description' => 'Professional window cleaning', 'image' => 'Window Cleaning.jpg'],
            ['name' => 'Carpet Cleaning', 'category_id' => 1, 'price' => 80.00, 'description' => 'Deep cleaning for carpets', 'image' => 'Carpet Cleaning.jpg'],
            ['name' => 'Leak Fixing', 'category_id' => 2, 'price' => 100.00, 'description' => 'Fixing pipe leaks and blockages', 'image' => 'Leak Fixing.jpg'],
            ['name' => 'Electrical Wiring', 'category_id' => 3, 'price' => 200.00, 'description' => 'Professional home wiring services', 'image' => 'Electrical Wiring.jpg'],
            ['name' => 'Wall Painting', 'category_id' => 4, 'price' => 150.00, 'description' => 'Indoor and outdoor wall painting', 'image' => 'Wall Painting.jpg'],
            ['name' => 'Furniture Assembly', 'category_id' => 5, 'price' => 120.00, 'description' => 'Assembling wooden furniture', 'image' => 'Furniture Assembly.jpg'],
        ];

        foreach ($services as $service) {
            $newService = Service::create([
                'name' => $service['name'],
                'category_id' => $service['category_id'],
                'price' => $service['price'],
                'description' => $service['description']
            ]);

            // إضافة الصورة إلى خدمة جديدة
            $newService
                ->addMedia(public_path("images/{$service['image']}"))
                ->preservingOriginal()
                ->toMediaCollection('services');
        }
    }
}
