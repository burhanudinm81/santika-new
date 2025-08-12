<?php

namespace App\Http\Controllers\Mahasiswa\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePendaftaranSemhasRequest;
use App\Models\BidangMinat;
use App\Models\LogBook;
use App\Models\PendaftaranSemhas;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use App\Models\Revisi;
use App\Models\Tahap;
use Illuminate\Http\Request;

class SeminarHasilController extends Controller
{
    public function showPendaftaranPage()
    {
        $infoMahasiswaAll = null;
        $infoDospem1 = null;
        $infoDospem2 = null;
        $infoBidangMinat = null;
        $infoPendaftaranSemhas = null;
        $countLogbookDospem1 = 0;
        $countLogbookDospem2 = 0;
        $isLogbookAmountNotSatisfied = true;
        $isPendaftaranClose = false;

        $infoProposal = Proposal::with(['proposalMahasiswas', 'dosenPembimbing1', 'dosenPembimbing2', 'bidangMinat'])
            ->whereRelation('proposalMahasiswas', 'mahasiswa_id', auth('mahasiswa')->user()->id)
            ->whereRelation('proposalMahasiswas', 'status_proposal_mahasiswa_id', 1)
            ->where('pendaftaran_sempro_id', '!=', null)
            ->latest()
            ->first();


        if ($infoProposal != null) {
            $infoMahasiswaAll = ProposalDosenMahasiswa::with(['dosen', 'mahasiswa'])
                ->where('proposal_id', $infoProposal->id)
                ->get();
            $infoDospem1 = $infoProposal->dosenPembimbing1()->first();
            $infoDospem2 = $infoProposal->dosenPembimbing2()->first();

            $infoBidangMinat = BidangMinat::all();

            $infoPendaftaranSemhas = PendaftaranSemhas::with('statusDaftarSeminar')->where('proposal_id', $infoProposal->id)->first();

            $logbookDospem1 = LogBook::where('dosen_id', $infoProposal->dosen_pembimbing_1_id)
                ->where('proposal_id', $infoProposal->id)
                ->where('status_logbook_id', 3)
                ->get();

            $logbookDospem2 = LogBook::where('dosen_id', $infoProposal->dosen_pembimbing_2_id)
                ->where('proposal_id', $infoProposal->id)
                ->where('status_logbook_id', 3)
                ->get();

            $countLogbookDospem1 = $logbookDospem1->count();
            $countLogbookDospem2 = $logbookDospem2->count();

            if ($countLogbookDospem1 >= 10 && $countLogbookDospem2 >= 10)
                $isLogbookAmountNotSatisfied = false;
        }

        $periodeAktif = Periode::where('aktif_sidang_akhir', true)->exists();
        $tahapAktif = Tahap::where('aktif_sidang_akhir', true)->exists();
        $isPendaftaranClose = !($periodeAktif && $tahapAktif);

        return view('mahasiswa.seminar-hasil.daftar-semhas', compact([
            'infoProposal',
            'infoMahasiswaAll',
            'infoDospem1',
            'infoDospem2',
            'infoBidangMinat',
            'infoPendaftaranSemhas',
            'countLogbookDospem1',
            'countLogbookDospem2',
            'isLogbookAmountNotSatisfied',
            'isPendaftaranClose'
        ]));
    }

    public function storePendaftaran(StorePendaftaranSemhasRequest $request)
    {
        $validated = $request->validated();

        $infoProposal = Proposal::find($validated['proposal_id']);

        $pathFileRekomDospem = null;
        $pathFileProposalSemhas = null;
        $pathFileDraftJurnal = null;
        $pathFileIAMitra = null;
        $pathFileBebasTanggunganPkl = null;
        $pathFileSkla = null;


        $fileRekomDospem = $request->file('file_rekom_dospem');
        $fileProposalSemhas = $request->file('file_proposal_semhas');
        $fileDraftJurnal = $request->file('file_draft_jurnal');
        $fileIAMitra = $request->file('file_IA_mitra');
        $fileBebasTanggunganPkl = $request->file('file_bebas_tanggungan_pkl');
        $fileSkla = $request->file('file_skla');

        // membuat nama file yang unik
        $nameFileRekomDospem = uniqid() . '.' . $fileRekomDospem->getClientOriginalExtension();
        $nameFileProposalSemhas = uniqid() . '.' . $fileProposalSemhas->getClientOriginalExtension();
        $nameFileDraftJurnal = uniqid() . '.' . $fileDraftJurnal->getClientOriginalExtension();
        if ($fileIAMitra != null) {
            $nameFileIAMitra = uniqid() . '.' . $fileIAMitra->getClientOriginalExtension();
        }
        $nameFileBebasTanggunganPkl = uniqid() . '.' . $fileBebasTanggunganPkl->getClientOriginalExtension();
        $nameFileSkla = uniqid() . '.' . $fileSkla->getClientOriginalExtension();

        // simpan ke folder
        $pathFileRekomDospem = $fileRekomDospem->storeAs(
            'seminar-hasil/pendaftaran/rekomdosem',
            $nameFileRekomDospem,
            'local'
        );
        $pathFileProposalSemhas = $fileProposalSemhas->storeAs(
            'seminar-hasil/pendaftaran/proposal-semhas',
            $nameFileProposalSemhas,
            'local'
        );
        $pathFileDraftJurnal = $fileDraftJurnal->storeAs(
            'seminar-hasil/pendaftaran/draft-journal',
            $nameFileDraftJurnal,
            'local'
        );

        if ($fileIAMitra != null) {
            $pathFileIAMitra = $fileIAMitra->storeAs(
                'seminar-hasil/pendaftaran/IA-mitra',
                $nameFileIAMitra,
                'local'
            );
        }

        $pathFileBebasTanggunganPkl = $fileBebasTanggunganPkl->storeAs(
            'seminar-hasil/pendaftaran/bebas-tanggungan-pkl',
            $nameFileBebasTanggunganPkl,
            'local'
        );
        $pathFileSkla = $fileSkla->storeAs(
            'seminar-hasil/pendaftaran/skla',
            $nameFileSkla,
            'local'
        );

        $newPendaftaranSemhas = PendaftaranSemhas::create([
            'proposal_id' => $validated['proposal_id'],
            'status_daftar_semhas_id' => 3,
            'file_rekom_dospem' => $pathFileRekomDospem,
            'file_proposal_semhas' => $pathFileProposalSemhas,
            'file_draft_jurnal' => $pathFileDraftJurnal,
            'file_IA_mitra' => $pathFileIAMitra,
            'file_bebas_tanggungan_pkl' => $pathFileBebasTanggunganPkl,
            'file_skla' => $pathFileSkla,
            'status_file_rekom_dosen' => false,
            'status_file_proposal_semhas' => false,
            'status_file_draft_jurnal' => false,
            'status_file_bebas_tanggungan_pkl' => false,
            'status_file_skla' => false,
        ]);

        $periodeAktif = Periode::firstWhere('aktif_sidang_akhir', true);
        $tahapAktif = Tahap::firstWhere('aktif_sidang_akhir', true);

        $infoProposal->update([
            'pendaftaran_semhas_id' => $newPendaftaranSemhas->id,
            'periode_semhas_id' => $periodeAktif->id,
            'tahap_semhas_id' => $tahapAktif->id
        ]);

        return redirect()->back()->with('success', 'Pendaftaran Semhas Berhasil Dibuat');
    }

