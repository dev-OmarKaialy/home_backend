<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ServiceProviderSeeder extends Seeder
{
    public function run()
    {
        // Get all services to assign to providers
        $services = Service::all();

        // Create 10 random service providers
        User::factory(10)->create()->each(function ($user) use ($services) {
            $user->assignRole('service provider');

            // Assign a random service to the provider
            $user->update([
                'service_id' => $services->random()->id,
                'hourly_rate' => rand(20, 100), // Random hourly rate between 20-100
            ]);
        });

      
    }
}