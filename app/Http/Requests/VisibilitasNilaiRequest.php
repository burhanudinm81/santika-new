<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisibilitasNilaiRequest extends FormRequest
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
            'tahap_id' => ['required', 'exists:tahap,id'],
            'periode_id' => ['required', 'exists:periode,id'],
            'jenis_nilai_seminar' => ['required', 'int', 'in:1,2,3'],
        ];
    }

    public function messages(): array
    {
        return [
            'tahap_id.required' => 'Tahap seminar harus dipilih.',
            'tahap_id.exists' => 'Tahap seminar yang dipilih tidak valid.',
            'periode_id.required' => 'Periode seminar harus dipilih.',
            'periode_id.exists' => 'Periode seminar yang dipilih tidak valid.',
            'jenis_nilai_seminar.required' => 'Jenis seminar harus dipilih.',
            'jenis_nilai_seminar.int' => 'Jenis seminar tidak valid.',
            'jenis_nilai_seminar.in' => 'Jenis seminar tidak valid.',
        ];
    }
}
