<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::get();
        return ApiResponse::success($addresses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        $validatedData = $request->validated();

        $user = Auth::user();
        $address = $user->address;

        if ($address) {
            $address->update($validatedData);
        } else {
            // إذا ما عنده عنوان، ننشئ واحد جديد (اختياري)
            $address = $user->address()->create($validatedData);
        }

        return ApiResponse::success($address);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        try {
            $address->delete();
            return ApiResponse::success('Address deleted successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to delete address', 500, $e->getMessage());
        }
    }
}
