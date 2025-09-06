<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\HouseRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\HouseResource;
use Barryvdh\DomPDF\Facade\Pdf;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = House::with('address');

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

        $houses = $query->orderBy('views_count', 'desc')->paginate(10);


        return response()->json([
            'status' => 'success',
            'data' => HouseResource::collection($houses),
            'meta' => [
                'current_page' => $houses->currentPage(),
                'last_page' => $houses->lastPage(),
                'per_page' => $houses->perPage(),
                'total' => $houses->total(),
            ]
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HouseRequest $request)
    {
        DB::beginTransaction();

        $imageService = new ImageService();
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();

        $house = House::create($validatedData);

        // إنشاء العنوان
        $house->address()->create([
            'city'     => $validatedData['city'],
            'region'   => $validatedData['region'] ?? null,
            'street'   => $validatedData['street'] ?? null,
            'building' => $validatedData['building'] ?? null,
        ]);

        // رفع عدة صور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $house->addMedia($image)->toMediaCollection('houses');
            }
            $house->refresh();
        }

        DB::commit();

        return ApiResponse::success(new HouseResource($house->load('address')), 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        // زيادة views_count عند كل زيارة
        $house->increment('views_count');
        return ApiResponse::success(new HouseResource($house->load(['address', 'owner'])), 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        //
    }


    public function trendingHouses()
    {

        $topHouses = House::where('status', '!=', 'unavailable')
            ->orderBy('views_count', 'desc')->take(5)->get();

        return ApiResponse::success(HouseResource::collection($topHouses), 201);
    }

    public function destroy(House $house)
    {
        try {
            $house->delete();
            return ApiResponse::success('House deleted successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to delete house', 500, $e->getMessage());
        }
    }

    public function sign(Request $request, $id)
    {
        $house = House::findOrFail($id);

        $buyerSignature = null;

        if ($request->hasFile('buyer_signature')) {
            $buyerSignature = 'data:image/png;base64,' . base64_encode(
                file_get_contents($request->file('buyer_signature'))
            );
        }

        $pdf = Pdf::loadView('houses.pdf', [
            'house' => $house,
            'buyerSignature' => $buyerSignature
        ]);
        $fileName = 'house-' . $house->id . '-signed.pdf';
        $filePath = public_path('pdfs/' . $fileName);

        if (!file_exists(public_path('pdfs'))) {
            mkdir(public_path('pdfs'), 0777, true);
        }

        $pdf->save($filePath);

        return response()->json([
            'status' => 'success',
            'file_url' => url('pdfs/' . $fileName)
        ]);
    }
}
