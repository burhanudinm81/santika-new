<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminProdiController extends Controller
{
    public function showProfile(): View
    {
        return view("admin-prodi.profile");
    }

    public function updateEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admin_prodi')->ignore(auth()->user()->id)
            ]
        ], [
            'email.required' => "Email tidak boleh kosong.",
            'email.email' => "Format email tidak valid.",
            'email.unique' => "Email sudah digunakan oleh admin prodi lain.",
        ]);

        $adminProdi = auth()->user();
        $adminProdi->email = $request->input('email');
        $adminProdi->save();

        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diubah!',
            'data' => ['email' => $adminProdi->email]
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $adminProdi = auth()->user();

        // Cek Password Lama
        if (!password_verify($data['current_password'], $adminProdi->password)) {
            return response()->json([
                "success" => false,
                "message" => "Password Lama Salah",
            ], 422);
        }

        // Cek Apakah Password sama dengan Username
        if ($adminProdi->nama == $data['new_password']) {
            return response()->json([
                "success" => false,
                "message" => "Password tidak boleh sama dengan Username"
            ], 422);
        }

        $adminProdi->password = Hash::make($data["new_password"]);
        $savedAdminProdi = $adminProdi->save();

        if (!$savedAdminProdi) {
            return response()->json([
                "success" => false,
                "message" => "Server Gagal mengganti Password"
            ], 422);
        }

        return response()->json([
            "success" => true,
            "message" => "Berhasil Mengganti Password!"
        ]);
    }
}