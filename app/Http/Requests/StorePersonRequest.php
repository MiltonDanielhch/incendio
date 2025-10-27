<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // La autorización ya se maneja en el controlador con custom_authorize()
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ci'               => 'nullable|string|max:20|unique:people,ci',
            'first_name'       => 'required|string|max:255',
            'middle_name'      => 'nullable|string|max:255',
            'paternal_surname' => 'nullable|string|max:255',
            'maternal_surname' => 'nullable|string|max:255',
            'birth_date'       => 'nullable|date',
            'gender'           => 'nullable|string|max:50',
            'phone'            => 'nullable|string|max:50',
            'address'          => 'nullable|string',
            'email'            => 'nullable|email|max:255|unique:people,email',
            'image'            => 'nullable|image|mimes:jpeg,jpg,png,bmp,webp|max:2048',
        ];
    }
}
