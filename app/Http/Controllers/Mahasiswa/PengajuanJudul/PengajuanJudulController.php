<?php

namespace App\Http\Controllers\Mahasiswa\PengajuanJudul;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanJudulStoreRequest;
use App\Models\BidangMinat;
use App\Models\Dosen;
use App\Models\JenisJudul;
use App\Models\KuotaDosen;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;

class PengajuanJudulController extends Controller
{
    public function showPengajuanPage()
    {
        $prodi = Prodi::all();

        // mengambil data dari table jenis judul
        $jenisJudul = JenisJudul::all();

        // mengambil data dari table bidang minat
        $bidangMinat = BidangMinat::all();

        // $dosen = Dosen::all();

        $isHavePendingPengajuan = false;
        $statusProposalId = 0;
        $checkPendingPengajuan = ProposalDosenMahasiswa::where('mahasiswa_id', auth('mahasiswa')->user()->id)
           ->whereIn('status_proposal_mahasiswa_id', [3, 1])
            // ->orWhere('status_proposal_mahasiswa_id', 1)
            ->get();
        if (count($checkPendingPengajuan) > 0) {
            $isHavePendingPengajuan = true;
            $statusProposalId = $checkPendingPengajuan->first()->status_proposal_mahasiswa_id;
        }

        // dd($checkPendingPengajuan);

        return view(
            'mahasiswa.pengajuan-judul.mandiri',
            compact('prodi', 'jenisJudul', 'bidangMinat', 'isHavePendingPengajuan', 'statusProposalId')
        );
    }

    public function storePengajuanJudul(PengajuanJudulStoreRequest $request)
    {
        $validated = $request->validated();

        // pengecekan kuota dosen yang direquest
        $kuotaDosenPembimbing = KuotaDosen::where('dosen_id', $validated['calon_dosen_id'])->first();
        if($validated['prodi_id'] == "1"){
            if($kuotaDosenPembimbing->kuota_pembimbing_1_D3 <= 0){
                return redirect()->back()->with('error', 'Dosen pembimbing sudah tidak available');
            }
        }else if($validated['prodi_id'] == "2"){
            if($kuotaDosenPembimbing->kuota_pembimbing_1_D4 <= 0){
                return redirect()->back()->with('error', 'Dosen pembimbing sudah tidak available');
            }
        }

        $path = null;
        if ($request->hasFile('blok_diagram')) {
            $file = $request->file('blok_diagram');

            // membuat nama file yang unik
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            // simpan ke folder 'pengajuan-judul/blok-diagram-sitem'
            $path = $file->storeAs(
                'pengajuan-judul/blok-diagram-sitem',
                $filename,
                'local'
            );
        }

        $proposal = Proposal::create([
            'prodi_id' => $validated['prodi_id'],
            'periode_id' => $validated['periode_id'],
            'jenis_judul_id' => $validated['jenis_judul_id'],
            'bidang_minat_id' => $validated['bidang_minat_id'],
            'calon_dosen_id' => $validated['calon_dosen_id'],
            // 'topik' => $validated['topik'],
            'judul' => $validated['judul'],
            'tujuan' => $validated['tujuan'],
            'latar_belakang' => $validated['latar_belakang'],
            'blok_diagram_sistem' => $path,
        ]);

        // mengambil id proposal yang baru saja dibuat
        $proposal_id = $proposal->id;

        // input mahasiswa 1
        ProposalDosenMahasiswa::create([
            'proposal_id' => $proposal_id,
            'dosen_id' => $validated['calon_dosen_id'],
            'mahasiswa_id' => $validated['mahasiswa_1_id'],
            'status_proposal_mahasiswa_id' => 3
        ]);

        // Pengecekan apakah input mahasiswa 2 ada (berarti D3)
        if ($request->mahasiswa_2_id) {
            // input mahasiswa 2
            ProposalDosenMahasiswa::create([
                'proposal_id' => $proposal_id,
                'dosen_id' => $validated['calon_dosen_id'],
                'mahasiswa_id' => $validated['mahasiswa_2_id'],
                'status_proposal_mahasiswa_id' => 3
            ]);
        }

        return redirect()->back()->with('success', 'Pengajuan Judul Berhasil Dibuat');
    }

    public function showRiwayatPengajuanPage()
    {
        $currentRiwayatPengajuan = ProposalDosenMahasiswa::with(['proposal', 'statusProposalMahasiswa'])
            ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
            // ->whereRelation('proposal', 'pendaftaran_sempro_id', null)
            ->get();


        return view('mahasiswa.pengajuan-judul.riwayat', compact('currentRiwayatPengajuan'));
    }
}
