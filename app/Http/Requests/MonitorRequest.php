<?php

namespace App\Http\Requests;

use App\Models\AssistanceType;
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
            'beneficiary' => 'required|string',
            'sector' => 'required',
            'client_type' => 'required',
            'amount' => 'required|between:0,99.99|string',
            'charges' => 'required',
            'contact_no' => 'required',
            'staff_admin' => 'required',
            'liaison' => 'required',
            'status' => 'required'
        ];
    }
}
