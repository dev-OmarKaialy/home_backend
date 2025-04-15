<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // User::factory(10)->create();

        $this->call([
            CategorySeeder::class,
            ServiceSeeder::class,
            RoleSeeder::class,


        ]);
        User::factory()->create([
            'name' => 'Omar Kaialy',
            'username' => 'omarlord1221',
            'email' => 'omar12kaialy@gmail.com',
            'phone' => '+963932728290',
            'password' => '12345678',
        ])->assignRole('admin');
        $this->call(HouseSeeder::class);
    }
}