    public function showHasilSementaraSemhas()
    {
        $proposalInfo = ProposalDosenMahasiswa::with('proposal', 'mahasiswa')
            ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
            ->where('status_proposal_mahasiswa_id', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        $mainProposalInfo = Proposal::with(['dosenPengujiSidangTA1', 'dosenPengujiSidangTA2', 'statusSemhasPenguji1', 'statusSemhasPenguji2'])
            ->where('id', $proposalInfo->proposal_id)
            ->first();

        $revisiDosen1 = Revisi::where('proposal_id', $mainProposalInfo->id)
            ->where('dosen_id', $mainProposalInfo->dosenPengujiSidangTA1->id)
            ->where('jenis_revisi', 'semhas')
            ->first();

        $revisiDosen2 = Revisi::where('proposal_id', $mainProposalInfo->id)
            ->where('dosen_id', $mainProposalInfo->dosenPengujiSidangTA2->id)
            ->where('jenis_revisi', 'semhas')
            ->first();

        return view(
            'mahasiswa.seminar-hasil.hasil-semhas-sementara'
            ,compact(['proposalInfo', 'mainProposalInfo', 'revisiDosen1', 'revisiDosen2'])
        );
    }

    public function showUploadRevisi()
    {
        $proposalInfo = ProposalDosenMahasiswa::with('proposal', 'mahasiswa')
            ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
            ->where('status_proposal_mahasiswa_id', 1)
            ->first();

        $mainProposalInfo = Proposal::with(['dosenPengujiSidangTA1', 'dosenPengujiSidangTA2', 'statusSemhasPenguji1', 'statusSemhasPenguji2', 'statusSemhasTotal'])
            ->where('id', $proposalInfo->proposal_id)
            ->first();

        $revisiPeng1 = Revisi::where('proposal_id', $mainProposalInfo->id)
            ->where('dosen_id', $mainProposalInfo->dosenPengujiSidangTA1->id)
            ->where('jenis_revisi', 'semhas')
            ->first();
        if($revisiPeng1 == null){
            $revisiPeng1 = null;
        }

        $revisiPeng2 = Revisi::where('proposal_id', $mainProposalInfo->id)
            ->where('dosen_id', $mainProposalInfo->dosenPengujiSidangTA2->id)
            ->where('jenis_revisi', 'semhas')
            ->first();
        if($revisiPeng2 == null){
            $revisiPeng2 = null;
        }

        return view('mahasiswa.seminar-hasil.upload-revisi', compact([
            'mainProposalInfo',
            'revisiPeng1',
            'revisiPeng2'
        ]));
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
            'seminar-hasil/revisi/proposal',
            $nameProposalRevisi,
            'local'
        );
        $pathLembarRevisi1 = $fileLembarRevisiPenguji1->storeAs(
            'seminar-hasil/revisi/lembar-revisi-penguji-1',
            $nameLembarRevisi1,
            'local'
        );
        $pathLembarRevisi2 = $fileLembarRevisiPenguji2->storeAs(
            'seminar-hasil/revisi/lembar-revisi-penguji-2',
            $nameLembarRevisi2,
            'local'
        );

        $revisi1 = Revisi::where('proposal_id', $proposalID)
            ->where('dosen_id', $penguji1ID)
            ->where('jenis_revisi', 'semhas')
            ->first();
        $revisi2 = Revisi::where('proposal_id', $proposalID)
            ->where('dosen_id', $penguji2ID)
            ->where('jenis_revisi', 'semhas')
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
}
