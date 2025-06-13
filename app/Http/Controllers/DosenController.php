<?php

namespace App\Http\Controllers;

use App\Exceptions\ImportDataException;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Services\DosenImportService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DosenController extends Controller
{
    private string $excelFilePath = "/impor-data/dosen/";
    private DosenImportService $dosenImportService;

    public function __construct(DosenImportService $dosenImportService) {
        $this->dosenImportService = $dosenImportService;
    }

    public function showDataDosenPage(): View
    {
        return view("admin-prodi.data-dosen");
    }

    public function showAllDataDosen(): JsonResponse
    {
        $dosen = Dosen::select("NIDN", "NIP", "nama")->get();

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

        $dosen = Dosen::select("NIDN", "NIP", "nama")
            ->where(function (Builder $query) use ($searchInput) {
                $query->whereLike("nama", "%$searchInput%")
                    ->orWhereLike("NIDN", "%$searchInput%")
                    ->orWhereLike("NIP", "%$searchInput%");
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
}
