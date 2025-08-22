<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HouseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.1',
            'status' => 'required|in:sale,rent,unavailable,available',
            'period' => 'nullable|integer|min:1',
            'city' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'service_date' => 'nullable|date_format:Y-m-d H:i:s',

            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|regex:/^[0-9+\-\(\)\s]{8,20}$/',
            'rooms' => 'required|numeric',
            'space' => 'required|numeric',
            'directions' => 'required|string',

            'images' => 'nullable|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
