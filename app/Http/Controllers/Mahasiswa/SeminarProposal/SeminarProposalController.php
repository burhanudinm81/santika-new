<?php

namespace App\Http\Controllers\Mahasiswa\SeminarProposal;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePendaftaranSemproRequest;
use App\Models\PendaftaranSeminarProposal;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use Illuminate\Http\Request;

class SeminarProposalController extends Controller
{
    public function showPendaftaranPage()
    {
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

        if ($acceptedProposalMahasiswa1 != null &&  $acceptedProposalMahasiswa1->mahasiswa->prodi_id == 1) {

            $acceptedProposalMahasiswa2 = ProposalDosenMahasiswa::with('mahasiswa', 'dosen')
                ->where('proposal_id', $acceptedProposalMahasiswa1->proposal_id)
                ->where('mahasiswa_id', '!=', auth('mahasiswa')->user()->id)
                ->first();
        }

        return view('mahasiswa.seminar-proposal.pendaftaran', compact(['isPendingProposal', 'isPendingPendaftaran', 'acceptedProposalMahasiswa1', 'acceptedProposalMahasiswa2']));
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
        $nameLembarKerjaSamaMitra = uniqid() . '.' . $fileLembarKerjaSamaMitra->getClientOriginalExtension();
        $nameBuktiCekPlagiasi = uniqid() . '.' . $fileBuktiCekPlagiasi->getClientOriginalExtension();

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
        $pathLembarKerjaSamaMitra = $fileLembarKerjaSamaMitra->storeAs(
            'seminar-proposal/pendaftaran/lembar-kerjaSamaMitra',
            $nameLembarKerjaSamaMitra,
            'local'
        );
        $pathBuktiCekPlagiasi = $fileBuktiCekPlagiasi->storeAs(
            'seminar-proposal/pendaftaran/bukti-cekPlagiasi',
            $nameBuktiCekPlagiasi,
            'local'
        );

        $newPendaftaranSempro = PendaftaranSeminarProposal::create([
            'proposal_id' => $validated['proposal_id'],
            'status_daftar_sempro_id' => 3,
            'file_proposal' => $pathFileProposal,
            'lembar_konsultasi' => $pathLembarKonsultasi,
            'lembar_kerjasama_mitra' => $pathLembarKerjaSamaMitra,
            'bukti_cek_plagiasi' => $pathBuktiCekPlagiasi,
            'status_file_proposal' => false,
            'status_lembar_konsultasi' => false,
            'status_lembar_kerjasama_mitra' => false,
            'status_bukti_cek_plagiasi' => false,
        ]);

        $infoProposal->update([
            'pendaftaran_sempro_id' => $newPendaftaranSempro->id,
            'tahap_id' => 1
        ]);


        return redirect()->back()->with('success', 'Pendaftaran Sempro Berhasil Dibuat');
    }
}
