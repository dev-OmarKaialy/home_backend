<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Http\Resources\CategoryResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('admin'), except: ['index','show']),
        ];
    }
    // Store a new category
    public function store(Request $request)
    {
        $imageService = new ImageService();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // create category in database
        $category = Category::create($request->all());

        // store image if exist
        if ($request->image) {
            try {
                $imageService->storeImage($category, $request->image, 'categories');
                // Refresh the category model to get updated data from DB (especially image path)
                $category->refresh();
            } catch (Exception $e) {
                return ApiResponse::error('Image upload failed: ' . $e->getMessage(), 500);
            }
        }

        return ApiResponse::success(CategoryResource::make($category) , 200);
    }

    // Show all categories
    public function index()
    {
        $categories = Category::with(['media'])->get();

        return ApiResponse::success(
            CategoryResource::collection($categories),
            200
        );
    }

    // Show all services for a specific category
    public function show(Category $category)
    {
        $category->load(['services', 'media']);
        if (!$category) {
            return ApiResponse::error('Category not found', 404);
        }

        return ApiResponse::success(
            new CategoryResource($category),
            200
        );
    }
}
