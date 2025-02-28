<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\ServiceResource;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Store a new service
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $service = Service::create($request->all());

        return response()->json($service, 201);
    }

    // Show all services for a specific category
    public function index($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return  ApiResponse::success(ServiceResource::collection( $category->services),200); // Return the services related to the category
    }
}
