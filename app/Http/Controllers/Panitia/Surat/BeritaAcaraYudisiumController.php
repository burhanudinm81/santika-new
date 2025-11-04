<?php

namespace App\Http\Controllers\Panitia\Surat;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeminarHasil;
use App\Models\NilaiAkhirMahasiswa;
use App\Models\Panitia;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\Tahap;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BeritaAcaraYudisiumController extends Controller
{
    public function create(): View
    {
        $daftarTahap = Tahap::all();
        return view(
            "panitia.surat.tampilan-web.berita-acara-yudisium.create",
            compact('daftarTahap')
        );
    }

    public function previewPage(Request $request): View|RedirectResponse
    {
        $request->validate([
            'nomor_surat' => 'required|string',
            'tahap' => 'required|exists:tahap,id',
            'semester' => ['required', Rule::in(["Ganjil", "Genap"])],
            'tanggal_tanda_tangan' => 'required|date',
            'tanggal_yudisium' => 'required|date',
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
        $periodeAktif = Periode::firstWhere("aktif_sidang_akhir", 1);
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;

        $daftarNilaiAkhir = NilaiAkhirMahasiswa::whereHas("proposal", function ($query) use ($tahap, $periodeAktif, $prodiPanitia) {
            $query->where('tahap_semhas_id', $tahap->id)
                ->where('periode_semhas_id', $periodeAktif->id)
                ->where('prodi_id', $prodiPanitia)
                ->whereNotNull('status_semhas_penguji_1_id')
                ->whereNotNull('status_semhas_penguji_2_id')
                ->whereNotNull('status_semhas_dosbing_1_id')
                ->whereNotNull('status_semhas_dosbing_2_id');
        })
            ->with("proposal", "mahasiswa")
            ->get();

        if (is_null($daftarNilaiAkhir)) {
            return back()
                ->withErrors([
                    "message" => "Jadwal Sidang Tugas Akhir untuk tahap {$tahap->tahap} periode {$periodeAktif->tahun} tidak ditemukan"
                ]);
        }

        $tanggalTandaTangan = Carbon::parse($request->get("tanggal_tanda_tangan"));
        $tanggalTtdFormatted = $tanggalTandaTangan->translatedFormat("d F Y");

        $tanggalYudisium = Carbon::parse($request->get("tanggal_yudisium"));
        $tanggalYudisiumFormatted = $tanggalYudisium->translatedFormat("l, d F Y");

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'tahap' => $tahap,
            'nama_penandatangan' => $namaPenandatangan,
            'nip_penandatangan' => $nipPenandatangan,
            'tanggal_tanda_tangan' => $tanggalTtdFormatted,
            'tanggal_yudisium' => $tanggalYudisiumFormatted,
            'periode' => $periodeAktif,
            'semester' => $request->semester
        ];

        return view('panitia.surat.tampilan-web.berita-acara-yudisium.preview', compact('data'));
    }

    public function previewSurat(Request $request): Response|RedirectResponse
    {
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;
        $tahap = Tahap::find($request->tahap);
        $periodeAktif = Periode::firstWhere("aktif_sidang_akhir", 1);

        $daftarNilaiAkhir = NilaiAkhirMahasiswa::whereHas("proposal", function ($query) use ($tahap, $periodeAktif, $prodiPanitia) {
            $query->where('tahap_semhas_id', $tahap->id)
                ->where('periode_semhas_id', $periodeAktif->id)
                ->where('prodi_id', $prodiPanitia)
                ->whereNotNull('status_semhas_penguji_1_id')
                ->whereNotNull('status_semhas_penguji_2_id')
                ->whereNotNull('status_semhas_dosbing_1_id')
                ->whereNotNull('status_semhas_dosbing_2_id');
        })
            ->with("proposal", "mahasiswa")
            ->get();

        $rowsPerPage = 9;
        $totalStudents = $daftarNilaiAkhir->count();
        $totalPages = $totalStudents > 0 ? ceil($totalStudents / $rowsPerPage) : 0;

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'jumlah_lampiran' => $totalPages,
            'nama_penandatangan' => $request->get("nama_penandatangan", "-"),
            'nip_penandatangan' => $request->get("nip_penandatangan", "-"),
            'tanggal_tanda_tangan' => $request->get("tanggal_tanda_tangan"),
            'tahun_akademik' => $periodeAktif->tahun,
            'tahap' => $tahap->tahap,
            'semester' => $request->get("semester"),
        ];

        if ($prodiPanitia == 1) {
            // Jika Prodi Panitia D3
            $pdf = Pdf::loadView(
                'panitia.surat.template-surat.berita-acara-yudisium.undangan-d3',
                compact('data')
            );

            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            return $pdf->stream('berita_acara_yudisium_tahap_' . $tahap->tahap . '.pdf');
        }

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.berita-acara-yudisium.undangan-d4',
            compact('data')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->stream('berita_acara_yudisium_tahap_' . $tahap->tahap . '.pdf');
    }

    public function previewLampiran(Request $request): Response
    {
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;
        $tahap = Tahap::find($request->tahap);
        $periodeAktif = Periode::firstWhere("aktif_sidang_akhir", 1);

        $daftarNilaiAkhir = NilaiAkhirMahasiswa::whereHas("proposal", function ($query) use ($tahap, $periodeAktif, $prodiPanitia) {
            $query->where('tahap_semhas_id', $tahap->id)
                ->where('periode_semhas_id', $periodeAktif->id)
                ->where('prodi_id', $prodiPanitia)
                ->whereNotNull('status_semhas_penguji_1_id')
                ->whereNotNull('status_semhas_penguji_2_id')
                ->whereNotNull('status_semhas_dosbing_1_id')
                ->whereNotNull('status_semhas_dosbing_2_id');
        })
            ->with("proposal", "mahasiswa")
            ->get();

        $daftarNilaiAkhir->map(function ($item) {
            $nilaiHuruf = null;
            $statusKelulusan = null;

            $nilaiTotalPenguji = $item->avg_nilai_totalPenguji;
            $nilaiTotalPembimbing = $item->avg_nilai_totalDospem;
            $nilaiTotalKeseluruhan = ($nilaiTotalPenguji * 40 / 100) + ($nilaiTotalPembimbing * 60 / 100);

            if ($nilaiTotalKeseluruhan >= 80)
                $nilaiHuruf = "A";
            elseif ($nilaiTotalKeseluruhan >= 75)
                $nilaiHuruf = "B+";
            elseif ($nilaiTotalKeseluruhan >= 65)
                $nilaiHuruf = "B";
            elseif ($nilaiTotalKeseluruhan >= 55)
                $nilaiHuruf = "C+";
            elseif ($nilaiTotalKeseluruhan >= 50)
                $nilaiHuruf = "D";
            else
                $nilaiHuruf = "E";

            if ($nilaiTotalKeseluruhan >= 66)
                $statusKelulusan = "LULUS";
            else
                $statusKelulusan = "TIDAK LULUS";

            // Pengecekan Terhadap nilai Pembimbing 1
            if ($item->nilai_sikap_pemb1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_kemampuan_pemb1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_hasilKarya_pemb1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_laporan_pemb1 < 66)
                $statusKelulusan = "TIDAK LULUS";

            // Pengecekan Terhadap nilai Pembimbing 2
            if ($item->nilai_sikap_pemb2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_kemampuan_pemb2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_hasilKarya_pemb2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_laporan_pemb2 < 66)
                $statusKelulusan = "TIDAK LULUS";

            // Pengecekan Terhadap nilai Penguji 1
            if ($item->nilai_penguasaan_materi1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_presentasi1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_karya_tulis1 < 66)
                $statusKelulusan = "TIDAK LULUS";

            // Pengecekan Terhadap nilai Penguji 2
            if ($item->nilai_penguasaan_materi2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_presentasi2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_karya_tulis2 < 66)
                $statusKelulusan = "TIDAK LULUS";


            $item->nilaiAngka = number_format($nilaiTotalKeseluruhan, 2, ",", ".");
            $item->nilaiHuruf = $nilaiHuruf;
            $item->statusKelulusan = $statusKelulusan;

            return $item;
        });

        $formData = [
            'tanggal_pelaksanaan_yudisium' => $request->get("tanggal_yudisium", "-"),
            'nama_penandatangan' => $request->get("nama_penandatangan", "-"),
            'nip_penandatangan' => $request->get("nip_penandatangan", "-"),
            'tanggal_tanda_tangan' => $request->get("tanggal_tanda_tangan", "-"),
        ];

        $rowsPerPage = 9;
        $totalStudents = $daftarNilaiAkhir->count();
        $totalPages = $totalStudents > 0 ? ceil($totalStudents / $rowsPerPage) : 1;

        $pdf = Pdf::loadView(
            "panitia.surat.template-surat.berita-acara-yudisium.lampiran",
            compact("formData", "daftarNilaiAkhir", 'rowsPerPage')
        );

        $pdf->setOptions([
            "isHtml5ParserEnabled" => true,
            "isRemoteEnabled" => true
        ]);

        return $pdf->stream('lampiran_berita_acara_yudisium_tahap_' . $tahap->tahap . '.pdf');
    }

    public function downloadSurat(Request $request): Response
    {
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;
        $tahap = Tahap::find($request->tahap);
        $periodeAktif = Periode::firstWhere("aktif_sidang_akhir", 1);

        $daftarNilaiAkhir = NilaiAkhirMahasiswa::whereHas("proposal", function ($query) use ($tahap, $periodeAktif, $prodiPanitia) {
            $query->where('tahap_semhas_id', $tahap->id)
                ->where('periode_semhas_id', $periodeAktif->id)
                ->where('prodi_id', $prodiPanitia)
                ->whereNotNull('status_semhas_penguji_1_id')
                ->whereNotNull('status_semhas_penguji_2_id')
                ->whereNotNull('status_semhas_dosbing_1_id')
                ->whereNotNull('status_semhas_dosbing_2_id');
        })
            ->with("proposal", "mahasiswa")
            ->get();

        $rowsPerPage = 9;
        $totalStudents = $daftarNilaiAkhir->count();
        $totalPages = $totalStudents > 0 ? ceil($totalStudents / $rowsPerPage) : 0;

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'jumlah_lampiran' => $totalPages,
            'nama_penandatangan' => $request->get("nama_penandatangan", "-"),
            'nip_penandatangan' => $request->get("nip_penandatangan", "-"),
            'tanggal_tanda_tangan' => $request->get("tanggal_tanda_tangan"),
            'tahun_akademik' => $periodeAktif->tahun,
            'tahap' => $tahap->tahap,
            'semester' => $request->get("semester"),
        ];

        if ($prodiPanitia == 1) {
            // Jika Prodi Panitia D3
            $pdf = Pdf::loadView(
                'panitia.surat.template-surat.berita-acara-yudisium.undangan-d3',
                compact('data')
            );

            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            return $pdf->stream('berita_acara_yudisium_tahap_' . $tahap->tahap . '.pdf');
        }

        $pdf = Pdf::loadView(
            'panitia.surat.template-surat.berita-acara-yudisium.undangan-d4',
            compact('data')
        );

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        return $pdf->download('berita_acara_yudisium_tahap_' . $tahap->tahap . '.pdf');
    }

    public function downloadLampiran(Request $request): Response
    {
        $prodiPanitia = Panitia::firstWhere("dosen_id", auth("dosen")->id())->prodi_id;
        $tahap = Tahap::find($request->tahap);
        $periodeAktif = Periode::firstWhere("aktif_sidang_akhir", 1);

        $daftarNilaiAkhir = NilaiAkhirMahasiswa::whereHas("proposal", function ($query) use ($tahap, $periodeAktif, $prodiPanitia) {
            $query->where('tahap_semhas_id', $tahap->id)
                ->where('periode_semhas_id', $periodeAktif->id)
                ->where('prodi_id', $prodiPanitia)
                ->whereNotNull('status_semhas_penguji_1_id')
                ->whereNotNull('status_semhas_penguji_2_id')
                ->whereNotNull('status_semhas_dosbing_1_id')
                ->whereNotNull('status_semhas_dosbing_2_id');
        })
            ->with("proposal", "mahasiswa")
            ->get();

        $daftarNilaiAkhir->map(function ($item) {
            $nilaiHuruf = null;
            $statusKelulusan = null;

            $nilaiTotalPenguji = $item->avg_nilai_totalPenguji;
            $nilaiTotalPembimbing = $item->avg_nilai_totalDospem;
            $nilaiTotalKeseluruhan = ($nilaiTotalPenguji * 40 / 100) + ($nilaiTotalPembimbing * 60 / 100);

            if ($nilaiTotalKeseluruhan >= 80)
                $nilaiHuruf = "A";
            elseif ($nilaiTotalKeseluruhan >= 75)
                $nilaiHuruf = "B+";
            elseif ($nilaiTotalKeseluruhan >= 65)
                $nilaiHuruf = "B";
            elseif ($nilaiTotalKeseluruhan >= 55)
                $nilaiHuruf = "C+";
            elseif ($nilaiTotalKeseluruhan >= 50)
                $nilaiHuruf = "D";
            else
                $nilaiHuruf = "E";

            if ($nilaiTotalKeseluruhan >= 66)
                $statusKelulusan = "LULUS";
            else
                $statusKelulusan = "TIDAK LULUS";

            // Pengecekan Terhadap nilai Pembimbing 1
            if ($item->nilai_sikap_pemb1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_kemampuan_pemb1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_hasilKarya_pemb1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_laporan_pemb1 < 66)
                $statusKelulusan = "TIDAK LULUS";

            // Pengecekan Terhadap nilai Pembimbing 2
            if ($item->nilai_sikap_pemb2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_kemampuan_pemb2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_hasilKarya_pemb2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_laporan_pemb2 < 66)
                $statusKelulusan = "TIDAK LULUS";

            // Pengecekan Terhadap nilai Penguji 1
            if ($item->nilai_penguasaan_materi1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_presentasi1 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_karya_tulis1 < 66)
                $statusKelulusan = "TIDAK LULUS";

            // Pengecekan Terhadap nilai Penguji 2
            if ($item->nilai_penguasaan_materi2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_presentasi2 < 66)
                $statusKelulusan = "TIDAK LULUS";
            if ($item->nilai_karya_tulis2 < 66)
                $statusKelulusan = "TIDAK LULUS";


            $item->nilaiAngka = number_format($nilaiTotalKeseluruhan, 2, ",", ".");
            $item->nilaiHuruf = $nilaiHuruf;
            $item->statusKelulusan = $statusKelulusan;

            return $item;
        });

        $formData = [
            'tanggal_pelaksanaan_yudisium' => $request->get("tanggal_yudisium", "-"),
            'nama_penandatangan' => $request->get("nama_penandatangan", "-"),
            'nip_penandatangan' => $request->get("nip_penandatangan", "-"),
            'tanggal_tanda_tangan' => $request->get("tanggal_tanda_tangan", "-"),
        ];

        $rowsPerPage = 9;
        $totalStudents = $daftarNilaiAkhir->count();
        $totalPages = $totalStudents > 0 ? ceil($totalStudents / $rowsPerPage) : 1;

        $pdf = Pdf::loadView(
            "panitia.surat.template-surat.berita-acara-yudisium.lampiran",
            compact("formData", "daftarNilaiAkhir", 'rowsPerPage')
        );

        $pdf->setOptions([
            "isHtml5ParserEnabled" => true,
            "isRemoteEnabled" => true
        ]);

        return $pdf->download('lampiran_berita_acara_yudisium_tahap_' . $tahap->tahap . '.pdf');
    }
}
