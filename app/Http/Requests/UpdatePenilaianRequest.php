<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenilaianRequest extends FormRequest
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
            'proposal_id' => ['required', 'exists:proposal,id'],
            'dosen_id' => ['required', 'exists:dosen,id'],
            'status_penilaian' => ['required', 'exists:status_proposal,id'],
            'catatan_revisi' => ['required_if:status_penilaian,2', 'nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'proposal_id.required' => 'Proposal tidak ditemukan.',
            'proposal_id.exists' => 'Proposal tidak valid.',
            'dosen_id.required' => 'Dosen tidak ditemukan.',
            'dosen_id.exists' => 'Dosen tidak valid.',
            'status_penilaian.required' => 'Status penilaian harus dipilih.',
            'status_penilaian.exists' => 'Status penilaian tidak valid.',
            'catatan_revisi.required_if' => 'Catatan revisi harus diisi jika status penilaian adalah Diterima Tanpa Revisi.',
            'catatan_revisi.string' => 'Catatan revisi harus berupa teks.',
            'catatan_revisi.max' => 'Catatan revisi maksimal 1000 karakter.',
        ];
    }
}
