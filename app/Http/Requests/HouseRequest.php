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
            'status' => 'required|in:sale,rent', // Example: status must be 'sale' or 'rent'
            'period' => 'required|integer|min:1',
            'city' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'building' => 'required|string|max:255',
            'service_date' => 'required|date_format:Y-m-d H:i:s'
        ];
    }
}
