<?php

namespace App\Http\Requests;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Http\FormRequest;

class AdminChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response
    {
        if($this->has('dosen_id')){
            $dosen = Dosen::find($this->integer("dosen_id"));

            return auth()->check()
                ? Response::allow()
                : Response::deny("Anda tidak bisa mengganti password Dosen");
        }
        else if($this->has('mahasiswa_id')){
            $mahasiswa = Mahasiswa::find($this->integer('mahasiswa_id'));

            return $this->user()->can('changePassword', $mahasiswa)
                ? Response::allow()
                : Response::deny("Anda tidak bisa mengganti password Mahasiswa Prodi lain");
        }

        return Response::deny("Unauthorized");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dosen_id' => "nullable|exists:dosen,id",
            "mahasiswa_id" => "nullable|exists:mahasiswa,id",
            'new_password' => 'required|min:8|max:32|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            "new_password.required" => "Password Baru Tidak Boleh Kosong",
            "new_password.min" => "Panjang Password Minimal 8 Karakter",
            "new_password.max" => "Panjang Password Minimal 32 Karakter",
            "new_password.confirmed" => "Password Baru dan Konfirmasi Password Baru tidak sama"
        ];
    }
}
