<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Order;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Models\User;

class OrderController extends Controller
{
    public function requestHouse(Request $request, $houseId)
    {
        DB::beginTransaction();
        // التحقق من أن المنزل موجود ومتاح
        $house = House::where('id', $houseId)
            ->whereIn('status', ['sale', 'rent'])
            ->first();

        if (!$house) {
            return response()->json(['message' => 'المنزل غير متاح أو غير موجود.'], 404);
        }

        // إنشاء الطلب
        $order = Order::create([
            'user_id' => Auth::id(),
            'house_id' => $house->id,
            'notes' => $request->input('notes'),
        ]);
        DB::commit();

        return ApiResponse::success(OrderResource::make($order->load(['house', 'house.owner'])), 201);
    }

    public function showUserOrders()
    {
        if (Auth::user()->hasRole('admin')) {
            // إذا كان المستخدم مشرفًا، جلب جميع الطلبات
            $orders = Order::with('house', 'house.owner','house.address','serviceProviders','address')->paginate(10);
        } else {
        // جلب طلبات العميل مع تحميل معلومات البيت
        $orders = Order::with('house', 'house.owner','house.address','serviceProviders','address')->where('user_id', Auth::id())->paginate(10);
        }
        // Paginated response for infinite scroll support in frontend apps
        return response()->json([
            'status' => 'success',
            'data' => OrderResource::collection($orders),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ]
        ]);
    }

    public function showHouseOwnerOrders()
    {

            // إذا لم يكن المستخدم مشرفًا، جلب طلبات صاحب المنزل
            $orders = Order::with('user', 'house', 'house.owner')->whereHas('house', function ($query) {
                $query->where('user_id', Auth::id());
            })->paginate(10);


        // Paginated response for infinite scroll support in frontend apps
        return response()->json([
            'status' => 'success',
            'data' => OrderResource::collection($orders),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ]
        ]);
    }

    public function showServiceProviderOrders()
    {
        // إذا لم يكن المستخدم هو موظف خدمة، جلب طلبات موظف الخدمة
        $orders = Order::with('user', 'address')
            ->whereHas('serviceProviders', function ($query) {
                $query->where('service_provider_id', Auth::id());
            })
            ->paginate(10);

        // Paginated response for infinite scroll support in frontend apps
        return response()->json([
            'status' => 'success',
            'data' => OrderResource::collection($orders),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ]
        ]);
    }

    public function storeServiceOrder(Request $request)
    {
        $orders = [];
        DB::beginTransaction();

        foreach ($request->service_requests as $detail) {
            // إنشاء الطلب
            $order = Order::create([
                'user_id' => Auth::id(),
                'notes' => $detail['notes'] ?? null,
                'service_provider_id' => $detail['service_provider_id'],
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            // إنشاء العنوان المرتبط بالطلب
            $order->address()->create([
                'city' => $detail['address']['city'],
                'region' => $detail['address']['region'],
                'street' => $detail['address']['street'],
                'building' => $detail['address']['building'],
            ]);
            $orders[] = $order;
            // احصل على الخدمة المرتبطة بموظف الخدمة
    $serviceProvider = User::findOrFail($detail['service_provider_id']);
    $service = $serviceProvider->service;

    // زوّد العداد
    $service->increment('orders_count');
        }

        DB::commit();

        return ApiResponse::success(OrderResource::collection($orders), 201);

    }


    public function updateOrderStatus($orderId, $action)
    {
        // جلب الطلب مع علاقته بالمنزل
        $order = Order::with('house')->findOrFail($orderId);

        // التحقق من أن الطلب مرتبط بمنزل
        if (!$order->house) {
            return response()->json(['message' => 'الطلب لا يحتوي على منزل مرتبط.'], 400);
        }

        // التأكد أن المستخدم هو صاحب المنزل
        if ($order->house->user_id !== Auth::id()) {
            return response()->json(['message' => 'أنت لست صاحب هذا المنزل.'], 403);
        }

        // تغيير الحالة بناءً على الإجراء
        switch ($action) {
            case 'approve':
                $order->status = 'approved';
                $message = 'تمت الموافقة على الطلب بنجاح.';
                break;

            case 'reject':
                $order->status = 'rejected';
                $message = 'تم رفض الطلب بنجاح.';
                break;

            case 'confirmed':
                $order->status = 'confirmed';
                $order->payment_status = 'partially_paid';
                $message = 'تم تأكيد الطلب بنجاح.';
                break;

            case 'completed':
                $order->status = 'completed';
                $order->payment_status = 'paid';
                $message = 'تم إكتمال الطلب بنجاح.';
                break;

            default:
                return response()->json(['message' => 'إجراء غير صالح.'], 422);
        }

        $order->save();

        return ApiResponse::success(['message' => $message], 200);
    }
}
