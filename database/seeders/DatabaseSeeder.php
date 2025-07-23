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

        $this->call([  RoleSeeder::class,

            CategorySeeder::class,
            ServiceSeeder::class,
          

        ]);
        User::factory()->create([
            'name' => 'Admin Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '+9639876543210',
            'password' => '12345678',
        ])->assignRole('admin');
        $this->call(HouseSeeder::class);
    }
}
