<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (session('role') == 'mahasiswa')
            return auth("mahasiswa")->check();
        if (session('role') == 'dosen')
            return auth("dosen")->check();
        if (session('role') == 'admin-prodi')
            return auth()->check();

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:8|max:32|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => "Password Lama Tidak Boleh Kosong",
            "new_password.required" => "Password Baru Tidak Boleh Kosong",
            "new_password.min" => "Panjang Password Minimal 8 Karakter",
            "new_password.max" => "Panjang Password Minimal 32 Karakter",
            "new_password.confirmed" => "Password Baru dan Konfirmasi Password Baru tidak sama"
        ];
    }
}
