<?php

namespace App\Http\Controllers\Panitia\Surat;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarProposal;
use App\Models\Panitia;
use App\Models\Periode;
use App\Models\Tahap;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class HasilSemproController extends Controller
{
    public function create(): View
    {
        $daftarTahap = Tahap::all();
        return view("panitia.surat.tampilan-web.hasil-sempro.create", compact("daftarTahap"));
    }

    public function previewPage(Request $request): View | RedirectResponse
    {
        $request->validate([
            "tahap" => "required|exists:tahap,id"
        ]);

        $tahapId = $request->integer("tahap");

        $tahap = Tahap::find($tahapId);
        $periodeAktif = Periode::firstWhere("aktif_sempro", true);
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $jadwalSempro = JadwalSeminarProposal::whereHas('proposal', function ($q) use ($tahap, $periodeAktif, $prodiPanitia) {
            $q->where('tahap_id', $tahap->id)
                ->where('periode_id', $periodeAktif->id)
                ->where('prodi_id', $prodiPanitia)
                ->whereNotNull('status_sempro_penguji_1_id')
                ->whereNotNull('status_sempro_penguji_2_id');
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->first();

        if (is_null($jadwalSempro)) {
            return back()
                ->withErrors([
                    "message" => "Jadwal Seminar Proposal untuk tahap {$tahap->tahap} periode {$periodeAktif->tahun} tidak ditemukan"
                ]);
        }

        return view("panitia.surat.tampilan-web.hasil-sempro.preview", compact('tahap'));
    }

    public function previewSurat(Request $request): Response
    {
        $request->validate([
            "tahap" => "required|exists:tahap,id"
        ]);

        $tahap = Tahap::find($request->integer("tahap"));
        $periodeAktif = Periode::firstWhere("aktif_sempro", true);
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $jadwalSempro = JadwalSeminarProposal::whereHas('proposal', function ($q) use ($tahap, $periodeAktif, $prodiPanitia) {
            $q->where('tahap_id', $tahap->id)
                ->where('periode_id', $periodeAktif->id)
                ->where('prodi_id', $prodiPanitia)
                ->whereNotNull('status_sempro_penguji_1_id')
                ->whereNotNull('status_sempro_penguji_2_id');
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        if ($jadwalSempro->isEmpty()) {
            return response()->back()
                ->withErrors([
                    "message" => "Jadwal Seminar Proposal untuk tahap {$tahap->tahap} periode {$periodeAktif->tahun} tidak ditemukan"
                ]);
        }

        $jadwalSempro->map(function ($item) {
            $statusPenguji1 = $item->proposal->status_sempro_penguji_1_id;
            $statusPenguji2 = $item->proposal->status_sempro_penguji_2_id;

            if (in_array(3, [$statusPenguji1, $statusPenguji2])) {
                $item->status = "Ditolak";
            } elseif (in_array(2, [$statusPenguji1, $statusPenguji2])) {
                $item->status = "Diterima Dengan Revisi";
            } elseif (in_array(1, [$statusPenguji1, $statusPenguji2])) {
                $item->status = "Diterima Tanpa Revisi";
            }

            return $item;
        });

        if ($prodiPanitia == 1) {
            $rowsPerPage = 13;
            $totalStudents = $jadwalSempro->count();
            $totalPages = $totalStudents > 0 ? ceil($totalStudents / $rowsPerPage) : 1;

            $pdf = Pdf::loadView(
                'panitia.surat.template-surat.hasil-sempro.undangan-d3',
                compact('jadwalSempro', 'rowsPerPage', 'totalPages', 'tahap', 'periodeAktif')
            );

            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            return $pdf->stream('pengumuman_hasil_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
        }

        $rowsPerPage = 15;
        $totalStudents = $jadwalSempro->count();
        $totalPages = $totalStudents > 0 ? ceil($totalStudents / $rowsPerPage) : 1;

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.hasil-sempro.undangan-d4',
            compact('jadwalSempro', 'rowsPerPage', 'totalPages', 'tahap', 'periodeAktif')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->stream('pengumuman_hasil_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
    }

    public function downloadSurat(Request $request): Response
    {
        $request->validate([
            "tahap" => "required|exists:tahap,id"
        ]);

        $tahap = Tahap::find($request->integer("tahap"));
        $periodeAktif = Periode::firstWhere("aktif_sempro", true);
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $jadwalSempro = JadwalSeminarProposal::whereHas('proposal', function ($q) use ($tahap, $periodeAktif, $prodiPanitia) {
            $q->where('tahap_id', $tahap->id)
                ->where('periode_id', $periodeAktif->id)
                ->where('prodi_id', $prodiPanitia)
                ->whereNotNull('status_sempro_penguji_1_id')
                ->whereNotNull('status_sempro_penguji_2_id');
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.statusPengujiSempro1', 'proposal.statusSemproPenguji2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $jadwalSempro->map(function ($item) {
            $statusPenguji1 = $item->proposal->statusPengujiSempro1;
            $statusPenguji2 = $item->proposal->statusPengujiSempro2;

            if (in_array(3, [$statusPenguji1, $statusPenguji2])) {
                $item->status = "Ditolak";
            } elseif (in_array(2, [$statusPenguji1, $statusPenguji2])) {
                $item->status = "Diterima Dengan Revisi";
            } elseif (in_array(1, [$statusPenguji1, $statusPenguji2])) {
                $item->status = "Diterima Tanpa Revisi";
            }

            return $item;
        });

        if ($prodiPanitia == 1) {
            $rowsPerPage = 13;
            $totalStudents = $jadwalSempro->count();
            $totalPages = $totalStudents > 0 ? ceil($totalStudents / $rowsPerPage) : 1;

            $pdf = Pdf::loadView(
                'panitia.surat.template-surat.hasil-sempro.undangan-d3',
                compact('jadwalSempro', 'rowsPerPage', 'totalPages', 'tahap', 'periodeAktif')
            );

            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            return $pdf->download('pengumuman_hasil_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
        }

        $rowsPerPage = 15;
        $totalStudents = $jadwalSempro->count();
        $totalPages = $totalStudents > 0 ? ceil($totalStudents / $rowsPerPage) : 1;

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.hasil-sempro.undangan-d4',
            compact('jadwalSempro', 'rowsPerPage', 'totalPages', 'tahap', 'periodeAktif')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->download('pengumuman_hasil_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
    }
}
