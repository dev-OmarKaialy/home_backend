<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\House;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        // احصل على مستخدم موجود (أو أنشئ مستخدم لاختباره)
        $user = User::first(); // أو User::factory()->create();

        for ($i = 1; $i <= 30; $i++) {
            $status = rand(0, 1) ? 'rent' : 'sale';
            // إنشاء بيت
            $house = House::create([
                'title' => "House #$i",
                'description' => "A beautiful house number $i.",
                'price' => rand(100000, 500000),
                'user_id' => $user->id,
                'views_count' => rand(0, 1000),
                'status' => $status,
                'owner_name' => "owner name",
                'owner_phone' => "123456789",
            ]);

            // عنوان البيت
            $house->address()->create([
                'city' => 'Sample City',
                'region' => 'Region ' . rand(1, 5),
                'street' => 'Street ' . rand(10, 50),
                'building' => 'Building ' . rand(1, 20),
            ]);

            // إضافة صورة وهمية إن كنت تستخدم media library
            $house
                ->addMedia(public_path("images/vila.jpg")) // استخدام المسار المحلي
                ->preservingOriginal()
                ->toMediaCollection('houses');
        }

        DB::commit();
    }
}
