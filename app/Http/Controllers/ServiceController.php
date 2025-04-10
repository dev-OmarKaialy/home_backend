<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Http\Requests\ServiceProviderRequest;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Resources\ServiceProviderResource;
use Illuminate\Routing\Controllers\HasMiddleware;

class ServiceController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('admin')),
        ];
    }

    // Store a new service
    public function store(ServiceRequest $service)
    {
        $imageService = new ImageService();
        // Validate incoming request data
        $validatedData = $service->validated();

        // create service in database
        $newService = Service::create($validatedData);

        // store image if exist
        if ($service->image) {
            try {
                $imageService->storeImage($newService, $service->image, 'services');
                // Refresh the service model to get updated data from DB (especially image path)
                $newService->refresh();
            } catch (Exception $e) {
                return ApiResponse::error('Image upload failed: ' . $e->getMessage(), 500);
            }
        }

        return ApiResponse::success(ServiceResource::make($newService), 201);
    }

    public function storeDerviceProvider(ServiceProviderRequest $service_provider)
    {
        // dd($request);
        try {
            DB::beginTransaction(); // لتفادي إنشاء بيانات جزئية إذا حدث خطأ

            $validatedData = $service_provider->validated();
            $imageService = new ImageService();
            // 1. إنشاء المستخدم
            $user = new User();
            $user->name = $validatedData['name'];
            $user->username = $validatedData['username'];
            $user->email = $validatedData['email'];
            $user->phone = $validatedData['phone'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            $user->assignRole('service provider');
            if ($service_provider->hasFile('image')) {
                $imageService->storeImage($user, $service_provider->file('image'), 'service providers');
                // Refresh the user model to get updated data from DB (especially image path)
                $user->refresh();
            }
            // 2. العنوان
            $user->address()->create([
                'city' => $validatedData['city'],
                'region' => $validatedData['region'] ?? null,
                'street' => $validatedData['street'] ?? null,
                'building' => $validatedData['building'] ?? null,
            ]);

            // 3. سجل موظف الخدمة
            $serviceProvider = new \App\Models\ServiceProvider();
            $serviceProvider->user_id = $user->id;
            $serviceProvider->service_id = $validatedData['service_id'];
            $serviceProvider->hourly_rate = $validatedData['hourly_rate'];
            $serviceProvider->save();

            DB::commit(); // حفظ البيانات

            return ApiResponse::success(new ServiceProviderResource($serviceProvider), 201);
        } catch (\Throwable $e) {
            DB::rollBack(); // إلغاء أي عملية حفظ حصلت

            return ApiResponse::error( $e->getMessage(), 500);
        }
    }
}
