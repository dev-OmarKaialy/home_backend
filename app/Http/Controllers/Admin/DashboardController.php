<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\JoinRequest;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houses = House::count();
        $orders = Order::count();
        $services = Service::count();
        $join = JoinRequest::count();


        return view('dashboard', compact('houses', 'orders', 'services', 'join'));
    }
}
