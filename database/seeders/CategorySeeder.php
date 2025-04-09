<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Cleaning',   'image' => 'cleaning.jpg'],
            ['name' => 'Plumbing',   'image' => 'plumbing.jpg'],
            ['name' => 'Electrical', 'image' => 'electrical.jpg'],
            ['name' => 'Painting',   'image' => 'painting.jpg'],
            ['name' => 'Carpentry',  'image' => 'carpentry.jpg'],
        ];

        foreach ($categories as $cat) {
            $category = Category::create(['name' => $cat['name']]);

            // أضف الصورة من ملف محلي
            $category
            ->addMedia(public_path("images/{$cat['image']}"))
            ->preservingOriginal()
                ->toMediaCollection('categories');
        }
    }
}
