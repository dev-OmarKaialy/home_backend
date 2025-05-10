<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\JoinRequest;
use App\Http\Resources\JoinRequestResource;
use App\Models\JoinRequest as ModelsJoinRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class JoinRequestController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('admin'), except: ['store']),
        ];
    }

    public function index(){
        $jounRequests=ModelsJoinRequest::all();
        return ApiResponse::success(JoinRequestResource::collection($jounRequests),200);
    }
    public function store(JoinRequest $request)
    {
        try{
        $validatedData = $request->validated();
        if ($request->hasFile('cv')) {
            $validatedData['cv'] = $request->file('cv')->store('applications/cvs', 'public');
        }
        $joinRequest=ModelsJoinRequest::create($validatedData);
        return ApiResponse::success(JoinRequestResource::make($joinRequest),200);
        } catch (\Exception $e) {
            return ApiResponse::error(419, $e->getMessage(), $e->getMessage());
        }
    }
}
