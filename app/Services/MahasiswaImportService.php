<?php

namespace App\Services;

use App\Exceptions\ImportDataException;
use App\Models\Mahasiswa;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class MahasiswaImportService
{
    public function import(string $filepath, string $filename, int $prodi_id, int $periode_id)
    {
        $filePath = Storage::path($filepath . $filename);

        try {
            $reader = new Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $sheet = $spreadsheet->getSheetByName("Sheet1");
            $highestRow = $sheet->getHighestDataRow();

            // Index Kolom NIM, nama, kelas, dan angkatan
            $NIMColumnIndex = 2;
            $namaColumnIndex = 3;
            $kelasColumnIndex = 4;
            $angkatanColumnIndex = 5;

            $dataToInsert = [];
            for ($row = 3; $row <= $highestRow; $row++) {
                $nim = (string) $sheet->getCell([$NIMColumnIndex, $row])->getValue();
                Log::info("NIM: $nim");
                
                if (empty(trim($nim)))
                    continue;

                $dataToInsert[] = [
                    "NIM" => $nim,
                    "nama" => $sheet->getCell([$namaColumnIndex, $row])->getValue(),
                    "password" => Hash::make($nim),
                    "prodi_id" => $prodi_id,
                    "periode_id" => $periode_id,
                    "kelas" => $sheet->getCell([$kelasColumnIndex, $row])->getValue(),
                    "angkatan" => $sheet->getCell([ $angkatanColumnIndex, $row])->getValue()
                ];
            }

            // Gunakan DB::transaction untuk memastikan atomicity (All or Nothing)
            DB::transaction(function () use ($dataToInsert) {
                if (empty($dataToInsert)) {
                    throw new ImportDataException("File Excel tidak berisi data untuk diimpor.");
                }

                // Semua data ini akan di-commit bersamaan, atau di-rollback bersamaan jika gagal.
                Mahasiswa::insert($dataToInsert);
            });

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                preg_match("/Duplicate entry '(.*?)' for key/", $e->getMessage(), $matches);
                $duplicateNIM = $matches[1] ?? 'tidak diketahui';
                Log::error("Impor Gagal. Data duplikat ditemukan dengan NIM: " . $duplicateNIM);
                throw new ImportDataException("Impor Gagal. Terdapat data duplikat!");
            }
            Log::error("Impor Gagal. Terjadi error database: " . $e->getMessage());
            throw new ImportDataException("Impor Gagal. Terjadi error database!");
        } catch (\Exception $e) {
            Log::error("Impor Gagal. Gagal memproses file: " . $e->getMessage());
            throw new ImportDataException("Impor Gagal. Gagal memproses file!");
        }
    }
}