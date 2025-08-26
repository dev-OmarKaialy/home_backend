<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HouseRequest;
use App\Models\House;
use App\Services\ImageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HouseController extends Controller
{
    public function index(Request $request)
    {
        $query = House::where('status', '!=', 'unavailable')
            ->with('address')
            ->orderBy('views_count', 'desc');

        if ($request->filled('address')) {
            $address = $request->address;
            $query->whereHas('address', function ($q) use ($address) {
                $q->where('city', 'like', "%{$address}%")
                    ->orWhere('region', 'like', "%{$address}%")
                    ->orWhere('street', 'like', "%{$address}%");
            });
        }

        if ($request->filled('rooms')) {
            $query->where('rooms', $request->rooms);
        }

        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }

        $houses = $query->paginate(10)->withQueryString();

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

    public function generatePdf($id)
    {
        $house = House::findOrFail($id);

        $pdf = Pdf::loadView('houses.pdf', compact('house'));
        $filePath = 'house-' . $house->id . '.pdf';
        $pdf->save(storage_path('app/public/' . $filePath));

        return redirect()->route('house.print', ['file' => $filePath]);
    }

    public function printPdf(Request $request)
    {
        $filePath = storage_path('app/public/' . $request->file);

        return response()->file($filePath);
    }
}
