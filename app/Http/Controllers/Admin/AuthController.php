<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'You are not authorized.');
            }
        }

        return redirect()->route('admin.login')->with('error', 'Invalid credentials');
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('admin.login');
    }
}
