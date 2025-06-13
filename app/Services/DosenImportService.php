<?php

namespace App\Services;

use App\Exceptions\ImportDataException;
use App\Models\Dosen;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class DosenImportService
{
    public function import(string $filepath, string $filename)
    {
        $filePath = Storage::path($filepath . $filename);

        try {
            $reader = new Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $sheet = $spreadsheet->getSheetByName("Sheet1");
            $highestRow = $sheet->getHighestDataRow();

            // Index Kolom NIM, nama, kelas, dan angkatan
            $NIDNColumnIndex = 2;
            $NIPColumnIndex = 3;
            $namaColumnIndex = 4;

            $dataToInsert = [];
            for ($row = 3; $row <= $highestRow; $row++) {
                $nidn = $sheet->getCell([$NIDNColumnIndex, $row])->getValue();
                if (empty(trim($nidn)))
                    continue;

                $dataToInsert[] = [
                    "nama" => $sheet->getCell([$namaColumnIndex, $row])->getValue(),
                    "password" => Hash::make($nidn),
                    "NIDN" => $sheet->getCell([$NIDNColumnIndex, $row])->getValue(),
                    "NIP" => $sheet->getCell([$NIPColumnIndex, $row])->getValue()
                ];
            }

            // Gunakan DB::transaction untuk memastikan atomicity (All or Nothing)
            DB::transaction(function () use ($dataToInsert) {
                if (empty($dataToInsert)) {
                    throw new ImportDataException("File Excel tidak berisi data untuk diimpor.");
                }

                // Semua data ini akan di-commit bersamaan, atau di-rollback bersamaan jika gagal.
                Dosen::insert($dataToInsert);
            });

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                preg_match("/Duplicate entry '(.*?)' for key/", $e->getMessage(), $matches);
                $duplicateNIDN = $matches[1] ?? 'tidak diketahui';
                Log::error("Impor Gagal. Data duplikat ditemukan dengan NIDN: " . $duplicateNIDN);
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