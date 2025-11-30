<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoardingHouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'address' => ['required', 'string'],
            'district_id' => ['required', 'exists:districts,id'],
            'description' => ['required', 'string'],
            'image' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'image',
                'mimes:jpeg,jpg,png',
                'max:2048', // 2MB
            ],
            'type' => ['required', 'in:male,female,mixed'],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'boarding house name',
            'address' => 'address',
            'district_id' => 'district',
            'description' => 'description',
            'image' => 'image',
            'type' => 'type',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Boarding house name is required.',
            'name.max' => 'Boarding house name must not exceed 200 characters.',
            'address.required' => 'Address is required.',
            'district_id.required' => 'Please select a district.',
            'district_id.exists' => 'Selected district is invalid.',
            'description.required' => 'Description is required.',
            'image.required' => 'Image is required.',
            'image.image' => 'File must be an image.',
            'image.mimes' => 'Image must be jpeg, jpg, or png format.',
            'image.max' => 'Image size must not exceed 2MB.',
            'type.required' => 'Please select boarding house type.',
            'type.in' => 'Invalid boarding house type.',
        ];
    }
}