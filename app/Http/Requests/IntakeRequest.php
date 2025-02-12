<?php

namespace App\Http\Requests;

use App\Enums\CivilStatus;
use App\Enums\GenderTypes;
use Illuminate\Foundation\Http\FormRequest;

class IntakeRequest extends FormRequest
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
            'classification' => 'required|string',
            'category' => 'required',
            'date_intake' => 'required|date',
            'last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'required|string|max:100',
            'nick_name' => 'required|string|max:100',
            'age' => 'required|integer',
            'birthdate' => 'required|date',
            'sex' => 'required',
            'barangay' => 'required',
            'municipality' => 'required',
            'civil_stats' => 'required',
            'job' => 'required|string',
            'contact_no' => 'nullable|string',
            'income' => 'required'
        ];
    }
}
