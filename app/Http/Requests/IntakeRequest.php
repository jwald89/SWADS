<?php

namespace App\Http\Requests;

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
            'classification' => 'required',
            'category' => 'required',
            'dateIntake' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'nickName' => 'required',
            'barangay' => 'required',
            'municipality' => 'required',
            'age' => 'required',
            'birthDate' => 'required',
            'gender' => 'required',
            'civilStatus' => 'required',
            'contactNo' => 'required'
        ];
    }
}
