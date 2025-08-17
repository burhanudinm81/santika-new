<?php

namespace App\Http\Controllers;

use App\Exceptions\ImportDataException;
use App\Http\Controllers\Controller;
use App\Interfaces\MahasiswaControllerInterface;
use App\Jobs\ProcessMahasiswaImport;
use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\Prodi;
use App\Services\MahasiswaImportService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class MahasiswaD4Controller extends Controller implements MahasiswaControllerInterface
{
    private Prodi $prodi;
    private $mahasiswaImportService;
    private string $excelFilePath = "/impor-data/mahasiswa-d4/";

    public function __construct(MahasiswaImportService $mahasiswaImportService)
    {
        $this->prodi = Prodi::firstWhere("prodi", "D4 Jaringan Telekomunikasi Digital");
        $this->mahasiswaImportService = $mahasiswaImportService;
    }

    public function showMahasiswaPage(): View
    {
        $periode = Periode::all();
        return view("admin-prodi.mahasiswa-D4", ["periode" => $periode]);
    }
    public function showAllMahasiswa()
    {
        $mahasiswaD4 = Mahasiswa::select("periode_id", "NIM", "nama", "prodi_id", "kelas", "angkatan")
            ->with(["periode", "prodi"])
            ->where("prodi_id", $this->prodi->id)
            ->get();

        return response()->json([
            "success" => true,
            "data" => $mahasiswaD4->toJson()
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
        if ($request->user()->cannot("createMhsD4", Mahasiswa::class)) {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Admin Prodi D4 Jaringan Telekomunikasi Digital"
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
}
