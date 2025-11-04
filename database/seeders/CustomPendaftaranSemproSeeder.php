<?php

namespace Database\Seeders;

use App\Models\PendaftaranSeminarProposal;
use App\Models\Proposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomPendaftaranSemproSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->daftarSempro();
    }

    public function daftarSempro()
    {
        $periodeId = 1;     // Ganti dengan Periode Id yang sesuai
        $tahapId = 1;       // Ganti dengan Tahap Id yang sesuai

        $daftarProposal = Proposal::whereBetween("id", [50, 60])    // Ganti dengan rentang id yang sesuai
            ->get();

        $daftarProposal->each(function($proposal) use($periodeId, $tahapId) {
            $newPendaftaranSempro = PendaftaranSeminarProposal::create([
                'proposal_id' => $proposal->id,
                'status_daftar_sempro_id' => 1,
                'file_proposal' => "seminar-proposal/pendaftaran/proposal/proposal.pdf",
                'lembar_konsultasi' => "seminar-proposal/pendaftaran/lembar-konsultasi/lembar-konsultasi.pdf",
                'lembar_kerjasama_mitra' => $proposal->jenis_judul_id == 2 ? "seminar-proposal/pendaftaran/lembar-kerjaSamaMitra/lembar-kerja-sama-mitra.pdf" : null,
                'bukti_cek_plagiasi' => "pengajuan-judul/blok-diagram-sitem/bukti-cek-plagiasi.jpg",
                'status_file_proposal' => true,
                'status_lembar_konsultasi' => true,
                'status_lembar_kerjasama_mitra' => true,
                'status_bukti_cek_plagiasi' => true,
            ]);

            $proposal->update([
                'pendaftaran_sempro_id' => $newPendaftaranSempro->id,
                'periode_id' => $periodeId,
                'tahap_id' => $tahapId
            ]);
        });
        
        
    }
}
