<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KuotaDosen;
use App\Models\Proposal;
use App\Services\SemproSchedulerService;
use Illuminate\Http\Request;

class PengujianPenjadwalanAG extends Controller
{
    public function pengujianHyperTuningParameter(){
        // Data input tetap
        // 30 Proposal
        $proposals = Proposal::whereHas('pendaftaranSempro', function ($query) {
            $query->where('status_daftar_sempro_id', 1);
        })
            ->where('tahap_id', 2)
            ->where('periode_id', 1)
            ->where('prodi_id', 2)
            ->get()
            ->toArray();

        // 5 Ruang
        $ruangs = ["AH 1.1", "AH 1.2", "AH 1.3", "AH 1.5", "AH 1.12"];
        // 2 Hari
        $tanggals = ["2023-08-11", "2023-08-12"];
        // 4 Sesi
        $sesis = [
            ["waktu_mulai" => "08:00", "waktu_selesai" => "08:25"], 
            ["waktu_mulai" => "09:00", "waktu_selesai" => "09:25"], 
            ["waktu_mulai" => "10:00", "waktu_selesai" => "10:25"], 
            ["waktu_mulai" => "11:00", "waktu_selesai" => "11:25"]
        ];
        // Dosen dan Kuota Pengujinya
        $dosenKuota = KuotaDosen::all()->keyBy('dosen_id')->map(function ($item) {
            return [
                'kuota_penguji_sempro_1' => $item->kuota_penguji_sempro_1_D4,
                'kuota_penguji_sempro_2' => $item->kuota_penguji_sempro_2_D4
            ];
        })->toArray();
        $waktuBerhalangan = [];

        $service = new SemproSchedulerService();
        $service->hyperparameterTuning($proposals, $ruangs, $tanggals, $sesis, $dosenKuota, $waktuBerhalangan);
    }
}
