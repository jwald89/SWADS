<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildDevRequest extends FormRequest
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
            'cdc_name' => 'required',
            'cdw_name' => 'required',
            'barangay' => 'required',
            'municipality' => 'required',
            'lvl_recognition' => 'required',
            'validity_of_cor' => 'required',
            'no_entered_children' => 'required',
            'no_feed_recepients' => 'required',
        ];
    }
}
