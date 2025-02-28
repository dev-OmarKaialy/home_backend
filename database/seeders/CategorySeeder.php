<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Cleaning'],
            ['name' => 'Plumbing'],
            ['name' => 'Electrical'],
            ['name' => 'Painting'],
            ['name' => 'Carpentry'],
        ];

        Category::insert($categories);
    }
}
