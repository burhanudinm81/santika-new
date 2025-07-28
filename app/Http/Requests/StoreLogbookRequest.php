<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLogbookRequest extends FormRequest
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
            'roleDospem' => 'required|integer',
            'jenisKegiatanId' => 'required',
            'namaKegiatan' => 'required',
            'tanggalKegiatan' => 'required',
            'hasilKegiatan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'jenisKegiatanId.required' => 'Jenis Kegiatan wajib diisi',
            'namaKegiatan.required' => 'Nama Kegiatan wajib diisi',
            'tanggalKegiatan.required' => 'Tanggal Kegiatan wajib diisi',
            'hasilKegiatan.required' => 'Hasil Kegiatan wajib diisi',
        ];
    }
}
