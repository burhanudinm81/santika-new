<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanJudulStoreRequest extends FormRequest
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
            'mahasiswa_1_id' => 'required|integer',
            'mahasiswa_2_id' => 'integer',
            'prodi_id' => 'required|integer',
            'periode_id' => 'required|integer',
            'jenis_judul_id' => 'required|integer',
            'bidang_minat_id' => 'required|integer',
            'calon_dosen_id' => 'required|integer',
            'topik' => 'required|string',
            'judul' => 'required|string',
            'tujuan' => 'required|string',
            'latar_belakang' => 'required|string',
            'blok_diagram' => 'required|file|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'mahasiswa_1_id.required' => 'Mahasiswa 1 tidak boleh kosong',
            'mahasiswa_2_id.required' => 'Mahasiswa 2 tidak boleh kosong',
            'jenis_judul_id.required' => 'Jenis Judul tidak boleh kosong',
            'bidang_minat_id.required' => 'Bidang Minat tidak boleh kosong',
            'calon_dosen_id.required' => 'Calon Dosen tidak boleh kosong',
            'topik.required' => 'Topik/Tema Proposal tidak boleh kosong',
            'judul.required' => 'Judul Proposal tidak boleh kosong',
            'tujuan.required' => 'Tujuan Proposal tidak boleh kosong',
            'latar_belakang.required' => 'Latar Belakang tidak boleh kosong',
            'blok_diagram.required' => 'Blok Diagram Sistem tidak boleh kosong',
            'blok_diagram.mimes' => 'Blok Diagram Sistem harus berupa file JPG, JPEG, atau PNG',
            'blok_diagram.max' => 'Blok Diagram Sistem tidak boleh lebih besar dari 5MB',
        ];
    }
}
