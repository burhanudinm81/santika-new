<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Uncomment jika ingin menjalankan seeder */
        $this->create20Logbook1Mhs();
        // $this->create20Logbook2Mhs();
    }

    public function create20Logbook1Mhs()
    {
        // Ganti dengan ID mahasiswa yang diinginkan
        $mahasiswa = Mahasiswa::find(330);

        $proposalId = ProposalDosenMahasiswa::where('mahasiswa_id', $mahasiswa->id)
            ->where("status_proposal_mahasiswa_id", 1)
            ->latest()
            ->first()
            ->proposal_id;

        $proposal = Proposal::find($proposalId);
        
        // Logbook untuk pembimbing 1
        for ($i = 1; $i <= 10; $i++) {
            $proposal->logbooks()->create([
                "dosen_id" => $proposal->dosen_pembimbing_1_id,
                "mahasiswa_id" => $mahasiswa->id,
                "nama_kegiatan" => "Kegiatan logbook ke-$i untuk mahasiswa $mahasiswa->nama",
                "tempat" => fake()->sentence(3),
                'jenis_kegiatan_id' => rand(1, 4),
                "hasil_kegiatan" => fake()->paragraph(),
                'tanggal_kegiatan' => now()->subDays(10 - $i),
                'status_logbook_id' => 1,
            ]);
        }

        // Logbook untuk pembimbing 2
        for ($i = 1; $i <= 10; $i++) {
            $proposal->logbooks()->create([
                "dosen_id" => $proposal->dosen_pembimbing_2_id,
                "mahasiswa_id" => $mahasiswa->id,
                "nama_kegiatan" => "Kegiatan logbook ke-$i untuk mahasiswa $mahasiswa->nama",
                "tempat" => fake()->sentence(3),
                'jenis_kegiatan_id' => rand(1, 4),
                "hasil_kegiatan" => fake()->paragraph(),
                'tanggal_kegiatan' => now()->subDays(10 - $i),
                'status_logbook_id' => 1,
            ]);
        }
    }

    public function create20Logbook2Mhs()
    {
        // Ganti dengan ID mahasiswa yang diinginkan
        $mahasiswa1 = Mahasiswa::find(1);
        $mahasiswa2 = Mahasiswa::find(2);

        $proposalId = ProposalDosenMahasiswa::where('mahasiswa_id', $mahasiswa1->id)
            ->where("status_proposal_mahasiswa_id", 1)
            ->latest()
            ->first()
            ->id;

        $proposal = Proposal::find($proposalId);
        
        // Logbook untuk pembimbing 1
        for ($i = 1; $i <= 10; $i++) {
            $proposal->logbooks()->create([
                "dosen_id" => $proposal->dosen_pembimbing_1_id,
                "mahasiswa_id" => $mahasiswa1->id,
                "mahasiswa2_id" => $mahasiswa2->id,
                "nama_kegiatan" => "Kegiatan logbook ke-$i untuk mahasiswa $mahasiswa1->nama dan $mahasiswa2->nama",
                "tempat" => fake()->sentence(3),
                'jenis_kegiatan_id' => rand(1, 4),
                "hasil_kegiatan" => fake()->paragraph(),
                'tanggal_kegiatan_kegiatan' => now()->subDays(10 - $i),
                'status_logbook_id' => 1,
            ]);
        }

        // Logbook untuk pembimbing 2
        for ($i = 1; $i <= 10; $i++) {
            $proposal->logbooks()->create([
                "dosen_id" => $proposal->dosen_pembimbing_2_id,
                "mahasiswa_id" => $mahasiswa1->id,
                "mahasiswa2_id" => $mahasiswa2->id,
                "nama_kegiatan" => "Kegiatan logbook ke-$i untuk mahasiswa $mahasiswa1->nama dan $mahasiswa2->nama",
                "tempat" => fake()->sentence(3),
                'jenis_kegiatan_id' => rand(1, 4),
                "hasil_kegiatan" => fake()->paragraph(),
                'tanggal_kegiatan' => now()->subDays(10 - $i),
                'status_logbook_id' => 1,
            ]);
        }
    }
}
