<?php

namespace App\Http\Controllers\Dosen\Bimbingan;

use App\Http\Controllers\Controller;
use App\Models\LogBook;
use App\Models\Mahasiswa;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function showDaftarBimbingan()
    {
        $listBimbinganD3 = [];
        $listBimbinganD4 = [];


        $proposalD3 = Proposal::where('prodi_id', 1)
            ->where(function ($query) {
                $query->where('dosen_pembimbing_1_id', auth('dosen')->user()->id)
                    ->orWhere('dosen_pembimbing_2_id', auth('dosen')->user()->id);
            })
            ->get();


        $proposalD4 = Proposal::where('prodi_id', 2)
            ->where(function ($query) {
                $query->where('dosen_pembimbing_1_id', auth('dosen')->user()->id)
                    ->orWhere('dosen_pembimbing_2_id', auth('dosen')->user()->id);
            })
            ->get();

        foreach ($proposalD3 as $item) {
            $proposalDosenMahasiswa = ProposalDosenMahasiswa::where('proposal_id', $item->id)->get();
            if (count($proposalDosenMahasiswa) > 0) {
                $listBimbinganD3[] = $proposalDosenMahasiswa;
            }
        }

        foreach ($proposalD4 as $item) {
            $proposalDosenMahasiswa = ProposalDosenMahasiswa::where('proposal_id', $item->id)->first();
            if ($proposalDosenMahasiswa) {
                $listBimbinganD4[] = $proposalDosenMahasiswa;
            }
        }

        return view('dosen.bimbingan.daftar-bimbingan', compact(['listBimbinganD3', 'listBimbinganD4']));
    }

    public function showDaftarLogbookMahasiswa(Mahasiswa $mahasiswa)
    {
        $logbooksInfo = $mahasiswa->logbooks()
            ->where('dosen_id', auth('dosen')->user()->id)
            ->with('JenisKegiatanLogbook')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dosen.bimbingan.daftar-logbook-mahasiswa', compact('mahasiswa', 'logbooksInfo'));
    }

    public function showDetailLogbook(Mahasiswa $mahasiswa, LogBook $logbook)
    {
        $mahasiswaInfo = null;
        if ($mahasiswa->prodi_id == 1) {
            $proposalInfo = ProposalDosenMahasiswa::where('mahasiswa_id', $mahasiswa->id)->where('status_proposal_mahasiswa_id', 1)->first();
            $mahasiswaInfo = ProposalDosenMahasiswa::where('proposal_id', $proposalInfo->proposal_id)->get();
        } else if ($mahasiswa->prodi_id == 2) {
            $mahasiswaInfo = $mahasiswa;
        }

        return view('dosen.bimbingan.detail-logbook-mahasiswa', compact(['mahasiswaInfo', 'mahasiswa', 'logbook']));
    }

    public function updateVerifikasiLogbook(Request $request)
    {
        $mahasiswa1Id = $request->input('mahasiswa_id');
        $logbookId = $request->input('logbook_id');
        $catatanKhususDosen = $request->input('catatan_khusus_dosen') ?? null;
        $statusVerifLogbook = (int) $request->input('status_verif_logbook');

        $logbook = LogBook::find($logbookId);

        $logbook->update([
            'catatan_khusus_dosen' => $catatanKhususDosen,
            'status' => $statusVerifLogbook
        ]);

        return redirect()->route('dosen.bimbingan.logbook-mahasiswa', ['mahasiswa' => $mahasiswa1Id])->with('success', 'Logbook berhasil diperbarui.');
    }

    public function showDetailBimbingan(Mahasiswa $mahasiswa)
    {
        $mahasiswaInfo = null;
        $proposalSemproInfo = null;

        $proposalInfo = ProposalDosenMahasiswa::with('proposal')->where('mahasiswa_id', $mahasiswa->id)->where('status_proposal_mahasiswa_id', 1)->first();

        if ($mahasiswa->prodi_id == 1) {
            $mahasiswaInfo = ProposalDosenMahasiswa::with('mahasiswa')->where('proposal_id', $proposalInfo->proposal_id)->get();
        } else if ($mahasiswa->prodi_id == 2) {
            $mahasiswaInfo = $mahasiswa;
        }

        $proposalSemproInfo = Proposal::with(['dosenPembimbing1', 'dosenPembimbing2'])
            ->where('id', $proposalInfo->proposal_id)
            ->first();



        return view('dosen.bimbingan.detail-bimbingan', compact(['mahasiswaInfo', 'mahasiswa', 'proposalSemproInfo']));
    }
}
