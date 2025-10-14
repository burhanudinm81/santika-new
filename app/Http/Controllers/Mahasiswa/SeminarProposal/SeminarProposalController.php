<?php

namespace App\Http\Controllers\Mahasiswa\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePendaftaranSemproRequest;
use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\PendaftaranSeminarProposal;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use App\Models\Tahap;
use App\Models\Revisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeminarProposalController extends Controller
{
    public function showPendaftaranPage()
    {
        $isPendaftaranClose = false;
        $isPendingProposal = false;
        $isPendingPendaftaran = 0;
        $acceptedProposalMahasiswa2 = null;
        $acceptedProposalMahasiswa1 = ProposalDosenMahasiswa::with('mahasiswa', 'dosen', 'proposal')
            ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
            ->where('status_proposal_mahasiswa_id', 1)
            ->first();


        if (!$acceptedProposalMahasiswa1) {
            $isPendingProposal = true;
        }

        if ($acceptedProposalMahasiswa1) {
            $pendingPendaftaran = PendaftaranSeminarProposal::where('proposal_id', $acceptedProposalMahasiswa1->proposal_id)
                ->whereIn('status_daftar_sempro_id', [1, 3])
                ->first();

            if ($pendingPendaftaran) {
                $isPendingPendaftaran = $pendingPendaftaran->status_daftar_sempro_id;
            }
        }

        if ($acceptedProposalMahasiswa1 != null && $acceptedProposalMahasiswa1->mahasiswa->prodi_id == 1) {

            $acceptedProposalMahasiswa2 = ProposalDosenMahasiswa::with('mahasiswa', 'dosen')
                ->where('proposal_id', $acceptedProposalMahasiswa1->proposal_id)
                ->where('mahasiswa_id', '!=', auth('mahasiswa')->user()->id)
                ->first();
        }

        $periodeAktif = Periode::where('aktif_sempro', true)->exists();
        $tahapAktif = Tahap::where('aktif_sempro', true)->exists();
        $isPendaftaranClose = !($periodeAktif && $tahapAktif);

        return view('mahasiswa.seminar-proposal.pendaftaran', compact(['isPendaftaranClose', 'isPendingProposal', 'isPendingPendaftaran', 'acceptedProposalMahasiswa1', 'acceptedProposalMahasiswa2']));
    }

    public function storePendaftaran(StorePendaftaranSemproRequest $request)
    {
        $validated = $request->validated();

        $pathFileProposal = null;
        $pathLembarKonsultasi = null;
        $pathLembarKerjaSamaMitra = null;
        $pathBuktiCekPlagiasi = null;

        $infoProposal = Proposal::find($validated['proposal_id']);

        $fileProposal = $request->file('file_proposal');
        $fileLembarKonsultasi = $request->file('lembar_konsultasi');
        $fileLembarKerjaSamaMitra = $request->file('lembar_kerja_sama_mitra');
        $fileBuktiCekPlagiasi = $request->file('bukti_cek_plagiasi');

        // membuat nama file yang unik
        $nameFileProposal = uniqid() . '.' . $fileProposal->getClientOriginalExtension();
        $nameLembarKonsultasi = uniqid() . '.' . $fileLembarKonsultasi->getClientOriginalExtension();
        $nameBuktiCekPlagiasi = uniqid() . '.' . $fileBuktiCekPlagiasi->getClientOriginalExtension();

        // Jika jenis judulnya adalah Mitra, generate nama file untuk file lembar kerja sama mitra
        if ($infoProposal->jenis_judul_id == 2) {
            $nameLembarKerjaSamaMitra = uniqid() . '.' . $fileLembarKerjaSamaMitra->getClientOriginalExtension();
        }

        // simpan ke folder
        $pathFileProposal = $fileProposal->storeAs(
            'seminar-proposal/pendaftaran/proposal',
            $nameFileProposal,
            'local'
        );
        $pathLembarKonsultasi = $fileLembarKonsultasi->storeAs(
            'seminar-proposal/pendaftaran/lembar-konsultasi',
            $nameLembarKonsultasi,
            'local'
        );
        $pathBuktiCekPlagiasi = $fileBuktiCekPlagiasi->storeAs(
            'seminar-proposal/pendaftaran/bukti-cekPlagiasi',
            $nameBuktiCekPlagiasi,
            'local'
        );

        // Jika jenis judulnya adalah Mitra, simpan file Lembar Kerja Sama Mitra
        if ($infoProposal->jenis_judul_id == 2) {
            $pathLembarKerjaSamaMitra = $fileLembarKerjaSamaMitra->storeAs(
                'seminar-proposal/pendaftaran/lembar-kerjaSamaMitra',
                $nameLembarKerjaSamaMitra,
                'local'
            );
        }

        DB::transaction(function () use ($validated, $infoProposal, $pathFileProposal, $pathLembarKonsultasi, $pathBuktiCekPlagiasi) {
            $newPendaftaranSempro = PendaftaranSeminarProposal::create([
                'proposal_id' => $validated['proposal_id'],
                'status_daftar_sempro_id' => 3,
                'file_proposal' => $pathFileProposal,
                'lembar_konsultasi' => $pathLembarKonsultasi,
                'lembar_kerjasama_mitra' => $pathLembarKerjaSamaMitra ?? null,
                'bukti_cek_plagiasi' => $pathBuktiCekPlagiasi,
                'status_file_proposal' => false,
                'status_lembar_konsultasi' => false,
                'status_lembar_kerjasama_mitra' => false,
                'status_bukti_cek_plagiasi' => false,
            ]);

            $periodeAktif = Periode::firstWhere('aktif_sempro', true);
            $tahapAktif = Tahap::firstWhere('aktif_sempro', true);

            $infoProposal->update([
                'pendaftaran_sempro_id' => $newPendaftaranSempro->id,
                'periode_id' => $periodeAktif->id,
                'tahap_id' => $tahapAktif->id
            ]);

            $proposalInfo = ProposalDosenMahasiswa::with('proposal', 'mahasiswa')
                ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
                ->where('status_proposal_mahasiswa_id', 1)
                ->first();

            Notifikasi::create([
                'dosen_id' => $proposalInfo->dosen_id,
                'mahasiswa_id' => $proposalInfo->mahasiswa_id,
                'tipe' => 'panitia',
                'keterangan' => sprintf(
                    '<span class="mr-2"><b>%s</b> telah mengajukan pendaftaran ujian.</span>
    <a href="%s" class="btn btn-sm btn-primary">Lihat Detail</a>',
                    $proposalInfo->mahasiswa->nama,
                    route('panitia.seminar-proposal.verifikasi-daftar', $newPendaftaranSempro->id)
                ),
            ]);
        });

        return redirect()->back()->with('success', 'Pendaftaran Sempro Berhasil Dibuat');
    }

    public function showHasilSempro()
    {
        $proposalInfo = null;
        $mainProposalInfo = null;
        $revisiDosen1 = null;
        $revisiDosen2 = null;

        $proposalInfo = ProposalDosenMahasiswa::with('proposal', 'mahasiswa')
            ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
            ->where('status_proposal_mahasiswa_id', 1)
            ->first();

        if (!is_null($proposalInfo)) {
            $mainProposalInfo = Proposal::with(['dosenPengujiSempro1', 'dosenPengujiSempro1', 'statusSemproPenguji1', 'statusSemproPenguji2'])
                ->where('id', $proposalInfo->proposal_id)
                ->first();
        }

        if (!is_null($mainProposalInfo)) {
            $revisiDosen1 = Revisi::where('proposal_id', $mainProposalInfo->id)
                ->where('dosen_id', $mainProposalInfo->dosenPengujiSempro1->id)
                ->first();

            $revisiDosen2 = Revisi::where('proposal_id', $mainProposalInfo->id)
                ->where('dosen_id', $mainProposalInfo->dosenPengujiSempro2->id)
                ->first();
        }

        return view('mahasiswa.seminar-proposal.hasil-sempro', compact(['proposalInfo', 'mainProposalInfo', 'revisiDosen1', 'revisiDosen2']));
    }

    public function showUploadRevisi()
    {
        $proposalInfo = null;
        $mainProposalInfo = null;
        $revisiPenguji1 = null;
        $revisiPenguji2 = null;
        $namaLembarRevisi1 = null;
        $namaLembarRevisi2 = null;
        $namaProposal = null;
        $statusRevisi = null;

        $proposalInfo = ProposalDosenMahasiswa::with('proposal', 'mahasiswa')
            ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
            ->where('status_proposal_mahasiswa_id', 1)
            ->latest()
            ->first();

        if (!is_null($proposalInfo)) {
            $mainProposalInfo = Proposal::with([
                'dosenPengujiSempro1',
                'dosenPengujiSempro2',
                'statusSemproPenguji1',
                'statusSemproPenguji2'
            ])
                ->where('id', $proposalInfo->proposal_id)
                ->first();
        }

        if (!is_null($mainProposalInfo)) {
            $revisiPenguji1 = Revisi::where('proposal_id', $mainProposalInfo->id)
                ->where('dosen_id', $mainProposalInfo->dosenPengujiSempro1->id)
                ->where('jenis_revisi', "sempro")
                ->first();
            $revisiPenguji2 = Revisi::where('proposal_id', $mainProposalInfo->id)
                ->where('dosen_id', $mainProposalInfo->dosenPengujiSempro2->id)
                ->where('jenis_revisi', "sempro")
                ->first();
        }

        if (!is_null($revisiPenguji1)) {
            $patternLembarRevisi1 = '/seminar-proposal\/revisi\/lembar-revisi-penguji-1\/(.*)$/';
            $patternProposal = '/seminar-proposal\/revisi\/proposal\/(.*)$/';

            // Jalankan pencocokan RegEx
            preg_match($patternLembarRevisi1, $revisiPenguji1->file_lembar_revisi_dosen, $matchesLembarRevisi1);
            preg_match($patternProposal, $revisiPenguji1->file_proposal_revisi, $matchesProposal);

            if (isset($matchesLembarRevisi1[1]))
                $namaLembarRevisi1 = $matchesLembarRevisi1[1];
            if (isset($matchesProposal[1]))
                $namaProposal = $matchesProposal[1];
        }

        if (!is_null($revisiPenguji1)) {
            $patternLembarRevisi2 = '/seminar-proposal\/revisi\/lembar-revisi-penguji-2\/(.*)$/';

            // Jalankan pencocokan RegEx
            preg_match($patternLembarRevisi2, $revisiPenguji2->file_lembar_revisi_dosen, $matchesLembarRevisi2);

            if (isset($matchesLembarRevisi2[1]))
                $namaLembarRevisi2 = $matchesLembarRevisi2[1];
        }

        if ($revisiPenguji1 && $revisiPenguji1->status == "diterima" && $revisiPenguji2->status == "diterima")
            $statusRevisi = "Diterima";
        else
            $statusRevisi = "Pending";

        return view(
            'mahasiswa.seminar-proposal.upload-revisi',
            compact(
                'mainProposalInfo',
                'revisiPenguji1',
                'revisiPenguji2',
                'namaLembarRevisi1',
                'namaLembarRevisi2',
                'namaProposal',
                'statusRevisi'
            )
        );
    }

    public function storeUploadRevisi(Request $request)
    {
        $penguji1ID = $request->input('penguji_1_id');
        $penguji2ID = $request->input('penguji_2_id');
        $proposalID = $request->input('proposal_id');
        $fileLembarRevisiPenguji1 = $request->file('lembar_revisi_penguji_1');
        $fileLembarRevisiPenguji2 = $request->file('lembar_revisi_penguji_2');
        $fileProposalRevisi = $request->file('proposal_revisi');

        // rename file
        $nameLembarRevisi1 = uniqid() . '.' . $fileLembarRevisiPenguji1->getClientOriginalExtension();
        $nameLembarRevisi2 = uniqid() . '.' . $fileLembarRevisiPenguji2->getClientOriginalExtension();
        $nameProposalRevisi = uniqid() . '.' . $fileProposalRevisi->getClientOriginalExtension();

        $pathProposalRevisi = $fileProposalRevisi->storeAs(
            'seminar-proposal/revisi/proposal',
            $nameProposalRevisi,
            'local'
        );
        $pathLembarRevisi1 = $fileLembarRevisiPenguji1->storeAs(
            'seminar-proposal/revisi/lembar-revisi-penguji-1',
            $nameLembarRevisi1,
            'local'
        );
        $pathLembarRevisi2 = $fileLembarRevisiPenguji2->storeAs(
            'seminar-proposal/revisi/lembar-revisi-penguji-2',
            $nameLembarRevisi2,
            'local'
        );

        $revisi1 = Revisi::where('proposal_id', $proposalID)
            ->where('dosen_id', $penguji1ID)
            ->first();
        $revisi2 = Revisi::where('proposal_id', $proposalID)
            ->where('dosen_id', $penguji2ID)
            ->first();

        $revisi1->update([
            'file_proposal_revisi' => $pathProposalRevisi,
            'file_lembar_revisi_dosen' => $pathLembarRevisi1
        ]);
        $revisi2->update([
            'file_proposal_revisi' => $pathProposalRevisi,
            'file_lembar_revisi_dosen' => $pathLembarRevisi2
        ]);

        return redirect()->back()->with('success', 'Revisi Berhasil Diupload');
    }

    public function riwayat()
    {
        $data = ProposalDosenMahasiswa::with('dosen', 'proposal')
            ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
            ->where('status_proposal_mahasiswa_id', 1)
            ->latest()
            ->get();

        $statusPendaftaran = [
            1 => 'Diterima',
            2 => 'Ditolak',
            3 => 'Belum Dicek',
        ];

        return view('mahasiswa.seminar-proposal.riwayat', compact('data', 'statusPendaftaran'));
    }
}
