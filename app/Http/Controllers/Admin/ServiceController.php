<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(5);

        return view('services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $service = Service::create($data);

        if ($request->hasFile('image')) {
            $service->addMediaFromRequest('image')->toMediaCollection('service');
        }

        return redirect()->route('services.Show', $service->id)->with('success', 'Service created');
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
        return view('services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
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
