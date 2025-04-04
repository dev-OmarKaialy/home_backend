<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15', // Adjust max length as needed
            'note' => 'nullable|string|max:500', // Note is nullable
            'user_id' => 'nullable|exists:users,id', // Ensure user_id exists in users table
            'house_id' => 'nullable|exists:houses,id', // Ensure house_id exists in houses table

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'address.required' => 'The address field is required.',
            'phone.required' => 'The phone field is required.',
            'note.max' => 'The note may not be greater than 500 characters.',
            'user_id.exists' => 'The selected user does not exist.',
            'house_id.exists' => 'The selected house does not exist.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
     throw new ValidationException($validator)

        ; // 422 Unprocessable Entity
    }
}
