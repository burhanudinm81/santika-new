<?php

namespace App\Http\Controllers\Dosen\Bimbingan;

use App\Http\Controllers\Controller;
use App\Http\Requests\TerimaSemuaLogbookRequest;
use App\Models\LogBook;
use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BimbinganController extends Controller
{
    public function showDaftarBimbingan()
    {
        $listBimbinganD3 = collect();
        $listBimbinganD4 = collect();

        // Daftar Logbook Yang Belum diverifikasi Dosen
        $logbookBelumDiverifikasi = LogBook::where('dosen_id', auth('dosen')->user()->id)
            ->where("status_logbook_id", 1)
            ->groupBy("proposal_id")
            ->selectRaw("proposal_id, count(*) as jumlah")
            ->get();

        // Daftar Logbook Yang Belum Ditolak Dosen
        $logbookDitolak = LogBook::where('dosen_id', auth('dosen')->user()->id)
            ->where("status_logbook_id", 2)
            ->groupBy("proposal_id")
            ->selectRaw("proposal_id, count(*) as jumlah")
            ->get();

        // Daftar Logbook Yang Diterima Dosen
        $logbookDiterima = LogBook::where('dosen_id', auth('dosen')->user()->id)
            ->where("status_logbook_id", 3)
            ->groupBy("proposal_id")
            ->selectRaw("proposal_id, count(*) as jumlah")
            ->get();

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
                $listBimbinganD3->push($proposalDosenMahasiswa);
            }
        }

        foreach ($proposalD4 as $item) {
            $proposalDosenMahasiswa = ProposalDosenMahasiswa::where('proposal_id', $item->id)->first();
            if ($proposalDosenMahasiswa) {
                $listBimbinganD4->push($proposalDosenMahasiswa);
            }
        }

        $listBimbinganD3->map(function($item) use ($logbookBelumDiverifikasi, $logbookDitolak, $logbookDiterima) {
                $belumVerifikasi = $logbookBelumDiverifikasi->firstWhere("proposal_id", $item[0]->proposal_id);
                $ditolak = $logbookDitolak->firstWhere("proposal_id", $item[0]->proposal_id);
                $diterima = $logbookDiterima->firstWhere("proposal_id", $item[0]->proposal_id);

                if(!is_null($belumVerifikasi)){
                    $item->jmlBelumDiverifikasi = $belumVerifikasi->jumlah;
                } else{
                    $item->jmlBelumDiverifikasi = null;
                }

                if(!is_null($ditolak)){
                    $item->jmlDitolak = $ditolak->jumlah;
                } else{
                    $item->jmlDitolak = null;
                }

                if(!is_null($diterima)){
                    $item->jmlDiterima = $diterima->jumlah;
                } else{
                    $item->jmlDiterima = null;
                }

                return $item;
            });

        $listBimbinganD4->map(function($item) use ($logbookBelumDiverifikasi, $logbookDitolak, $logbookDiterima) {
                $belumVerifikasi = $logbookBelumDiverifikasi->firstWhere("proposal_id", $item->proposal_id);
                $ditolak = $logbookDitolak->firstWhere("proposal_id", $item->proposal_id);
                $diterima = $logbookDiterima->firstWhere("proposal_id", $item->proposal_id);

                if(!is_null($belumVerifikasi)){
                    $item->jmlBelumDiverifikasi = $belumVerifikasi->jumlah;
                } else{
                    $item->jmlBelumDiverifikasi = null;
                }

                if(!is_null($ditolak)){
                    $item->jmlDitolak = $ditolak->jumlah;
                } else{
                    $item->jmlDitolak = null;
                }

                if(!is_null($diterima)){
                    $item->jmlDiterima = $diterima->jumlah;
                } else{
                    $item->jmlDiterima = null;
                }

                return $item;
            });

        // dd($listBimbinganD4);

        return view('dosen.bimbingan.daftar-bimbingan', compact(['listBimbinganD3', 'listBimbinganD4']));
    }

    public function showDaftarLogbookMahasiswa(Mahasiswa $mahasiswa)
    {
        $logbooksInfo = $mahasiswa->logbooks()
            ->where('dosen_id', auth('dosen')->user()->id)
            ->with(['JenisKegiatanLogbook', 'statusLogbook'])
            ->orderBy('created_at', 'desc')
            ->get();

        $mahasiswa->load('proposalMahasiswas.proposal:id,dosen_pembimbing_1_id,dosen_pembimbing_2_id');
        $proposalDosenMahasiswa = $mahasiswa->proposalMahasiswas->first();
        $peranDosbing = auth("dosen")->user()->id == $proposalDosenMahasiswa->proposal->dosen_pembimbing_1_id ? 1 : 2;

        return view('dosen.bimbingan.daftar-logbook-mahasiswa', compact('mahasiswa', 'logbooksInfo', 'peranDosbing'));
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
            'status_logbook_id' => $statusVerifLogbook
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

    public function terimaSemuaLogbook(TerimaSemuaLogbookRequest $request)
    {
        $mahasiswaId = $request->input('mahasiswa_id');
        $peranDosbing = $request->input('peran_dosbing');
        $periodeAktif = Periode::firstWhere('aktif_sempro', true);
        $latestProposalId = null;

        // Id Proposal terbaru mahasiswa
        if($peranDosbing == 1){
            $latestProposalId = ProposalDosenMahasiswa::where('mahasiswa_id', $mahasiswaId)
            ->whereHas('proposal', function ($query) use ($periodeAktif) {
                $query->where('periode_id', $periodeAktif->id)
                      ->where('dosen_pembimbing_1_id', auth('dosen')->user()->id);
            })
            ->latest()
            ->first()
            ->proposal_id;
        } else {
            $latestProposalId = ProposalDosenMahasiswa::where('mahasiswa_id', $mahasiswaId)
            ->whereHas('proposal', function ($query) use ($periodeAktif) {
                $query->where('periode_id', $periodeAktif->id)
                      ->where('dosen_pembimbing_2_id', auth('dosen')->user()->id);
            })
            ->latest()
            ->first()
            ->proposal_id;
        }

        if($latestProposalId == null){
            return redirect()->back()->with('error', 'Tidak ada proposal aktif yang ditemukan untuk mahasiswa ini.');
        }

        // Update semua logbook mahasiswa tersebut yang belum diverifikasi
        LogBook::where('mahasiswa_id', $mahasiswaId)
            ->where('dosen_id', auth('dosen')->user()->id)
            ->where('proposal_id', $latestProposalId)
            ->where('status_logbook_id', 1) // 1 adalah status "Belum Diverifikasi"
            ->update(['status_logbook_id' => 3]); // 3 adalah status "Diterima"

        return redirect()->route('dosen.bimbingan.logbook-mahasiswa', ['mahasiswa' => $mahasiswaId])->with('success', 'Semua logbook berhasil diterima.');
    }
}
