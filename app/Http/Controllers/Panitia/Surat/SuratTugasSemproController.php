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
use Illuminate\Validation\Rule;

class SuratTugasSemproController extends Controller
{
    public function create()
    {
        $daftarTahap = Tahap::all();
        return view('panitia.surat.tampilan-web.surat-tugas-sempro.create', compact('daftarTahap'));
    }

    public function previewPage(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string',
            'tahap' => 'required|exists:tahap,id',
            'semester' => ['required', Rule::in(["Ganjil", "Genap"])],
            'tanggal_tanda_tangan' => 'required|date',
            'penandatangan' => 'required|string'
        ]);

        // Handle manual input or dropdown selection
        if ($request->penandatangan === 'manual') {
            // Validate manual input fields
            $request->validate([
                'nama_manual' => 'required|string|max:255',
                'nip_manual' => 'required|string|max:50'
            ], [
                'nama_manual.required' => 'Nama penandatangan wajib diisi',
                'nip_manual.required' => 'NIP penandatangan wajib diisi'
            ]);

            $namaPenandatangan = $request->nama_manual;
            $nipPenandatangan = $request->nip_manual;
        } else {
            // Split nama dan NIP dari dropdown
            $penandatanganData = explode('|', $request->penandatangan);
            $namaPenandatangan = $penandatanganData[0] ?? '';
            $nipPenandatangan = $penandatanganData[1] ?? '';
        }

        $tahap = Tahap::find($request->tahap);
        $periodeAktif = Periode::firstWhere("aktif_sempro", 1);

        $tanggalTandaTangan = Carbon::parse($request->get("tanggal_tanda_tangan"));
        $tanggalTtdFormatted = $tanggalTandaTangan->translatedFormat("d F Y");

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'tahap' => $tahap,
            'nama_penandatangan' => $namaPenandatangan,
            'nip_penandatangan' => $nipPenandatangan,
            'tanggal_tanda_tangan' => $tanggalTtdFormatted,
            'periode' => $periodeAktif,
            'semester' => $request->semester
        ];

        // if ($request->ajax()) {
        //     return response()->json([
        //         'success' => true,
        //         'data' => $data,
        //         'iframe_url' => route('surat.tugas.content', $data),
        //         'download_url' => route('surat.tugas.download', $data)
        //     ]);
        // }

        return view('panitia.surat.tampilan-web.surat-tugas-sempro.preview', compact('data'));
    }

    public function previewSurat(Request $request)
    {
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;
        $tahap = Tahap::find($request->tahap);
        $periodeAktif = Periode::firstWhere("aktif_sempro", 1);
        $proposalPertama = Proposal::join("jadwal_seminar_proposal", "proposal.id", "=", "jadwal_seminar_proposal.proposal_id")
            ->where('proposal.tahap_id', $tahap->id)
            ->where('proposal.periode_id', $periodeAktif->id)
            ->where('proposal.prodi_id', $prodiPanitia)
            ->orderBy('jadwal_seminar_proposal.tanggal', 'asc')
            ->first();
        $proposalTerakhir = Proposal::join("jadwal_seminar_proposal", "proposal.id", "=", "jadwal_seminar_proposal.proposal_id")
            ->where('proposal.tahap_id', $tahap->id)
            ->where('proposal.periode_id', $periodeAktif->id)
            ->where('proposal.prodi_id', $prodiPanitia)
            ->orderBy('jadwal_seminar_proposal.tanggal', 'desc')
            ->first();

        if (is_null($proposalPertama) || is_null($proposalTerakhir)) {
            return back()
                ->withErrors([
                    "message" => "Jadwal Seminar Proposal untuk tahap {$tahap->tahap} periode {$periodeAktif->tahun} tidak ditemukan"
                ]);
        }

        Carbon::setLocale("id");

        $tanggalMulai = Carbon::parse($proposalPertama->tanggal);
        $tanggalSelesai = Carbon::parse($proposalTerakhir->tanggal);

        $tanggalMulaiFormatted = $tanggalMulai->translatedFormat("d F Y");
        $tanggalSelesaiFormatted = $tanggalSelesai->translatedFormat("d F Y");

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'nama_penandatangan' => $request->get("nama_penandatangan", "-"),
            'nip_penandatangan' => $request->get("nip_penandatangan", "-"),
            'tanggal_tanda_tangan' => $request->get("tanggal_tanda_tangan"),
            'tahun_akademik' => $periodeAktif->tahun,
            'semester' => $request->get("semester"),
            'tanggal_mulai' => $tanggalMulaiFormatted,
            'tanggal_selesai' => $tanggalSelesaiFormatted
        ];

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.surat-tugas-sempro.undangan',
            compact('data')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->stream('surat_tugas_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
    }

    public function previewLampiran(Request $request)
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
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.dosenPengujiSempro1', 'proposal.dosenPengujiSempro2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $formData = [
            'nama_penandatangan' => $request->get("nama_penandatangan", "-"),
            'nip_penandatangan' => $request->get("nip_penandatangan", "-"),
            'tanggal_tanda_tangan' => $request->get("tanggal_tanda_tangan"),
            'nomor_surat' => $request->get("nomor_surat")
        ];

        if ($prodiPanitia == 1) {
            $rowsPerPage = 5;
            $totalStudents = count($jadwalSempro);
            $totalPages = ceil($totalStudents / $rowsPerPage);

            $pdf = Pdf::loadView(
                'panitia.surat.template-surat.surat-tugas-sempro.lampiran-d3',
                compact('jadwalSempro', 'rowsPerPage', 'totalPages', 'formData')
            );

            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            return $pdf->stream('lampiran_surat_tugas_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
        }

        $rowsPerPage = 8;
        $totalStudents = count($jadwalSempro);
        $totalPages = ceil($totalStudents / $rowsPerPage);

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.surat-tugas-sempro.lampiran-d4',
            compact('jadwalSempro', 'rowsPerPage', 'totalPages', 'formData')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->stream('lampiran_surat_tugas_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
    }

    public function downloadSurat(Request $request)
    {
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;
        $tahap = Tahap::find($request->tahap);
        $periodeAktif = Periode::firstWhere("aktif_sempro", 1);
        $proposalPertama = Proposal::join("jadwal_seminar_proposal", "proposal.id", "=", "jadwal_seminar_proposal.proposal_id")
            ->where('proposal.tahap_id', $tahap->id)
            ->where('proposal.periode_id', $periodeAktif->id)
            ->where('proposal.prodi_id', $prodiPanitia)
            ->orderBy('jadwal_seminar_proposal.tanggal', 'asc')
            ->first();
        $proposalTerakhir = Proposal::join("jadwal_seminar_proposal", "proposal.id", "=", "jadwal_seminar_proposal.proposal_id")
            ->where('proposal.tahap_id', $tahap->id)
            ->where('proposal.periode_id', $periodeAktif->id)
            ->where('proposal.prodi_id', $prodiPanitia)
            ->orderBy('jadwal_seminar_proposal.tanggal', 'desc')
            ->first();

        Carbon::setLocale("id");

        $tanggalMulai = Carbon::parse($proposalPertama->tanggal);
        $tanggalSelesai = Carbon::parse($proposalTerakhir->tanggal);

        $tanggalMulaiFormatted = $tanggalMulai->translatedFormat("d F Y");
        $tanggalSelesaiFormatted = $tanggalSelesai->translatedFormat("d F Y");

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'nama_penandatangan' => $request->get("nama_penandatangan", "-"),
            'nip_penandatangan' => $request->get("nip_penandatangan", "-"),
            'tanggal_tanda_tangan' => $request->get("tanggal_tanda_tangan"),
            'tahun_akademik' => $periodeAktif->tahun,
            'semester' => $request->get("semester"),
            'tanggal_mulai' => $tanggalMulaiFormatted,
            'tanggal_selesai' => $tanggalSelesaiFormatted
        ];

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.surat-tugas-sempro.undangan',
            compact('data')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->download('surat_tugas_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
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
            ->with(['proposal.proposalMahasiswas.mahasiswa', 'proposal.dosenPengujiSempro1', 'proposal.dosenPengujiSempro2'])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->orderBy('ruang', 'asc')
            ->get();

        $formData = [
            'nama_penandatangan' => $request->get("nama_penandatangan", "-"),
            'nip_penandatangan' => $request->get("nip_penandatangan", "-"),
            'tanggal_tanda_tangan' => $request->get("tanggal_tanda_tangan"),
            'nomor_surat' => $request->get("nomor_surat")
        ];

        if ($prodiPanitia == 1) {
            $rowsPerPage = 5;
            $totalStudents = count($jadwalSempro);
            $totalPages = ceil($totalStudents / $rowsPerPage);

            $pdf = Pdf::loadView(
                'panitia.surat.template-surat.surat-tugas-sempro.lampiran-d3',
                compact('jadwalSempro', 'rowsPerPage', 'totalPages', 'formData')
            );

            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            return $pdf->download('lampiran_surat_tugas_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
        }

        $rowsPerPage = 8;
        $totalStudents = count($jadwalSempro);
        $totalPages = ceil($totalStudents / $rowsPerPage);

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.surat-tugas-sempro.lampiran-d4',
            compact('jadwalSempro', 'rowsPerPage', 'totalPages', 'formData')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->download('lampiran_surat_tugas_seminar_proposal_tahap_' . $tahap->tahap . '.pdf');
    }
}
