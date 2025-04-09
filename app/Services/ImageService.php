<?php

namespace App\Services;

use Exception;
use Bepsvpt\Blurhash\Facades\BlurHash;

class ImageService
{

    public function storeImage($model, $image, $collection)
    {
        try {
            if (!isset($image)) return;

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
            // التحقق إذا كانت الصورة موجودة في الميديا الحالية وحذفها
            $existingMedia = $model->getFirstMedia($collection);

            if ($existingMedia) {
                $oldImagePath = storage_path('images/temp/' . $existingMedia->getPath()); // المسار القديم
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // حذف الملف الفعلي
                }
                // حذف الصورة القديمة
                $existingMedia->delete();
            }
            // توليد الـ blurhash
            $hash = BlurHash::encode($imagePath);

            // حفظ الصورة
            $mediaModel = $model->addMedia($imagePath)->preservingOriginal()->toMediaCollection($collection, 'custom_disk');

            // إضافة الـ blurhash كخاصية مخصصة
            $mediaModel->setCustomProperty('hash', $hash);
            $mediaModel->save();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
