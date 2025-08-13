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
        DB::beginTransaction();

        $imageService = new ImageService();
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id() ?? 1;

        $house = House::create($validatedData);

        $house->address()->create([
            'city'     => $validatedData['city'],
            'region'   => $validatedData['region'] ?? null,
            'street'   => $validatedData['street'] ?? null,
            'building' => $validatedData['building'] ?? null,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $house->addMedia($image)->toMediaCollection('houses');
            }
            $house->refresh();
        }

        DB::commit();

        return redirect()
            ->route('houses.show', $house->id)
            ->with('success', 'House created successfully!');
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
        $validated['user_id'] = Auth::id() ?? 1;

        $house->update($validated);

        $house->address()->updateOrCreate([], [
            'city'     => $validated['city'],
            'region'   => $validated['region'] ?? null,
            'street'   => $validated['street'] ?? null,
            'building' => $validated['building'] ?? null,
        ]);

        if ($request->hasFile('images')) {
            $house->clearMediaCollection('houses');
            foreach ($request->file('images') as $image) {
                $house->addMedia($image)->toMediaCollection('houses');
            }
        }

        return redirect()
            ->route('houses.show', $house)
            ->with('success', 'House updated successfully!');
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
