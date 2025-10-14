<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodeAktifRequest extends FormRequest
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
            'periode_id' => [
                'required',
                'exists:periode,id',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'periode_id.required' => 'Periode wajib diisi!',
            'periode_id.exists' => 'Periode yang anda pilih tidak tersedia!',
        ];
    }
}
