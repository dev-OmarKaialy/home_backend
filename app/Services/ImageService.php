<?php

namespace App\Services;

use Exception;
use Bepsvpt\Blurhash\Facades\BlurHash;

class ImageService
{

    public function storeImage($model, $images, $collection, $replace = true)
    {
        try {
            // إذا لم يتم تمرير صورة أو مصفوفة صور، لا تفعل شيئًا
            if (!isset($images)) return;

            // تأكد أن $images عبارة عن مصفوفة
            $images = is_array($images) ? $images : [$images];

            // حذف الصور القديمة إذا تم تمرير خيار الحذف
            if ($replace) {
                $model->clearMediaCollection($collection);
            }

            foreach ($images as $image) {
                // إذا كان الرابط يحتوي على عنوان التطبيق، قم بإزالته
                if (str_contains($image, config('app.url'))) {
                    $image = str_replace(config('app.url'), '', $image);
                }

                // تحقق مما إذا كان $image يحتوي على مسار مطلق
                if (str_starts_with($image, 'C:\\') || str_starts_with($image, '/')) {
                    $imagePath = $image;
                } else {
                    $imagePath = storage_path('images/temp/') . $image;
                }

                // تأكد أن الملف موجود قبل المتابعة
                if (!file_exists($imagePath)) {
                    throw new \Exception("File not found: " . $imagePath);
                }

                // توليد الـ blurhash
                $hash = BlurHash::encode($imagePath);

                // حفظ الصورة
                $mediaModel = $model->addMedia($imagePath)->preservingOriginal()->toMediaCollection($collection, 'custom_disk');

                // إضافة الـ blurhash كخاصية مخصصة
                $mediaModel->setCustomProperty('hash', $hash);
                $mediaModel->save();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
