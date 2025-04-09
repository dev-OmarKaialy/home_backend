<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => request()->routeIs('customer-auth.update') ? 'nullable|string|max:255' : 'required|string|max:255',
            'username' => request()->routeIs('customer-auth.update') ? 'nullable|string|max:255|unique:users,username,' . Auth::id() :'required|string|max:255|unique:users',
            'email' => request()->routeIs('customer-auth.update') ?  'nullable|string|email|max:255|unique:users,email,' . Auth::id() : 'required|string|email|max:255|unique:users',
            'phone' => request()->routeIs('customer-auth.update') ? 'nullable|string|max:20|unique:users,phone,' . Auth::id() : 'required|string|max:20|unique:users',
            'password' => request()->routeIs('customer-auth.update') ?'nullable' : 'required|string|min:8',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
