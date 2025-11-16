<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DistrictRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isSuperadmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $districtId = $this->route('district') ? $this->route('district')->id : null;

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('districts', 'name')->ignore($districtId),
            ],
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
            'name' => 'nama kecamatan',
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
            'name.required' => 'Nama kecamatan wajib diisi.',
            'name.unique' => 'Kecamatan ini sudah terdaftar.',
            'name.max' => 'Nama kecamatan maksimal 100 karakter.',
        ];
    }
}