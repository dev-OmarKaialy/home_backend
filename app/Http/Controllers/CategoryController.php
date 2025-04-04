<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    // Store a new category
    public function store(Request $request)
    {
     $imageService= new ImageService();
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($request->all());
        if($request->image)
        $imageService->storeImage($category,$request->image);
        return response()->json($category, 201);
    }

    // Show all categories
    public function index()
    {
        return ApiResponse::success (CategoryResource::collection( Category::all()->load(['services','media'])),200);
    }
}
