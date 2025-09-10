<?php

namespace App\Http\Controllers;

use App\Exceptions\ImportDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminChangePasswordRequest;
use App\Jobs\ProcessMahasiswaImport;
use App\Models\Periode;
use App\Services\MahasiswaImportService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use App\Interfaces\MahasiswaControllerInterface;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class MahasiswaD3Controller extends Controller implements MahasiswaControllerInterface
{
    private Prodi $prodi;
    private MahasiswaImportService $mahasiswaImportService;
    private string $excelFilePath = "/impor-data/mahasiswa-d3/";

    public function __construct(MahasiswaImportService $mahasiswaImportService)
    {
        $this->prodi = Prodi::firstWhere("prodi", "D3 Teknik Telekomunikasi");
        $this->mahasiswaImportService = $mahasiswaImportService;
    }
    public function showMahasiswaPage(): View
    {
        $periode = Periode::all();
        return view("admin-prodi.mahasiswa-D3", ["periode" => $periode]);
    }

    public function showAllMahasiswa()
    {
        // Query Semua Data Mahasiswa D3
        $mahasiswaD3 = Mahasiswa::select("id", "periode_id", "NIM", "nama", "prodi_id", "kelas", "angkatan")
            ->with(["periode", "prodi"])
            ->where("prodi_id", $this->prodi->id)
            ->get();

        return response()->json([
            "success" => true,
            "data" => $mahasiswaD3->toJson()
        ]);
    }
    public function searchMahasiswa(Request $request)
    {
        // Query Data Mahasiswa Berdasarkan Kata Kunci
        $request->validate([
            "search" => "ascii"
        ]);

        $searchInput = $request->input("search");
        $listMahasiswa = Mahasiswa::select("id", "periode_id", "NIM", "nama", "prodi_id", "kelas", "angkatan")
            ->with(["periode", "prodi"])
            ->where("prodi_id", $this->prodi->id)
            ->where(function (Builder $query) use ($searchInput) {
                $query->whereLike("nama", "%$searchInput%")
                    ->orWhereLike("NIM", "%$searchInput%");
            })
            ->get();

        return response()->json([
            "success" => true,
            "data" => $listMahasiswa->toJson()
        ]);
    }
    public function importMahasiswa(Request $request)
    {
        // Pengecekan Hak Akses
        if ($request->user()->cannot("createMhsD3", Mahasiswa::class)) {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Admin Prodi D3 Teknik Telekomunikasi"
            ], 403);
        }

        // Validasi file yang diupload pengguna
        $validator = Validator::make($request->all(), [
            "periode" => "required|exists:periode,id",
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

        try {
            $fileExcel = $request->file("file_excel");                    // Mengambil file
            $filename = time() . "_" . $fileExcel->getClientOriginalName();    // Membuat nama file

            // Menyimpan file
            $fileExcel->storeAs(
                $this->excelFilePath,
                $filename
            );

            // Dispatch (kirim) Job ke ProcessMahasiswaImport
            ProcessMahasiswaImport::dispatch(
                $this->excelFilePath,
                $filename,
                $this->prodi->id,
                $request->periode
            );

            return response()->json([
                "success" => true,
                "message" => "Data Mahasiswa Sedang Diimpor! Refresh secara berkala untuk melihat perubahan!"
            ]);
        } catch (Exception $e) {
            // Tangkap error tak terduga lainnya
            Log::error("Import Gagal Total: " . $e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan pada server saat mengimpor file."
            ], 500);
        }
    }

    public function deleteMahasiswa(Request $request): JsonResponse
    {
        $data = $request->validate(
            [
                "mahasiswa_id" => "required|exists:mahasiswa,id"
            ]
        );

        $mahasiswaId = $data["mahasiswa_id"];
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        // Memeriksa Hak Akses Admin Prodi
        Gate::authorize("deleteMahasiswa", $mahasiswa);

        try {
            if (!$mahasiswa) {
                return response()->json([
                    "success" => false,
                    "message" => "Data Mahasiswa Tidak Ditemukan"
                ], 404);
            }

            $mahasiswa->delete();
            Log::info("Hapus Mahasiswa Berhasil: ID Mahasiswa $mahasiswaId telah dihapus.");

            return response()->json([
                "success" => true,
                "message" => "Data Mahasiswa Berhasil Dihapus"
            ]);
        } catch (Exception $e) {
            Log::error("Hapus Mahasiswa Gagal Total: " . $e->getMessage());
            return response()->json([
                "success" => false,
                "message" => "Terjadi kesalahan pada server saat menghapus data mahasiswa."
            ], 500);
        }
    }
    public function adminChangePasswordMahasiswa(AdminChangePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        $mahasiswa = Mahasiswa::find($data["mahasiswa_id"]);
        $mahasiswa->password = Hash::make($data["new_password"]);
        $savedMahasiswa = $mahasiswa->save();

        if(!$savedMahasiswa){
            return response()->json([
                "success" => false,
                "message" => "Server Gagal mengganti Password Mahasiswa!"
            ], 422);
        }

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengganti password!"
        ]);
    }
}
