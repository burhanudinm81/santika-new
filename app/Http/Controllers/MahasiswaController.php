<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function showProfile()
    {
        $mahasiswa = Mahasiswa::find(Auth::guard('mahasiswa')->id());
        $mahasiswa->load('prodi');
        return view('mahasiswa.profile', compact('mahasiswa'));
    }

    public function editProfile()
    {
        $mahasiswa = Mahasiswa::find(Auth::guard('mahasiswa')->id());
        return view('mahasiswa.edit-profil', compact('mahasiswa'));
    }

    public function updateProfile(Request $request)
    {
        $mahasiswa = Mahasiswa::find(Auth::guard('mahasiswa')->id());

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:mahasiswa,email,' . $mahasiswa->id,
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', 'foto_profil']);

        if ($request->hasFile('foto_profil')) {
            if ($mahasiswa->foto_profil) {
                Storage::delete('public/' . $mahasiswa->foto_profil);
            }

            $data['foto_profil'] = $request->file('foto_profil')->store('public/mahasiswa/foto_profil', 'public');
        }

        $mahasiswa->update($data);

        return redirect()->route('mahasiswa.profil')->with('success', 'Profil berhasil diubah');
    }

    public function changePassword(Request $request)
    {
        $mahasiswa = Mahasiswa::find(Auth::guard('mahasiswa')->id());

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->current_password, $mahasiswa->password)) {
            if ($request->ajax()) {
                return response()->json(['errors' => ['current_password' => ['Password saat ini tidak sesuai']]], 422);
            }
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $mahasiswa->update(['password' => Hash::make($request->new_password)]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Password berhasil diubah',
                'redirect_url' => route('logout'),
            ]);
        }

        return redirect()->route('mahasiswa.profil')->with('success', 'Password berhasil diubah');
    }

    public function updateEmail(Request $request)
    {
        $mahasiswa = Mahasiswa::find(Auth::guard('mahasiswa')->id());

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:mahasiswa,email,' . $mahasiswa->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $mhs = Mahasiswa::find(Auth::guard('mahasiswa')->id());
        $mhs->email = $request->email;
        $mhs->save();

        return response()->json([
            'message' => 'Email berhasil diperbarui'
        ]);
    }

    public function updateFotoProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto_profil_baru' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $mhs = Mahasiswa::find(Auth::guard('mahasiswa')->id());

        if ($mhs->foto_profil) {
            Storage::disk('public')->delete($mhs->foto_profil);
        }

        $path = $request->file('foto_profil_baru')
            ->store('mahasiswa/foto_profil', 'public');
        $mhs->foto_profil = $path;
        $mhs->save();

        return response()->json([
            'message' => 'Foto profil berhasil diubah',
            'info' => ['image_url' => asset('/storage/' . $path)],
        ]);
    }
}
