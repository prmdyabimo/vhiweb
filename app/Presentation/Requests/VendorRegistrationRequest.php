<?php

namespace App\Presentation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'company_phone' => 'required|string|max:20',
            'company_email' => 'required|email',
            'tax_number' => 'required|string|unique:vendors,tax_number',
            'business_license' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'Company name is required',
            'company_address.required' => 'Company address is required',
            'company_phone.required' => 'Company phone is required',
            'company_email.required' => 'Company email is required',
            'tax_number.required' => 'Tax number is required',
            'tax_number.unique' => 'Tax number has already been taken',
            'business_license.required' => 'Business license is required',
            'status.required' => 'Status is required',
            'description.string' => 'Description must be a string'
        ];
    }
}