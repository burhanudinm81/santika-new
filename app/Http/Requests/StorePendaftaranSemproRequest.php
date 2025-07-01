<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranSemproRequest extends FormRequest
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
            'proposal_id' => 'required',
            // 'status_pendaftaran_seminar_proposal_id' => 'required',
            'file_proposal'=> 'required|file|mimes:pdf|max:10240',
            'lembar_konsultasi' => 'required|file|mimes:pdf|max:10240',
            'lembar_kerja_sama_mitra' => 'required|file|mimes:pdf|max:10240',
            'bukti_cek_plagiasi' => 'required|file|mimes:jpeg,jpg,png|max:5120',
        ];
    }


    public function messages(): array
    {
        return [
            'proposal_id.required' => 'Anda harus memilih proposal',
            'status_pendaftaran_seminar_proposal_id.required' => 'Anda harus memilih status proposal',
            'file_proposal.required' => 'Anda harus memilih file proposal',
            'lembar_konsultasi.required' => 'Anda harus memilih file lembar konsultasi',
            'lembar_kerja_sama_mitra.required' => 'Anda harus memilih file lembar kerja sama mitra',
            'bukti_cek_plagiasi.required' => 'Anda harus memilih file bukti cek plagiasi',

            'file_proposal.mimes' => 'File proposal harus berupa file PDF dan maksimal 10MB',
            'lembar_konsultasi.mimes' => 'File lembar konsultasi harus berupa file PDF dan maksimal 10MB',
            'lembar_kerja_sama_mitra.mimes' => 'File lembar kerja sama mitra harus berupa file PDF dan maksimal 10MB',
            'bukti_cek_plagiasi.mimes' => 'File bukti cek plagiasi harus berupa file JPG, JPEG, PNG dan maksimal 5MB',
            'file_proposal.max' => 'File proposal maksimal 10MB',
            'lembar_konsultasi.max' => 'File lembar konsultasi maksimal 10MB',
            'lembar_kerja_sama_mitra.max' => 'File lembar kerja sama mitra maksimal 10MB',
            'bukti_cek_plagiasi.max' => 'File bukti cek plagiasi maksimal 5MB',
        ];
    }
}
