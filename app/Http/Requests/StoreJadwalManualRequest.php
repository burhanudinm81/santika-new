<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJadwalManualRequest extends FormRequest
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
             // Validasi input utama
            'proposal_id' => 'required|array',
            'ruang' => 'required|array',
            'tanggal' => 'required|array',
            'sesi' => 'required|array',
            'waktu_mulai' => 'required|array',
            'waktu_selesai' => 'required|array',
            'dosen_penguji_1_id' => 'required|array',
            'dosen_penguji_2_id' => 'required|array',

            // Validasi setiap elemen di dalam array menggunakan '*'
            'proposal_id.*' => 'required|integer|exists:proposal,id',
            'ruang.*' => 'required|string|max:100',
            'tanggal.*' => 'required|date',
            'sesi.*' => 'required|integer|min:1',
            'waktu_mulai.*' => 'required|date_format:H:i',
            'waktu_selesai.*' => 'required|date_format:H:i|after:waktu_mulai.*',
            'dosen_penguji_1_id.*' => 'required|integer|exists:dosen,id',
            'dosen_penguji_2_id.*' => 'required|integer|exists:dosen,id',
        ];
    }

    public function message(): array
    {
        return [
            'waktu_selesai.*.after' => 'Waktu selesai harus setelah waktu mulai pada baris yang sama.',
            'tanggal.*.date_format' => 'Format tanggal pada salah satu baris harus DD/MM/YYYY.',
        ];
    }
}
