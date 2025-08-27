<?php

namespace App\Services;

use App\Exceptions\ImportDataException;
use App\Models\Dosen;
use App\Models\KuotaDosen;
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

            // Index Kolom NIDN, NIP, dan nama
            $NIDNColumnIndex = 2;
            $NIPColumnIndex = 3;
            $namaColumnIndex = 4;

            $dataDosenToInsert = [];
            for ($row = 3; $row <= $highestRow; $row++) {
                $nidn = $sheet->getCell([$NIDNColumnIndex, $row])->getValue();
                if (empty(trim($nidn)))
                    continue;

                $dataDosenToInsert[] = [
                    "nama" => $sheet->getCell([$namaColumnIndex, $row])->getValue(),
                    "password" => Hash::make($nidn),
                    "NIDN" => (string) $sheet->getCell([$NIDNColumnIndex, $row])->getValue(),
                    "NIP" => (string) $sheet->getCell([$NIPColumnIndex, $row])->getValue()
                ];
            }

            // Gunakan DB::transaction untuk memastikan atomicity (All or Nothing)
            DB::transaction(function () use ($dataDosenToInsert) {
                if (empty($dataDosenToInsert)) {
                    throw new ImportDataException("File Excel tidak berisi data untuk diimpor.");
                }

                // Semua data ini akan di-commit bersamaan, atau di-rollback bersamaan jika gagal.
                Dosen::insert($dataDosenToInsert);

                // ------- Membuat Data Kuota Dosen -------------
                // 1. Ambil kembali dosen yang baru saja dibuat untuk mendapatkan ID mereka.
                // ambil NIDN dari data yang sudah kita siapkan.
                $insertedNidns = array_column($dataDosenToInsert, 'NIDN');
                $newDosens = Dosen::whereIn('NIDN', $insertedNidns)->get();

                // 2. Siapkan data untuk tabel kuota_dosen
                $dataKuotaToInsert = [];
                foreach ($newDosens as $dosen) {
                    $dataKuotaToInsert[] = [
                        'dosen_id' => $dosen->id,
                        'kuota_pembimbing_1_D3' => 5,
                        'kuota_pembimbing_2_D3' => 8,
                        'kuota_penguji_sempro_1_D3' => 8,
                        'kuota_penguji_sempro_2_D3' => 8,
                        'kuota_penguji_sidang_TA_1_D3' => 8,
                        'kuota_penguji_sidang_TA_2_D3' => 8,
                        'kuota_pembimbing_1_D4' => 5,
                        'kuota_pembimbing_2_D4' => 8,
                        'kuota_penguji_sempro_1_D4' => 8,
                        'kuota_penguji_sempro_2_D4' => 8,
                        'kuota_penguji_sidang_TA_1_D4' => 8,
                        'kuota_penguji_sidang_TA_2_D4' => 8
                    ];
                }

                // Langkah 4: Masukkan semua data kuota dosen ke database
                if (!empty($dataKuotaToInsert)) {
                    KuotaDosen::insert($dataKuotaToInsert);
                }
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