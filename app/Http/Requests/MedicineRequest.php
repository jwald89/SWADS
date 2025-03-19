<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineRequest extends FormRequest
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
            'last_name' => 'required',
            'brgy' => 'required',
            'municipality' => 'required',
            'date_started' => 'required',
            'date_ended' => 'required',
            'pharmacy' => 'required',
            'amount' => 'required|integer',
            'problem_present' => 'required',
            'assistance_need' => 'required',
        ];
    }
}
