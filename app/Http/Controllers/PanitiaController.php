<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminProdi;
use App\Models\Dosen;
use App\Models\JabatanPanitia;
use App\Models\Panitia;
use App\Models\Prodi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PanitiaController extends Controller
{
    private array $panitiaValidationRules = [
        'panitia_dosen' => ['required', 'array', 'size:4'],
        'panitia_dosen.*' => ['required', 'distinct', 'exists:dosen,id']
    ];

    private array $panitiaValidationMessages = [
        'panitia_dosen.*.distinct' => 'Dosen yang sama tidak boleh dipilih untuk jabatan berbeda.',
        'panitia_dosen.*.exists' => 'Dosen yang dipilih tidak valid.',
        'panitia_dosen.size' => 'Semua jabatan panitia wajib diisi.',
    ];
    public function showPanitia(): View
    {
        // Ambil semua data panitia dengan relasinya
        $semuaPanitia = Panitia::with(['dosen', 'prodi', 'jabatanPanitia'])->get();

        // Ambil semua jabatan panitia dari database
        $semuaJabatan = JabatanPanitia::all();

        // Kelompokkan panitia berdasarkan prodi_id
        $panitiaPerProdi = $semuaPanitia->groupBy('prodi_id');

        // Mengambil Data Prodi
        $prodi = Prodi::all();
        $prodiD3 = $prodi->firstWhere("prodi", "D3 Teknik Telekomunikasi");
        $prodiD4 = $prodi->firstWhere("prodi", "D4 Jaringan Telekomunikasi Digital");

        // Menyiapkan data untuk panitia D3 dan D4
        $panitiaD3Collection = $panitiaPerProdi->get($prodiD3->id, collect()); // Jika tidak ada, kembalikan collection kosong
        $panitiaD4Collection = $panitiaPerProdi->get($prodiD4->id, collect());

        // Buat variabel boolean untuk mengecek apakah panitia kosong
        $panitiaD3Kosong = $panitiaD3Collection->isEmpty();
        $panitiaD4Kosong = $panitiaD4Collection->isEmpty();

        // Ubah data menjadi format yang mudah diakses di Blade: [Nama Jabatan => Nama Dosen]
        $panitiaD3 = $panitiaD3Collection->mapWithKeys(function ($item) {
            return [$item->jabatanPanitia->jabatan => $item->dosen->nama];
        });

        $panitiaD4 = $panitiaD4Collection->mapWithKeys(function ($item) {
            return [$item->jabatanPanitia->jabatan => $item->dosen->nama];
        });

        // Kirim semua data yang sudah disiapkan ke view
        return view('admin-prodi.panitia-tugas-akhir.list-panitia', [
            'semuaJabatan' => $semuaJabatan,
            'panitiaD3' => $panitiaD3,
            'panitiaD4' => $panitiaD4,
            'panitiaD3Kosong' => $panitiaD3Kosong,
            'panitiaD4Kosong' => $panitiaD4Kosong,
            "prodiD3Id" => $prodiD3->id,
            "prodiD4Id" => $prodiD4->id,
        ]);
    }

    public function createPanitia(Prodi $prodi): View
    {
        $dosen = Dosen::select(["id", "nama"])->get();
        $jabatanPanitia = JabatanPanitia::all();

        return view("admin-prodi.panitia-tugas-akhir.tambah-panitia", [
            "dosen" => $dosen,
            "jabatanPanitia" => $jabatanPanitia,
            "prodi" => $prodi
        ]);
    }

    public function store(Request $request, Prodi $prodi): JsonResponse
    {
        // Pengecekan Hak Akses
        if ($request->user()->cannot("createPanitia", $prodi)) {
            return response()->json([
                "success" => false,
                "message" => ["Anda bukan merupakan Admin " . $prodi->prodi]
            ], 403);
        }

        // Validasi Input
        $validator = Validator::make(
            $request->all(),
            $this->panitiaValidationRules,
            $this->panitiaValidationMessages
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validasi gagal",
                "errors" => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $prodiAdmin = AdminProdi::find(auth('admin-prodi')->id())->prodi_id;
        $listIdDosen = $data['panitia_dosen'];

        // Cek apakah panitia yang dipilih sudah terpilih sebagai panitia di prodi lainnya
        if ($prodiAdmin == 1) {
            $duplicatedDosenId = Panitia::where('prodi_id', 2)
                ->whereIn('dosen_id', $listIdDosen)
                ->pluck('dosen_id');
        } else if ($prodiAdmin == 2) {
            $duplicatedDosenId = Panitia::where('prodi_id', 1)
                ->whereIn('dosen_id', $listIdDosen)
                ->pluck('dosen_id');
        }

        $dosenCount = count($duplicatedDosenId);

        if ($dosenCount > 0) {
            $duplicatedDosenName = Dosen::whereIn("id", $duplicatedDosenId)->pluck('nama');
            $errorMessage = "";

            $namaDosen = $dosenCount > 1 
                ? $duplicatedDosenName->join(', ', ' dan ')
                : $duplicatedDosenName[0];

            if ($prodiAdmin == 1) {
                $errorMessage = $namaDosen . " sudah terpilih menjadi Panitia di Prodi D4 JTD";
            } else if ($prodiAdmin == 2) {
                $errorMessage = $namaDosen . " sudah terpilih menjadi Panitia di Prodi D3 JTD";
            }

            return response()->json([
                "success" => false,
                "message" => $errorMessage
            ], 422);
        }

        // Panggil method untuk menyimpan, sekarang dengan data yang benar
        $this->createOrUpdatePanitia($data['panitia_dosen'], $prodi->id);

        return response()->json([
            "success" => true,
            "message" => "Berhasil menambahkan Panitia Tugas Akhir untuk " . $prodi->prodi
        ], 201);
    }

    public function edit(Request $request, Prodi $prodi): View|JsonResponse
    {
        // Otorisasi, pastikan user bisa mengedit
        if ($request->user()->cannot("editPanitia", $prodi)) {
            return response()->json([
                "success" => false,
                "message" => ["Anda bukan merupakan Admin " . $prodi->prodi]
            ], 403);
        }

        // Ambil data panitia yang ada untuk prodi ini
        $panitiaTersimpan = Panitia::where('prodi_id', $prodi->id)->get();

        // Buat array [jabatan_id => dosen_id] dari data yang ada
        $panitiaMap = $panitiaTersimpan->mapWithKeys(function ($item) {
            return [$item->jabatan_panitia_id => $item->dosen_id];
        });

        return view('admin-prodi.panitia-tugas-akhir.edit-panitia', [
            'prodi' => $prodi,
            'dosen' => Dosen::orderBy('nama')->get(),
            'jabatanPanitia' => JabatanPanitia::all(),
            'panitiaMap' => $panitiaMap,
        ]);
    }

    public function update(Request $request, Prodi $prodi): JsonResponse
    {
        // Pengecekan Hak Akses
        if ($request->user()->cannot("createPanitia", $prodi)) {
            return response()->json([
                "success" => false,
                "message" => ["Anda bukan merupakan Admin " . $prodi->prodi]
            ], 403);
        }

        // Validasi Input
        $validator = Validator::make(
            $request->all(),
            $this->panitiaValidationRules,
            $this->panitiaValidationMessages
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validasi gagal",
                "errors" => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $prodiAdmin = AdminProdi::find(auth('admin-prodi')->id())->prodi_id;
        $listIdDosen = $data['panitia_dosen'];

        // Cek apakah panitia yang dipilih sudah terpilih sebagai panitia di prodi lainnya
        if ($prodiAdmin == 1) {
            $duplicatedDosenId = Panitia::where('prodi_id', 2)
                ->whereIn('dosen_id', $listIdDosen)
                ->pluck('dosen_id');
        } else if ($prodiAdmin == 2) {
            $duplicatedDosenId = Panitia::where('prodi_id', 1)
                ->whereIn('dosen_id', $listIdDosen)
                ->pluck('dosen_id');
        }

        $dosenCount = count($duplicatedDosenId);

        if ($dosenCount > 0) {
            $duplicatedDosenName = Dosen::whereIn("id", $duplicatedDosenId)->pluck('nama');
            $errorMessage = "";

            $namaDosen = $dosenCount > 1 
                ? $duplicatedDosenName->join(', ', ' dan ')
                : $duplicatedDosenName[0];

            if ($prodiAdmin == 1) {
                $errorMessage = $namaDosen . " sudah terpilih menjadi Panitia di Prodi D4 JTD";
            } else if ($prodiAdmin == 2) {
                $errorMessage = $namaDosen . " sudah terpilih menjadi Panitia di Prodi D3 JTD";
            }

            return response()->json([
                "success" => false,
                "message" => $errorMessage
            ], 422);
        }

        $this->createOrUpdatePanitia($data['panitia_dosen'], $prodi->id);

        return response()->json([
            "success" => true,
            "message" => "Berhasil memperbarui Panitia TA untuk " . $prodi->prodi
        ]);
    }

    private function createOrUpdatePanitia(array $panitiaData, int $prodiId): void
    {
        DB::transaction(function () use ($panitiaData, $prodiId) {
            // Hapus semua panitia lama untuk prodi ini
            Panitia::where('prodi_id', $prodiId)->delete();

            // Menyiapkan data baru untuk dimasukkan
            $dataToInsert = [];
            foreach ($panitiaData as $jabatanId => $dosenId) {
                $dataToInsert[] = [
                    'dosen_id' => $dosenId,
                    'jabatan_panitia_id' => $jabatanId,
                    'prodi_id' => $prodiId
                ];
            }

            // Memasukkan data panitia yang baru
            Panitia::insert($dataToInsert);
        });
    }
}
