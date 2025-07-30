<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukaPendaftaranRequest extends FormRequest
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
            'periode_id' => 'required|exists:periode,id',
            'tahap_id' => 'required|exists:tahap,id'
        ];
    }

    public function messages(): array
    {
        return [
            'periode.required' => 'Periode wajib diisi!',
            'periode.exists' => 'Periode yang anda pilih tidak tersedia!',
            'tahap.required' => 'Tahap wajib diisi!',
            'tahap.exists' => 'Tahap yang anda pilih tidak tersedia!',
        ];
    }
}
