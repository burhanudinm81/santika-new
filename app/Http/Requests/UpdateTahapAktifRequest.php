<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTahapAktifRequest extends FormRequest
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
            'tahap_id' => 'required|exists:tahap,id'
        ];
    }

    public function messages(): array
    {
        return [
            'tahap_id.required' => 'Tahap wajib diisi!',
            'tahap_id.exists' => 'Tahap yang anda pilih tidak tersedia!',
        ];
    }
}
