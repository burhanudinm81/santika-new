<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeriodeRequest extends FormRequest
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
            'periode' => [
                'required',
                'string',
                'regex:/^\d{4}\/\d{4}$/',
                'unique:periode,tahun'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'periode.required' => "Periode wajib diisi!",
            'periode.string' => "Periode harus berupa teks!",
            'periode.regex' => "Periode harus dalam format tahun/tahun (cth: 2026/2027)",
            'periode.unique' => "Periode yang anda masukkan sudah tersedia"
        ];
    }
}
