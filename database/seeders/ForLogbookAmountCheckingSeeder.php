<?php

namespace Database\Seeders;

use App\Models\LogBook;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ForLogbookAmountCheckingSeeder extends Seeder
{
    /**
     * JANGAN MASUKKAN SEEDER INI KE DATABASE SEEDER!!!!!!!
     * FILE INI MEMBUAT 4000 lebih logbook
     */
    public function run(): void
    {
        $faker = Faker::create("id_ID");
        $listProposal = Proposal::all();

        [$proposalD3, $proposalD4] = $listProposal->partition(function ($item) {
            return $item->id <= 100 || ($item->id > 200 && $item->id <= 208);
        });

        // Proposal D3
        $proposalD3->each(function ($item) use ($faker) {
            $mahasiswaIds = ProposalDosenMahasiswa::where('proposal_id', $item->id)
                ->pluck('mahasiswa_id');

            // Logbook Dospem 1
            for ($i = 1; $i <= 10; $i++) {
                LogBook::create([
                    'proposal_id' => $item->id,
                    'dosen_id' => $item->dosen_pembimbing_1_id,
                    'mahasiswa_id' => $mahasiswaIds[0],
                    'mahasiswa2_id' => $mahasiswaIds[1] ?? null,
                    'jenis_kegiatan_id' => rand(1, 4),
                    'nama_kegiatan' => $faker->sentence(4),
                    'hasil_kegiatan' => $faker->sentence(10),
                    'tanggal_kegiatan' => Carbon::today(),
                    'catatan_khusus_dosen' => $faker->sentence(),
                    'status_logbook_id' => 3
                ]);
            }

            // Logbook Dospem 2
            for ($i = 1; $i <= 10; $i++) {
                LogBook::create([
                    'proposal_id' => $item->id,
                    'dosen_id' => $item->dosen_pembimbing_2_id,
                    'mahasiswa_id' => $mahasiswaIds[0],
                    'mahasiswa2_id' => $mahasiswaIds[1] ?? null,
                    'jenis_kegiatan_id' => rand(1, 4),
                    'nama_kegiatan' => $faker->sentence(4),
                    'hasil_kegiatan' => $faker->sentence(10),
                    'tanggal_kegiatan' => Carbon::today(),
                    'catatan_khusus_dosen' => $faker->sentence(),
                    'status_logbook_id' => 3
                ]);
            }
        });

        // Proposal D4
        $proposalD4->each(function ($item) use ($faker) {
            $mahasiswaId = ProposalDosenMahasiswa::where('proposal_id', $item->id)
                ->first()->mahasiswa_id;

            // Logbook Dospem 1
            for ($i = 1; $i <= 10; $i++) {
                LogBook::create([
                    'proposal_id' => $item->id,
                    'dosen_id' => $item->dosen_pembimbing_1_id,
                    'mahasiswa_id' => $mahasiswaId,
                    'jenis_kegiatan_id' => rand(1, 4),
                    'nama_kegiatan' => $faker->sentence(4),
                    'hasil_kegiatan' => $faker->sentence(10),
                    'tanggal_kegiatan' => Carbon::today(),
                    'catatan_khusus_dosen' => $faker->sentence(),
                    'status_logbook_id' => 3
                ]);
            }

            // Logbook Dospem 2
            for ($i = 1; $i <= 10; $i++) {
                LogBook::create([
                    'proposal_id' => $item->id,
                    'dosen_id' => $item->dosen_pembimbing_2_id,
                    'mahasiswa_id' => $mahasiswaId,
                    'jenis_kegiatan_id' => rand(1, 4),
                    'nama_kegiatan' => $faker->sentence(4),
                    'hasil_kegiatan' => $faker->sentence(10),
                    'tanggal_kegiatan' => Carbon::today(),
                    'catatan_khusus_dosen' => $faker->sentence(),
                    'status_logbook_id' => 3
                ]);
            }
        });
    }
}
