<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerimaSemuaLogbookRequest extends FormRequest
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
            'mahasiswa_id' => ['required', 'exists:mahasiswa,id'],
            'peran_dosbing' => ['required', 'in:1,2'],
        ];
    }

    public function messages(): array
    {
        return [
            'mahasiswa_id.required' => 'Mahasiswa tidak ditemukan.',
            'mahasiswa_id.exists' => 'Mahasiswa tidak ditemukan di database.',
            'peran_dosbing.required' => 'Peran dosen pembimbing harus diisi.',
            'peran_dosbing.in' => 'Peran dosen pembimbing tidak valid.',
        ];
    }
}
