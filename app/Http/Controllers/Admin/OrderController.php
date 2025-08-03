<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'serviceProviders', 'house'])->latest()->paginate(5);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        $houses = House::all();
        $serviceProviders = User::role('service_provider')->get();

        return view('orders.create', compact('users', 'houses', 'serviceProviders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_provider_id' => 'nullable|exists:users,id',
            'house_id' => 'nullable|exists:houses,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,confirmed,completed',
            'payment_status' => 'required|in:unpaid,partially_paid,paid',
            'service_date' => 'nullable|date',
        ]);

        Order::create($data);

        return redirect()->route('orders.index')->with('success', 'Order created successfully');
    }

    public function edit(Order $order)
    {
        $users = User::all();
        $houses = House::all();
        $serviceProviders = User::role('service_provider')->get();

        return view('orders.edit', compact('order', 'users', 'houses', 'serviceProviders'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_provider_id' => 'nullable|exists:users,id',
            'house_id' => 'nullable|exists:houses,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,confirmed,completed',
            'payment_status' => 'required|in:unpaid,partially_paid,paid',
            'service_date' => 'nullable|date',
        ]);

        $order->update($data);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'serviceProviders', 'house']);
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected', 'confirmed', 'completed'])],
        ]);

        $order->status = $request->status;

        if ($request->status === 'completed') {
            $order->payment_status = 'paid';
        }

        $order->save();

        return redirect()->back()->with('success', 'Order Status Updated');
    }
}
