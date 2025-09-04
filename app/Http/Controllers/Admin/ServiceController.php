<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['category', 'serviceProviders']);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('hourly_rate')) {
            $query->whereHas('serviceProviders', function ($q) use ($request) {
                $q->where('hourly_rate', '<=', $request->hourly_rate);
            });
        }

        $services = $query->latest()->paginate(10);

        $categories = Category::all();

        return view('services.index', compact('services', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $providers = User::all();
        return view('services.create', compact(['categories', 'providers']));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'provider_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $service = Service::create($data);

        if ($request->hasFile('image')) {
            $service->addMediaFromRequest('image')->toMediaCollection('services');
        }

        return redirect()->route('services.show', $service->id)->with('success', 'Service created');
    }


    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = Category::all();
        $providers = User::all();
        return view('services.edit', compact(['service', 'categories', 'providers']));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'provider_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $service->update($data);

        if ($request->hasFile('image')) {
            $service->clearMediaCollection('services');
            $service->addMediaFromRequest('image')->toMediaCollection('services');
        }

        return redirect()->route('services.index')->with('success', 'Service updated');
    }
    public function delete($id)
    {
        $service = Service::findOrFail($id);

        $service->clearMediaCollection('services');
        $service->delete();

        return redirect()->back()->with('success', 'Service deleted');
    }
}
