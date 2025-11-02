<?php

namespace App\Http\Controllers\Panitia\Surat;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarProposal;
use App\Models\Panitia;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\Tahap;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UndanganSemproController extends Controller
{
    public function create(): View
    {
        $daftarTahap = Tahap::all();
        return view("panitia.surat.tampilan-web.undangan-sempro.create", compact('daftarTahap'));
    }

    public function previewPage(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string',
            'tahap' => 'required|exists:tahap,id',
            'penandatangan' => 'required|string',
            'tempat' => 'nullable|string'
        ]);

        // Cek apakah user memilih input manual
        if ($request->penandatangan === 'manual') {
            // Validasi input manual
            $request->validate([
                'nama_manual' => 'required|string',
                'nip_manual' => 'required|string'
            ]);

            $namaPenandatangan = $request->nama_manual;
            $nipPenandatangan = $request->nip_manual;
            $penandatanganRaw = $request->nama_manual . '|' . $request->nip_manual;
        } else {
            // Split nama dan NIP dari dropdown
            $penandatanganData = explode('|', $request->penandatangan);
            $namaPenandatangan = $penandatanganData[0] ?? '';
            $nipPenandatangan = $penandatanganData[1] ?? '';
            $penandatanganRaw = $request->penandatangan;
        }

        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;
        $tahap = Tahap::find($request->tahap);
        $periodeAktif = Periode::firstWhere("aktif_sempro", 1);
        $proposal = Proposal::join("jadwal_seminar_proposal", "proposal.id", "=", "jadwal_seminar_proposal.proposal_id")
            ->where('proposal.tahap_id', $tahap->id)
            ->where('proposal.periode_id', $periodeAktif->id)
            ->where('proposal.prodi_id', $prodiPanitia)
            ->orderBy('jadwal_seminar_proposal.tanggal', 'asc')
            ->orderBy('jadwal_seminar_proposal.waktu_mulai', 'asc')
            ->first();

        if (is_null($proposal)) {
            return back()
                ->withErrors([
                    "message" => "Jadwal Seminar Proposal untuk tahap {$tahap->tahap} periode {$periodeAktif->tahun} tidak ditemukan"
                ]);
        }

        $tempat = $request->get("tempat", "Ruang Kelas Gedung AH Lantai 1");
        $hariTanggal = Carbon::parse($proposal->tanggal)->translatedFormat('l, d F Y');
        $waktuPelaksanaan = Carbon::parse($proposal->waktu_mulai)->format('H.i');

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'nama_penandatangan' => $namaPenandatangan,
            'nip_penandatangan' => $nipPenandatangan,
            'penandatangan_raw' => $penandatanganRaw,
            'tahap' => $tahap,
            'tahun_akademik' => $periodeAktif,
            'hari_tanggal' => $hariTanggal,
            'waktu_pelaksanaan' => $waktuPelaksanaan,
            'tempat' => $tempat
        ];

        // if ($request->ajax()) {
        //     return response()->json([
        //         'success' => true,
        //         'data' => $data,
        //         'iframe_url' => route('undangan.content', $data),
        //         'download_url' => route('undangan.download', $data)
        //     ]);
        // }

        return view('panitia.surat.tampilan-web.undangan-sempro.preview', compact('data'));
    }

    public function previewSurat(Request $request): Response
    {
        $tahap = Tahap::find($request->integer("tahap"));
        $periode = Periode::find($request->integer("periode"));
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $jadwalSempro = JadwalSeminarProposal::whereHas('proposal', function ($q) use ($tahap, $periode, $prodiPanitia) {
            $q->where('tahap_id', $tahap->id)
                ->where('periode_id', $periode->id)
                ->where('prodi_id', $prodiPanitia);
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.dosenPembimbing1', 'proposal.dosenPengujiSempro1', 'proposal.dosenPengujiSempro2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $rowsPerPage = 8;
        $totalStudents = count($jadwalSempro);
        $totalPages = ceil($totalStudents / $rowsPerPage);

        // Data dari form
        $data = [
            'nomor_surat' => $request->get('nomor_surat', ''),
            'nama_penandatangan' => $request->get('nama_penandatangan', ''),
            'nip_penandatangan' => $request->get('nip_penandatangan', ''),
            'penandatangan_raw' => $request->get('penandatangan_raw', ''),
            'total_lampiran' => $totalPages,
            'tahap' => $tahap->tahap,
            'tahun_akademik' => $periode->tahun,
            'hari_tanggal' => $request->get('hari_tanggal', ''),
            'waktu_pelaksanaan' => $request->get("waktu_pelaksanaan", ""),
            'tempat' => $request->get("tempat", "")
        ];

        $pdf = Pdf::loadView('panitia.surat.template-surat.undangan-sempro.undangan', compact('data'));
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->stream('undangan_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
    }

    public function previewLampiran(Request $request): Response
    {
        $tahapId = $request->integer("tahap");
        $periodeId = $request->integer("periode");
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $tahap = Tahap::find($tahapId);

        $jadwalSempro = JadwalSeminarProposal::whereHas('proposal', function ($q) use ($tahapId, $periodeId, $prodiPanitia) {
            $q->where('tahap_id', $tahapId)
                ->where('periode_id', $periodeId)
                ->where('prodi_id', $prodiPanitia);
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.dosenPembimbing1', 'proposal.dosenPengujiSempro1', 'proposal.dosenPengujiSempro2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $jadwalSempro->map(function ($item) {
            Carbon::setLocale("id");
            $tanggal = Carbon::parse($item->tanggal)->translatedFormat("l, d F Y");

            $item->tanggal_seminar = $tanggal;
            return $item;
        });

        $rowsPerPage = 8;
        $totalStudents = count($jadwalSempro);
        $totalPages = ceil($totalStudents / $rowsPerPage);

        if ($prodiPanitia == 1) {
            $pdf = Pdf::loadView(
                'panitia.surat.template-surat.undangan-sempro.lampiran-d3',
                compact('jadwalSempro', 'rowsPerPage', 'totalPages')
            );

            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            return $pdf->stream('lampiran_undangan_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
        }

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.undangan-sempro.lampiran-d4',
            compact('jadwalSempro', 'rowsPerPage', 'totalPages')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->stream('lampiran_undangan_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
    }

    public function downloadSurat(Request $request)
    {
        // Implementasi untuk mengunduh surat sebagai PDF
        $tahap = Tahap::find($request->integer("tahap"));
        $periode = Periode::find($request->integer("periode"));
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $jadwalSempro = JadwalSeminarProposal::whereHas('proposal', function ($q) use ($tahap, $periode, $prodiPanitia) {
            $q->where('tahap_id', $tahap->id)
                ->where('periode_id', $periode->id)
                ->where('prodi_id', $prodiPanitia);
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.dosenPembimbing1', 'proposal.dosenPengujiSempro1', 'proposal.dosenPengujiSempro2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $rowsPerPage = 8;
        $totalStudents = count($jadwalSempro);
        $totalPages = ceil($totalStudents / $rowsPerPage);

        // Data dari form
        $data = [
            'nomor_surat' => $request->get('nomor_surat', ''),
            'nama_penandatangan' => $request->get('nama_penandatangan', ''),
            'nip_penandatangan' => $request->get('nip_penandatangan', ''),
            'penandatangan_raw' => $request->get('penandatangan_raw', ''),
            'total_lampiran' => $totalPages,
            'tahap' => $tahap->tahap,
            'tahun_akademik' => $periode->tahun,
            'hari_tanggal' => $request->get('hari_tanggal', ''),
            'waktu_pelaksanaan' => $request->get("waktu_pelaksanaan", ""),
            'tempat' => $request->get("tempat", "")
        ];

        $pdf = Pdf::loadView('panitia.surat.template-surat.undangan-sempro.undangan', compact('data'));
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->download('undangan_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
    }

    public function downloadLampiran(Request $request)
    {
        $tahapId = $request->integer("tahap");
        $periodeId = $request->integer("periode");
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $tahap = Tahap::find($tahapId);

        $jadwalSempro = JadwalSeminarProposal::whereHas('proposal', function ($q) use ($tahapId, $periodeId, $prodiPanitia) {
            $q->where('tahap_id', $tahapId)
                ->where('periode_id', $periodeId)
                ->where('prodi_id', $prodiPanitia);
        })
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.dosenPembimbing1', 'proposal.dosenPengujiSempro1', 'proposal.dosenPengujiSempro2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $jadwalSempro->map(function ($item) {
            Carbon::setLocale("id");
            $tanggal = Carbon::parse($item->tanggal)->translatedFormat("l, d F Y");

            $item->tanggal_seminar = $tanggal;
            return $item;
        });

        $rowsPerPage = 8;
        $totalStudents = count($jadwalSempro);
        $totalPages = ceil($totalStudents / $rowsPerPage);

        if ($prodiPanitia == 1) {
            $pdf = Pdf::loadView(
                'panitia.surat.template-surat.undangan-sempro.lampiran-d3',
                compact('jadwalSempro', 'rowsPerPage', 'totalPages')
            );

            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            return $pdf->download('lampiran_undangan_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
        }

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.undangan-sempro.lampiran-d4',
            compact('jadwalSempro', 'rowsPerPage', 'totalPages')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->download('lampiran_undangan_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
    }
}
