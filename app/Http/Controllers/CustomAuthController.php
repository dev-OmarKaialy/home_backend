<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomAuthController extends Controller
{
    public function validate(Request $request){
        return ApiResponse::success(Auth::user());
    }


    public function register(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20|unique:users',
                'password' => 'required|string|min:8',
            ]);
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();
        $token=    Auth::attempt(['email'=>$user->email, 'password'=>$user->password]);
            $user = Auth::user();
            $user->token =$token;

            $user->save();
            return ApiResponse::success(UserResource::make($user), 200);
        } catch (\Exception $e) {
            return ApiResponse::error(419, $e->getMessage(), $e->getMessage());
        }


    }

    public function login(Request $request)
    {
        if (!$request->email) {
            $authed = Auth::attempt(['username' => $request->username, 'password' => $request->password]);
        } else {
            $authed = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        }
          if ($authed) {
              $user = Auth::user();
              $user->token =$authed;

              $user->save();

              return ApiResponse::success(UserResource::make ($user), 200);
        } else {
            return ApiResponse::error(419);
        }
    }
}
