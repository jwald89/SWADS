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
            // 'claimant' => 'required',
            'beneficiary' => 'required',
            // 'age' => 'required',
            // 'sex' => 'required',
            // 'contact_no' => 'required|max 11',
            'sector' => 'required',
            // 'municipality' => 'required',
            // 'barangay' => 'required',
            'client_type' => 'required',
            // 'assistance_type' => 'required',
            'amount' => 'required',
            'charges' => 'required',
            // 'date_intake' => 'required',
            'staff_admin' => 'required',
            'liaison' => 'required',
            'status_date' => 'required',
            'remarks' => 'required'
        ];
    }
}
