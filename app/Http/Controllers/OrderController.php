<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Order;
use App\Helpers\ApiResponse;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function requestHouse(Request $request, $houseId)
    {
        // التحقق من أن المنزل موجود ومتاح
        $house = House::where('id', $houseId)
            ->whereIn('status', ['sale', 'rent'])
            ->first();

        if (!$house) {
            return response()->json(['message' => 'المنزل غير متاح أو غير موجود.'], 404);
        }

        // إنشاء الطلب
        $order = Order::create([
            'user_id' => Auth::id(), // المستخدم الحالي
            'house_id' => $house->id,
            'notes' => $request->input('notes'),
            'service_provider_id' => null, // لأنه طلب منزل، ليس خدمة
        ]);
        return ApiResponse::success(OrderResource::make($order->load(['house', 'house.owner'])), 201);
    }

    public function showUserOrders()
    {
        // جلب طلبات العميل مع تحميل معلومات البيت
        $orders = Order::with('house', 'house.owner')->where('user_id', Auth::id())->get();

        return ApiResponse::success(OrderResource::collection($orders), 200);
    }

    public function showHouseOwnerOrders()
    {
        if (Auth::user()->hasRole('admin')) {
            // إذا كان المستخدم مشرفًا، جلب جميع الطلبات
            $orders = Order::with('user', 'house', 'house.owner')->get();
        } else {
            // إذا لم يكن المستخدم مشرفًا، جلب طلبات صاحب المنزل
            $orders = Order::with('user', 'house', 'house.owner')->whereHas('house', function ($query) {
                $query->where('user_id', Auth::id());
            })->get();
        }

        return ApiResponse::success(OrderResource::collection($orders), 200);
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
