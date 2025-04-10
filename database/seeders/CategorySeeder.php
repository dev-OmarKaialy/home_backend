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

            // تحديد المسار الصحيح للصور في public/images
            $imagePath = public_path("images/{$cat['image']}");

            // تحقق من وجود الصورة قبل إضافتها
            if (file_exists($imagePath)) {
                $category
                    ->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('categories', 'custom_disk');
            } 
        }
    }
}
