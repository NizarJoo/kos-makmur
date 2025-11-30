<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'type_name' => ['required', 'string', 'max:100'],
            'price_per_month' => ['required', 'numeric', 'min:0'],
            'availability' => ['required', 'integer', 'min:1'],
            'size' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'image' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'image',
                'mimes:jpeg,jpg,png',
                'max:2048', // 2MB
            ],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['exists:facilities,id'],
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
            'type_name' => 'room type name',
            'price_per_month' => 'price per month',
            'availability' => 'total units',
            'size' => 'room size',
            'description' => 'description',
            'image' => 'room image',
            'facilities' => 'facilities',
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
            'type_name.required' => 'Room type name is required.',
            'type_name.max' => 'Room type name must not exceed 100 characters.',
            'price_per_month.required' => 'Price per month is required.',
            'price_per_month.numeric' => 'Price must be a number.',
            'price_per_month.min' => 'Price must be at least 0.',
            'availability.required' => 'Total units is required.',
            'availability.integer' => 'Total units must be a number.',
            'availability.min' => 'Total units must be at least 1.',
            'size.max' => 'Room size must not exceed 50 characters.',
            'image.required' => 'Room image is required.',
            'image.image' => 'File must be an image.',
            'image.mimes' => 'Image must be jpeg, jpg, or png format.',
            'image.max' => 'Image size must not exceed 2MB.',
            'facilities.*.exists' => 'Selected facility is invalid.',
        ];
    }
}