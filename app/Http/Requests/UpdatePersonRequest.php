<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePersonRequest extends FormRequest
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


    public function rules()
    {
        $personId = $this->route('person')->id;

        return [
            'ci'               => ['nullable', 'string', 'max:20', Rule::unique('people')->ignore($personId)],
            'first_name'       => 'required|string|max:255',
            'middle_name'      => 'nullable|string|max:255',
            'paternal_surname' => 'nullable|string|max:255',
            'maternal_surname' => 'nullable|string|max:255',
            'birth_date'       => 'nullable|date',
            'gender'           => 'nullable|string|max:50',
            'phone'            => 'nullable|string|max:50',
            'address'          => 'nullable|string',
            'email'            => ['nullable', 'email', 'max:255', Rule::unique('people')->ignore($personId)],
            'image'            => 'nullable|image|mimes:jpeg,jpg,png,bmp,webp|max:2048',
            'status'           => 'nullable|boolean',
        ];
    }
}
