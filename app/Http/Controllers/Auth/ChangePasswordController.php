<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm(): View
    {
        return view("auth.change-password");
    }

    public function changePassword(Request $request)
    {
        $savedMhs = false;
        $savedDosen = false;

        if (session('role') == 'mahasiswa') {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);
            // Cek password tidak sama dengan NIM
            $mahasiswa = Mahasiswa::find(auth("mahasiswa")->id());
            if ($mahasiswa && $request->input('new_password') === $mahasiswa->nim) {
                return back()->withErrors(['new_password' => 'Password tidak boleh sama dengan NIM Anda.']);
            }

            // Cek Password Lama
            if (!password_verify($request->input('current_password'), $mahasiswa->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $mahasiswa->password = Hash::make($request->input('new_password'));
            $savedMhs = $mahasiswa->save();
        } else if (session('role') == 'dosen') {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $dosen = Dosen::find(auth("dosen")->id());
            if ($dosen && $request->input('new_password') === $dosen->nidn) {
                return back()->withErrors(['new_password' => 'Password tidak boleh sama dengan NIDN Anda.']);
            }

            // Cek Password Lama
            if (!password_verify($request->input('current_password'), $dosen->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $dosen->password = Hash::make($request->input('new_password'));
            $savedDosen = $dosen->save();
        }



        return $savedMhs || $savedDosen
            ? redirect()->route('logout')->with('status', 'Password changed successfully.')
            : back()->withErrors(['error' => 'Failed to change password. Please try again.']);
    }
}
