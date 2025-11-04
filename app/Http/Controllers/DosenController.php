<?php

namespace App\Http\Controllers;

use App\Exceptions\ImportDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminChangePasswordRequest;
use App\Jobs\ProcessDosenImport;
use App\Models\Dosen;
use App\Models\BidangMinat;
use App\Services\DosenImportService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DosenController extends Controller
{
    private string $excelFilePath = "/impor-data/dosen/";
    private DosenImportService $dosenImportService;

    public function __construct(DosenImportService $dosenImportService)
    {
        $this->dosenImportService = $dosenImportService;
    }

    public function showDataDosenPage(): View
    {
        return view("admin-prodi.data-dosen");
    }

    public function showAllDataDosen(): JsonResponse
    {
        $dosen = Dosen::select("id", "nidn as NIDN", "nip as NIP", "nama")->get();


        return response()->json([
            "success" => true,
            "data" => $dosen->toJson()
        ]);
    }

    public function searchDataDosen(Request $request): JsonResponse
    {
        $request->validate([
            "search" => "ascii"
        ]);

        $searchInput = $request->input("search");

        $dosen = Dosen::select("id", "nidn as NIDN", "nip as NIP", "nama")
            ->where(function (Builder $query) use ($searchInput) {
                $query->whereLike("nama", "%$searchInput%")
                    ->orWhereLike("nidn", "%$searchInput%")
                    ->orWhereLike("nip", "%$searchInput%");
            })
            ->get();

        return response()->json([
            "success" => true,
            "data" => $dosen->toJson()
        ]);
    }

    public function importDosen(Request $request)
    {
        // Validasi file yang diupload pengguna
        $validator = Validator::make($request->all(), [
            "file_excel" => "required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
        ]);

        // Jika validasi gagal kembalikan respon error
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "File yang anda masukkan bukan file spreadsheet (.xlsx)",
                "errors" => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $fileExcel = $request->file("file_excel");             // Mengambil file
        $filename = time() . "_" . $fileExcel->getClientOriginalName();    // Membuat nama file

        // Menyimpan file
        $fileExcel->storeAs(
            $this->excelFilePath,
            $filename
        );

        try {
            $nidnList = $this->dosenImportService->getNidnList(
                $this->excelFilePath,
                $filename
            );

            if ($nidnList) {
                $nidnDuplikat = Dosen::whereIn('nidn', $nidnList)->pluck("nidn");

                if ($nidnDuplikat->isNotEmpty()) {
                    $nidnDuplikatStr = $nidnDuplikat->implode(", ");

                    return response()->json([
                        "success" => false,
                        "message" => "Tidak dapat mengimpor data! Terdapat NIDN Duplikat: $nidnDuplikatStr"
                    ], 422);
                }
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Data NIDN tidak ditemukan."
                ], 422);
            }
        } catch (Exception $e) {
            // Tangkap error tak terduga lainnya
            Log::error("Gagal Membaca NIDN di File Excel: " . $e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan server saat mengimpor file."
            ], 500);
        }

        try {
            // Panggil mahasiswaImportService
            $this->dosenImportService->import(
                $this->excelFilePath,
                $filename
            );

            return response()->json([
                "success" => true,
                "message" => "Data Dosen berhasil diimpor!"
            ]);
        } catch (ImportDataException $e) {
            // Tangkap error spesifik dari dosenImportService
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 422); // 422 Unprocessable Entity

        } catch (Exception $e) {
            // Tangkap error tak terduga lainnya
            Log::error("Import Gagal Total: " . $e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan server saat mengimpor file."
            ], 500);
        }
    }

    public function daftarDosen(Request $request)
    {
        $bidangMinatId = $request->query('bidang_minat');

        $dosenQuery = Dosen::query();

        if ($bidangMinatId) {
            $dosenQuery->whereHas('bidangMinats', function ($query) use ($bidangMinatId) {
                $query->where('bidang_minat.id', $bidangMinatId);
            })->with([
                        'bidangMinats' => function ($query) use ($bidangMinatId) {
                            $query->where('bidang_minat.id', $bidangMinatId);
                        }
                    ]);
        } else {
            $dosenQuery->with('bidangMinats');
        }

        $dosen = $dosenQuery->paginate(10)->withQueryString();
        $bidangMinatList = BidangMinat::all();

        return view(
            'mahasiswa.informasi-dosen.daftar-dosen',
            compact('dosen', 'bidangMinatList', 'bidangMinatId')
        );
    }

    public function profilDosen($id)
    {
        $dosen = Dosen::with(['bidangMinats', 'kuotaDosen'])->find($id);
        $userProdi = data_get(auth('mahasiswa')->user(), 'prodi.prodi');

        return view('mahasiswa.informasi-dosen.profil-dosen', compact('dosen', 'userProdi'));
    }

    public function deleteDosen(Request $request): JsonResponse
    {
        $request->validate(
            [
                "dosen_id" => "required|exists:dosen,id|unique:panitia,dosen_id"
            ],
            [
                "dosen_id.unique" => "Dosen masih berstatus sebagai panitia, tidak dapat dihapus!"
            ]
        );

        $dosenId = $request->input("dosen_id");

        try {
            $dosen = Dosen::find($dosenId);

            if (!$dosen) {
                return response()->json([
                    "success" => false,
                    "message" => "Data Dosen Tidak Ditemukan"
                ], 404);
            }

            $dosen->delete();
            Log::info("Hapus Dosen Berhasil: ID Dosen $dosenId telah dihapus.");

            return response()->json([
                "success" => true,
                "message" => "Data Dosen Berhasil Dihapus"
            ]);
        } catch (Exception $e) {
            Log::error("Hapus Dosen Gagal Total: " . $e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan pada server saat menghapus data dosen."
            ], 500);
        }
    }

    public function adminChangePasswordDosen(AdminChangePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        $dosen = Dosen::find($data["dosen_id"]);
        $dosen->password = Hash::make($data["new_password"]);
        $savedDosen = $dosen->save();

        if (!$savedDosen) {
            return response()->json([
                "success" => false,
                "message" => "Server Gagal mengganti Password Dosen!"
            ], 422);
        }

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengganti password!"
        ]);
    }
}
