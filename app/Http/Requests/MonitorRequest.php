<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MonitorRequest extends FormRequest
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
            'claimant' => 'required',
            'beneficiary' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'contactNo' => 'required|max 11',
            'sector' => 'required',

        ];
    }
}
