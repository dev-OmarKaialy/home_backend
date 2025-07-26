<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HouseRequest;
use App\Models\House;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::where('status', '!=', 'unavailable')
            ->with('address')
            ->orderBy('views_count', 'desc')
            ->paginate(10);

        // Paginated response for infinite scroll support in frontend apps
        return view('houses.index', compact('houses'));
    }

    public function create()
    {
        return view('houses.create');
    }

    public function store(HouseRequest $request)
    {
        // Use DB transaction to ensure atomicity
        DB::beginTransaction();

        $imageService = new ImageService();
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::user()->id ?? 1;
        // Create the house
        $house = House::create($validatedData);

        // Create the related address
        $house->address()->create([
            'city'     => $validatedData['city'],
            'region'   => $validatedData['region'] ?? null,
            'street'   => $validatedData['street'] ?? null,
            'building' => $validatedData['building'] ?? null,
        ]);

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $imageService->storeImage($house, $request->file('image'), 'houses');
            $house->refresh(); // Refresh model to include media
        }

        DB::commit();

        return redirect()->route('houses.show', $house->id)->with('success', 'House created successfully!');
    }

    public function show($id)
    {
        $house = House::findOrFail($id);
        return view('houses.show', compact('house'));
    }

    public function edit($id)
    {
        $house = House::findOrFail($id);
        return view('houses.edit', compact('house'));
    }

    public function update(HouseRequest $request, House $house)
    {
        $validated = $request->validated();

        $house->fill([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
            'status'      => $validated['status'],
            'user_id'     => Auth::id() ?? 1,
        ]);

        $house->save();

        $house->address()->updateOrCreate([], [
            'city'     => $validated['city'],
            'region'   => $validated['region'] ?? null,
            'street'   => $validated['street'] ?? null,
            'building' => $validated['building'] ?? null,
        ]);

        if ($request->hasFile('image')) {
            $house->clearMediaCollection('houses');
            $house->addMediaFromRequest('image')->toMediaCollection('houses');
        }

        return redirect()->route('houses.show', $house)->with('success', 'house uploaded successfully!');
    }

    public function delete($id)
    {
        $house = House::findOrFail($id);

        $house->clearMediaCollection('houses');

        $house->address()->delete();

        $house->delete();

        return redirect()->back()->with('house deleted successfully!');
    }
}
