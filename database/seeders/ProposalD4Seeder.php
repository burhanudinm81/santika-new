<?php

namespace Database\Seeders;

use App\Models\Proposal;
use App\Models\DosenBidangMinat;
use Illuminate\Database\Seeder;

class ProposalD4Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil mapping dosen_id berdasarkan bidang_minat_id (hanya dosen id 1-35)
        $dosenBidang = DosenBidangMinat::whereBetween('dosen_id', [1, 35])->get();
        $dosenByBidang = [];
        foreach ($dosenBidang as $row) {
            $dosenByBidang[$row->bidang_minat_id][] = $row->dosen_id;
        }

        for ($id = 101; $id <= 200; $id++) {
            $bidang_minat_id = rand(1, 3);
            $jenis_judul_id = rand(1, 3);
            $judul = "Judul $id";
            $topik = fake()->sentence(6);
            $tujuan = "Tujuan $id";
            $latar_belakang = "Latar Belakang $id";
            $blok_diagram_sistem = fake()->sentence(8);
            if ($id >= 101 && $id <= 120) {
                $tahap_id = 1;
            } elseif ($id >= 121 && $id <= 150) {
                $tahap_id = 2;
            } else {
                $tahap_id = 3;
            }

            // Pilih dosen_pembimbing_1_id yang bidang minatnya sama
            $dosenIds = $dosenByBidang[$bidang_minat_id] ?? null;
            if (!$dosenIds) continue; // skip jika tidak ada dosen bidang tsb
            $dosen_pembimbing_1_id = $dosenIds[array_rand($dosenIds)];

            Proposal::create([
                'id' => $id,
                'prodi_id' => 2,
                'periode_id' => 1,
                'bidang_minat_id' => $bidang_minat_id,
                'jenis_judul_id' => $jenis_judul_id,
                'dosen_pembimbing_1_id' => $dosen_pembimbing_1_id,
                'judul' => $judul,
                'topik' => $topik,
                'tujuan' => $tujuan,
                'latar_belakang' => $latar_belakang,
                'blok_diagram_sistem' => $blok_diagram_sistem,
                'tahap_id' => $tahap_id,
            ]);
        }

        // Proposal untuk tahap 4
        for ($id = 209; $id <= 216; $id++) {
            $bidang_minat_id = rand(1, 3);
            $jenis_judul_id = rand(1, 3);
            $judul = "Judul $id";
            $topik = fake()->sentence(6);
            $tujuan = "Tujuan $id";
            $latar_belakang = "Latar Belakang $id";
            $blok_diagram_sistem = fake()->sentence(8);
            $tahap_id = 4;

            // Pilih dosen_pembimbing_1_id yang bidang minatnya sama
            $dosenIds = $dosenByBidang[$bidang_minat_id] ?? null;
            if (!$dosenIds) continue; // skip jika tidak ada dosen bidang tsb
            $dosen_pembimbing_1_id = $dosenIds[array_rand($dosenIds)];

            Proposal::create([
                'id' => $id,
                'prodi_id' => 1,
                'periode_id' => 1,
                'bidang_minat_id' => $bidang_minat_id,
                'jenis_judul_id' => $jenis_judul_id,
                'dosen_pembimbing_1_id' => $dosen_pembimbing_1_id,
                'judul' => $judul,
                'topik' => $topik,
                'tujuan' => $tujuan,
                'latar_belakang' => $latar_belakang,
                'blok_diagram_sistem' => $blok_diagram_sistem,
                'tahap_id' => $tahap_id,
            ]);
        }
    }
}
