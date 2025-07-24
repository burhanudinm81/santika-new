<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\BidangMinat;
use App\Models\StatusDosenBidangMinat;

class DosenProfileController extends Controller
{
    public function showProfile()
    {
        $dosen = Dosen::with('bidangMinats')->find(Auth::guard('dosen')->id());
        return view('dosen.profile', compact('dosen'));
    }

    public function editProfile()
    {
        $dosen = Dosen::find(Auth::guard('dosen')->id());
        $bidangMinats = \App\Models\BidangMinat::all();
        return view('dosen.edit-profile', compact('dosen', 'bidangMinats'));
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $dosen = Dosen::find(Auth::guard('dosen')->id());

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:dosen,email,' . $dosen->id,
            'nomor_telepon' => 'nullable|string|max:30',
            'gambar_peminatan_riset' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->toArray(),
            ], 422);
        }

        if ($request->hasFile('gambar_peminatan_riset')) {
            if ($dosen->gambar_peminatan_riset) {
                Storage::disk('public')->delete($dosen->gambar_peminatan_riset);
            }

            $path = $request->file('gambar_peminatan_riset')
                ->store('dosen/peminatan_riset', 'public');
            $dosen->gambar_peminatan_riset = $path;
        }

        $dosen->email = $request->input('email');
        $dosen->no_handphone = $request->input('nomor_telepon');
        $selectedBidangs = collect([
            $request->input('bidang_keahlian_1'),
            $request->input('bidang_keahlian_2'),
            $request->input('bidang_keahlian_3'),
        ])->filter()->unique();

        $bidangIds = BidangMinat::whereIn('bidang_minat', $selectedBidangs)->pluck('id')->toArray();

        $statusId = StatusDosenBidangMinat::value('id') ?? 1;

        $syncData = [];
        foreach ($bidangIds as $id) {
            $syncData[$id] = ['status_dosen_bidang_minat_id' => $statusId];
        }

        $dosen->bidangMinats()->sync($syncData);
        $dosen->deskripsi_profil = $request->input('deskripsi_profil');
        $dosen->deskripsi_peminatan_riset = $request->input('deskripsi_peminatan_riset');
        $dosen->publikasi = $request->input('publikasi');
        $dosen->link_google_scholar = $request->input('google_scholar');
        $dosen->penghargaan = $request->input('penghargaan');

        $dosen->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
        ]);
    }

    public function updateFotoProfil(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'foto_profil_baru' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $dosen = Dosen::find(Auth::guard('dosen')->id());

        if ($dosen->foto_profil) {
            Storage::disk('public')->delete($dosen->foto_profil);
        }

        $path = $request->file('foto_profil_baru')->store('dosen/foto_profil', 'public');
        $dosen->foto_profil = $path;
        $dosen->save();

        return response()->json([
            'message' => 'Foto profil berhasil diubah',
            'info' => ['image_url' => asset('/storage/' . $path)],
        ]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $dosen = Dosen::find(Auth::guard('dosen')->id());

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Hash::check($request->current_password, $dosen->password)) {
            return response()->json(['errors' => ['current_password' => ['Password saat ini tidak sesuai']]], 422);
        }

        $dosen->update(['password' => Hash::make($request->new_password)]);

        return response()->json([
            'message' => 'Password berhasil diubah',
            'redirect_url' => route('logout'),
        ]);
    }
} 