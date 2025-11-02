<?php

namespace App\Http\Controllers\Panitia\Surat;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Panitia;
use App\Models\Periode;
use App\Models\Proposal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DaftarDosenPembimbingMahasiswaController extends Controller
{
    public function create(): View
    {
        $daftarDosen = Dosen::all();

        return view(
            "panitia.surat.tampilan-web.daftar-dosen-pembimbing.create",
            compact('daftarDosen')
        );
    }

    public function previewPage(Request $request): View|RedirectResponse
    {
        $request->validate([
            "dosen" => "required|exists:dosen,id"
        ]);

        $dosen = Dosen::find($request->integer("dosen"));

        return view(
            "panitia.surat.tampilan-web.daftar-dosen-pembimbing.preview",
            compact('dosen')
        );
    }

    public function previewSurat(Request $request): Response
    {
        $request->validate([
            "dosen" => "required|exists:dosen,id"
        ]);

        $dosen = Dosen::find($request->integer("dosen"));
        $periodeAktif = Periode::firstWhere("aktif_sempro", true);
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $daftarProposal = Proposal::where("prodi_id", $prodiPanitia)
            ->where("periode_id", $periodeAktif->id)
            ->whereNotNull("dosen_pembimbing_2_id")
            ->where(function ($query) use ($dosen) {
                $query->where("dosen_pembimbing_1_id", $dosen->id)
                    ->orWhere("dosen_pembimbing_2_id", $dosen->id);
            })
            ->with("proposalMahasiswas.mahasiswa", "dosenPembimbing1", "dosenPembimbing1")
            ->get();

        $namaDosen = $dosen->nama;
        $tahunAkademik = $periodeAktif->tahun;

        // Jika Prodi Panitia D3
        if ($prodiPanitia == 1) {
            $rowsPerPage = 10;
            $totalData = $daftarProposal->count();
            $totalPages = $totalData > 0 ? ceil($totalData / $rowsPerPage) : 1;

            $pdf = Pdf::loadView(
                "panitia.surat.template-surat.daftar-dosen-pembimbing.undangan-d3",
                compact('daftarProposal', 'rowsPerPage', 'namaDosen', 'tahunAkademik')
            );

            $pdf->setOptions([
                "isHtml5ParserEnabled" => true,
                "isRemoteEnabled" => true
            ]);

            return $pdf->stream('daftar_dosen_pembimbing_' . $dosen->nama . '.pdf');
        }

        $rowsPerPage = 10;
        $totalData = $daftarProposal->count();
        $totalPages = $totalData > 0 ? ceil($totalData / $rowsPerPage) : 1;

        $pdf = Pdf::loadView(
            "panitia.surat.template-surat.daftar-dosen-pembimbing.undangan-d4",
            compact('daftarProposal', 'rowsPerPage', 'namaDosen', 'tahunAkademik')
        );

        $pdf->setOptions([
            "isHtml5ParserEnabled" => true,
            "isRemoteEnabled" => true
        ]);

        return $pdf->stream('daftar_dosen_pembimbing_' . $dosen->nama . '.pdf');
    }

    public function downloadSurat(Request $request): Response
    {
         $request->validate([
            "dosen" => "required|exists:dosen,id"
        ]);

        $dosen = Dosen::find($request->integer("dosen"));
        $periodeAktif = Periode::firstWhere("aktif_sempro", true);
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $daftarProposal = Proposal::where("prodi_id", $prodiPanitia)
            ->where("periode_id", $periodeAktif->id)
            ->whereNotNull("dosen_pembimbing_2_id")
            ->where(function ($query) use ($dosen) {
                $query->where("dosen_pembimbing_1_id", $dosen->id)
                    ->orWhere("dosen_pembimbing_2_id", $dosen->id);
            })
            ->with("proposalMahasiswas.mahasiswa", "dosenPembimbing1", "dosenPembimbing1")
            ->get();

        $namaDosen = $dosen->nama;
        $tahunAkademik = $periodeAktif->tahun;

        // Jika Prodi Panitia D3
        if ($prodiPanitia == 1) {
            $rowsPerPage = 10;
            $totalData = $daftarProposal->count();
            $totalPages = $totalData > 0 ? ceil($totalData / $rowsPerPage) : 1;

            $pdf = Pdf::loadView(
                "panitia.surat.template-surat.daftar-dosen-pembimbing.undangan-d3",
                compact('daftarProposal', 'rowsPerPage', 'namaDosen', 'tahunAkademik')
            );

            $pdf->setOptions([
                "isHtml5ParserEnabled" => true,
                "isRemoteEnabled" => true
            ]);

            return $pdf->download('daftar_dosen_pembimbing_' . $dosen->nama . '.pdf');
        }

        $rowsPerPage = 10;
        $totalData = $daftarProposal->count();
        $totalPages = $totalData > 0 ? ceil($totalData / $rowsPerPage) : 1;

        $pdf = Pdf::loadView(
            "panitia.surat.template-surat.daftar-dosen-pembimbing.undangan-d4",
            compact('daftarProposal', 'rowsPerPage', 'namaDosen', 'tahunAkademik')
        );

        $pdf->setOptions([
            "isHtml5ParserEnabled" => true,
            "isRemoteEnabled" => true
        ]);

        return $pdf->download('daftar_dosen_pembimbing_' . $dosen->nama . '.pdf');
    }
}
