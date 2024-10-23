<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectoralDataRequest extends FormRequest
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
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'sex' => 'required',
            'nationality' => 'required',
            'religion' => 'required',
            'barangay' => 'required',
            'municipality' => 'required',
            'birthdate' => 'required',
            'place_birth' => 'required',
            'civil_status' => 'required',
        ];
    }
}
