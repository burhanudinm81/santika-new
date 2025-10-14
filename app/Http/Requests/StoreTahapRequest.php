<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTahapRequest extends FormRequest
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
            'tahap' => [
                'required',
                'string',
                'unique:tahap,tahap'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'tahap.required' => "Tahap wajib diisi!",
            'tahap.string' => "Tahap harus berupa string!",
            'tahap.unique' => "Tahap yang anda masukkan sudah tersedia"
        ];
    }
}
