<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranSemhasRequest extends FormRequest
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
            'file_rekom_dospem' => 'required|file|mimes:pdf|max:10240',
            'file_proposal_semhas' => 'required|file|mimes:pdf|max:10240',
            'file_draft_jurnal' => 'required|file|mimes:pdf|max:10240',
            'file_IA_mitra' => 'optional|file|mimes:pdf|max:10240',
            'file_bebas_tanggungan_pkl' => 'required|file|mimes:pdf|max:10240',
            'file_skla' => 'required|file|mimes:pdf|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'file_rekom_dospem.required' => 'Anda harus memilih file rekomdosem',
            'file_proposal_semhas.required' => 'Anda harus memilih file proposal semhas',
            'file_draft_jurnal.required' => 'Anda harus memilih file draft journal',
            'file_bebas_tanggungan_pkl.required' => 'Anda harus memilih file bebas tanggungan pkl',
            'file_skla.required' => 'Anda harus memilih file skla',

            'file_rekom_dospem.mimes' => 'File rekomdosem harus berupa file PDF dan maksimal 10MB',
            'file_proposal_semhas.mimes' => 'File proposal semhas harus berupa file PDF dan maksimal 10MB',
            'file_draft_jurnal.mimes' => 'File draft journal harus berupa file PDF dan maksimal 10MB',
            'file_IA_mitra.mimes' => 'File IA mitra harus berupa file PDF dan maksimal 10MB',
            'file_bebas_tanggungan_pkl.mimes' => 'File bebas tanggungan pkl harus berupa file PDF dan maksimal 10MB',
            'file_skla.mimes' => 'File skla harus berupa file PDF dan maksimal 10MB',

            'file_rekom_dospem.max' => 'File rekomdosem maksimal 10MB',
            'file_proposal_semhas.max' => 'File proposal semhas maksimal 10MB',
            'file_draft_jurnal.max' => 'File draft journal maksimal 10MB',
            'file_IA_mitra.max' => 'File IA mitra maksimal 10MB',
            'file_bebas_tanggungan_pkl.max' => 'File bebas tanggungan pkl maksimal 10MB',
            'file_skla.max' => 'File skla maksimal 10MB',
        ];
    }
}
