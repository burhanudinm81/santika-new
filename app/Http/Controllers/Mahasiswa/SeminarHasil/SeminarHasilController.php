<?php

namespace App\Http\Controllers\Mahasiswa\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePendaftaranSemhasRequest;
use App\Models\BidangMinat;
use App\Models\LogBook;
use App\Models\Notifikasi;
use App\Models\PendaftaranSemhas;
use App\Models\Periode;
use App\Models\Proposal;
use App\Models\ProposalDosenMahasiswa;
use App\Models\Revisi;
use App\Models\Tahap;
use App\Models\VisibilitasNilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $belumSempro = true;

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

            if (!is_null($infoProposal->status_sempro_penguji_1_id) && !is_null($infoProposal->status_sempro_penguji_2_id)) {
                $belumSempro = false;
            }

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
            'isPendaftaranClose',
            'belumSempro'
        ]));
    }

    public function storePendaftaran(StorePendaftaranSemhasRequest $request)
    {
        DB::transaction(function () use ($request) {
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

            $proposalInfo = ProposalDosenMahasiswa::with('proposal', 'mahasiswa')
                ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
                ->where('status_proposal_mahasiswa_id', 1)
                ->first();

            Notifikasi::create([
                'dosen_id' => $proposalInfo->dosen_id,
                'mahasiswa_id' => $proposalInfo->mahasiswa_id,
                'tipe' => 'panitia',
                'keterangan' => sprintf(
                    '<span class="mr-2"><b>%s</b> telah mengajukan pendaftaran sidang laporan akhir.</span>
    <a href="%s" class="btn btn-sm btn-primary">Lihat Detail</a>',
                    $proposalInfo->mahasiswa->nama,
                    route('panitia.seminar-hasil.verifikasi-daftar', $newPendaftaranSemhas->id)
                ),
            ]);
        });

        return redirect()->back()->with('success', 'Pendaftaran Semhas Berhasil Dibuat');
    }

    public function showHasilSementaraSemhas()
    {
        $statusKelulusanSemhas = null;
        $mainProposalInfo = null;
        $isPengujiNotAssigned = false;
        $revisiSelesai = false;
        $revisiDosen1 = null;
        $revisiDosen2 = null;
        $revisiDosbing1 = null;
        $revisiDosbing2 = null;
        $visible = false;

        $proposalInfo = ProposalDosenMahasiswa::with('proposal', 'mahasiswa')
            ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
            ->where('status_proposal_mahasiswa_id', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!is_null($proposalInfo)) {
            $mainProposalInfo = Proposal::with([
                'dosenPengujiSidangTA1',
                'dosenPengujiSidangTA2',
                'statusSemhasPenguji1',
                'statusSemhasPenguji2',
                'dosenPembimbing1',
                'dosenPembimbing2',
                'statusSemhasPembimbing1',
                'statusSemhasPembimbing2'
            ])
                ->where('id', $proposalInfo->proposal_id)
                ->first();

            $tahapIdPeserta = $proposalInfo->proposal->tahap_id;
            $periodeIdPeserta = $proposalInfo->proposal->periode_id;

            $visible = VisibilitasNilai::where('tahap_id', $tahapIdPeserta)
                ->where('periode_id', $periodeIdPeserta)
                ->where('jenis_nilai_seminar', 2) // 2 = Nilai Sidang Tugas Akhir
                ->first()
                ->visibilitas ?? false;
        }


        if (!is_null($mainProposalInfo)) {
            if (!is_null($mainProposalInfo->dosenPengujiSidangTA1) && !is_null($mainProposalInfo->dosenPengujiSidangTA2)) {
                $revisiDosen1 = Revisi::where('proposal_id', $mainProposalInfo->id)
                    ->where('dosen_id', $mainProposalInfo->dosenPengujiSidangTA1->id)
                    ->where('jenis_revisi', 'semhas')
                    ->first();

                $revisiDosen2 = Revisi::where('proposal_id', $mainProposalInfo->id)
                    ->where('dosen_id', $mainProposalInfo->dosenPengujiSidangTA2->id)
                    ->where('jenis_revisi', 'semhas')
                    ->first();

                $revisiDosbing1 = Revisi::where('proposal_id', $mainProposalInfo->id)
                    ->where('dosen_id', $mainProposalInfo->dosenPembimbing1->id)
                    ->where('jenis_revisi', 'semhas')
                    ->first();
                $revisiDosbing2 = Revisi::where('proposal_id', $mainProposalInfo->id)
                    ->where('dosen_id', $mainProposalInfo->dosenPembimbing2->id)
                    ->where('jenis_revisi', 'semhas')
                    ->first();

                if (
                    !is_null($revisiDosen1) &&
                    !is_null($revisiDosen2) &&
                    !is_null($revisiDosbing1) &&
                    !is_null($revisiDosbing2)
                ) {
                    if (
                        $revisiDosen1->status == "diterima" &&
                        $revisiDosen2->status == "diterima" &&
                        $revisiDosbing1->status == "diterima" &&
                        $revisiDosbing2->status == "diterima"
                    ) {
                        $revisiSelesai = true;
                    }
                }

                if (
                    in_array(
                        3,
                        [
                            $mainProposalInfo->status_semhas_penguji_1_id,
                            $mainProposalInfo->status_semhas_penguji_2_id,
                            $mainProposalInfo->status_semhas_dosbing_1_id,
                            $mainProposalInfo->status_semhas_dosbing_2_id
                        ]
                    )
                ) {
                    $statusKelulusanSemhas = 3;     // 3 = Tidak Lulus
                } else if (
                    in_array(
                        2,
                        [
                            $mainProposalInfo->status_semhas_penguji_1_id,
                            $mainProposalInfo->status_semhas_penguji_2_id,
                            $mainProposalInfo->status_semhas_dosbing_1_id,
                            $mainProposalInfo->status_semhas_dosbing_2_id
                        ]
                    )
                ) {
                    $statusKelulusanSemhas = 2;     // 2 = Lulus dengan revisi
                } else if (
                    in_array(
                        1,
                        [
                            $mainProposalInfo->status_semhas_penguji_1_id,
                            $mainProposalInfo->status_semhas_penguji_2_id,
                            $mainProposalInfo->status_semhas_dosbing_1_id,
                            $mainProposalInfo->status_semhas_dosbing_2_id
                        ]
                    )
                ) {
                    $statusKelulusanSemhas = 1;     // 1 = Lulus tanpa revisi
                }
            } else {
                $isPengujiNotAssigned = true;
            }
        }

        return view(
            'mahasiswa.seminar-hasil.hasil-semhas-sementara',
            compact([
                'proposalInfo',
                'mainProposalInfo',
                'revisiDosen1',
                'revisiDosen2',
                'revisiDosbing1',
                'revisiDosbing2',
                'statusKelulusanSemhas',
                'isPengujiNotAssigned',
                'revisiSelesai',
                'visible'
            ])
        );
    }

    public function showUploadRevisi()
    {
        $mainProposalInfo = null;
        $revisiPenguji1 = null;
        $revisiPenguji2 = null;
        $revisiPembimbing1 = null;
        $revisiPembimbing2 = null;
        $namaLembarRevisiPenguji1 = null;
        $namaLembarRevisiPenguji2 = null;
        $namaLembarRevisiPembimbing1 = null;
        $namaLembarRevisiPembimbing2 = null;
        $namaProposal = null;
        $isPengujiNotAssigned = false;
        $statusKelulusanSemhas = null;
        $statusRevisi = null;

        $proposalInfo = ProposalDosenMahasiswa::with('proposal', 'mahasiswa')
            ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
            ->where('status_proposal_mahasiswa_id', 1)
            ->first();

        if (!is_null($proposalInfo)) {
            $mainProposalInfo = Proposal::with([
                'dosenPengujiSidangTA1',
                'dosenPengujiSidangTA2',
                'statusSemhasPenguji1',
                'statusSemhasPenguji2',
                'dosenPembimbing1',
                'dosenPembimbing2',
                'statusSemhasPembimbing1',
                'statusSemhasPembimbing2'
            ])
                ->where('id', $proposalInfo->proposal_id)
                ->first();
        }

        if (
            !is_null($mainProposalInfo) &&
            !is_null($mainProposalInfo->dosenPengujiSidangTA1) &&
            !is_null($mainProposalInfo->dosenPengujiSidangTA2)
        ) {
            $revisiPenguji1 = Revisi::where('proposal_id', $mainProposalInfo->id)
                ->where('dosen_id', $mainProposalInfo->dosenPengujiSidangTA1->id)
                ->where('jenis_revisi', 'semhas')
                ->first();

            $revisiPenguji2 = Revisi::where('proposal_id', $mainProposalInfo->id)
                ->where('dosen_id', $mainProposalInfo->dosenPengujiSidangTA2->id)
                ->where('jenis_revisi', 'semhas')
                ->first();

            $revisiPembimbing1 = Revisi::where('proposal_id', $mainProposalInfo->id)
                ->where('dosen_id', $mainProposalInfo->dosenPembimbing1->id)
                ->where('jenis_revisi', 'semhas')
                ->first();
            $revisiPembimbing2 = Revisi::where('proposal_id', $mainProposalInfo->id)
                ->where('dosen_id', $mainProposalInfo->dosenPembimbing2->id)
                ->where('jenis_revisi', 'semhas')
                ->first();

            if (
                in_array(
                    3,
                    [
                        $mainProposalInfo->status_semhas_penguji_1_id,
                        $mainProposalInfo->status_semhas_penguji_2_id,
                        $mainProposalInfo->status_semhas_dosbing_1_id,
                        $mainProposalInfo->status_semhas_dosbing_2_id
                    ]
                )
            ) {
                $statusKelulusanSemhas = 3;     // 3 = Tidak Lulus
            } else if (
                in_array(
                    2,
                    [
                        $mainProposalInfo->status_semhas_penguji_1_id,
                        $mainProposalInfo->status_semhas_penguji_2_id,
                        $mainProposalInfo->status_semhas_dosbing_1_id,
                        $mainProposalInfo->status_semhas_dosbing_2_id
                    ]
                )
            ) {
                $statusKelulusanSemhas = 2;     // 2 = Lulus dengan revisi
            } else if (
                in_array(
                    1,
                    [
                        $mainProposalInfo->status_semhas_penguji_1_id,
                        $mainProposalInfo->status_semhas_penguji_2_id,
                        $mainProposalInfo->status_semhas_dosbing_1_id,
                        $mainProposalInfo->status_semhas_dosbing_2_id
                    ]
                )
            ) {
                $statusKelulusanSemhas = 1;     // 1 = Lulus tanpa revisi
            }

            $visible = VisibilitasNilai::where('tahap_id', $mainProposalInfo->tahap_id)
                ->where('periode_id', $mainProposalInfo->periode_id)
                ->where('jenis_nilai_seminar', 2) // 2 = Nilai Sidang Tugas Akhir
                ->first()
                ->visibilitas ?? false;
        } else {
            $isPengujiNotAssigned = true;
        }

        if (!is_null($revisiPenguji1)) {
            $patternLembarRevisiPenguji1 = '/seminar-hasil\/revisi\/lembar-revisi-penguji-1\/(.*)$/';
            $patternProposal = '/seminar-hasil\/revisi\/proposal\/(.*)$/';

            // Jalankan pencocokan RegEx
            preg_match($patternLembarRevisiPenguji1, $revisiPenguji1->file_lembar_revisi_dosen, $matchesLembarRevisiPenguji1);
            preg_match($patternProposal, $revisiPenguji1->file_proposal_revisi, $matchesProposal);

            if (isset($matchesLembarRevisiPenguji1[1]))
                $namaLembarRevisiPenguji1 = $matchesLembarRevisiPenguji1[1];
            if (isset($matchesProposal[1]))
                $namaProposal = $matchesProposal[1];
        }

        if (!is_null($revisiPenguji2)) {
            $patternLembarRevisiPenguji2 = '/seminar-hasil\/revisi\/lembar-revisi-penguji-2\/(.*)$/';

            // Jalankan pencocokan RegEx
            preg_match($patternLembarRevisiPenguji2, $revisiPenguji2->file_lembar_revisi_dosen, $matchesLembarRevisiPenguji2);

            if (isset($matchesLembarRevisiPenguji2[1]))
                $namaLembarRevisiPenguji2 = $matchesLembarRevisiPenguji2[1];
        }

        if (!is_null($revisiPembimbing1)) {
            $patternLembarRevisiPembimbing1 = '/seminar-hasil\/revisi\/lembar-revisi-pembimbing-1\/(.*)$/';

            // Jalankan pencocokan RegEx
            preg_match($patternLembarRevisiPembimbing1, $revisiPembimbing1->file_lembar_revisi_dosen, $matchesLembarRevisiPembimbing1);

            if (isset($matchesLembarRevisiPembimbing1[1]))
                $namaLembarRevisiPembimbing1 = $matchesLembarRevisiPembimbing1[1];
        }

        if (!is_null($revisiPembimbing2)) {
            $patternLembarRevisiPembimbing2 = '/seminar-hasil\/revisi\/lembar-revisi-pembimbing-2\/(.*)$/';

            // Jalankan pencocokan RegEx
            preg_match($patternLembarRevisiPembimbing2, $revisiPembimbing2->file_lembar_revisi_dosen, $matchesLembarRevisiPembimbing2);

            if (isset($matchesLembarRevisiPembimbing2[1]))
                $namaLembarRevisiPembimbing2 = $matchesLembarRevisiPembimbing2[1];
        }

        if (
            !is_null($revisiPenguji1) &&
            !is_null($revisiPenguji2) &&
            !is_null($revisiPembimbing1) &&
            !is_null($revisiPembimbing2)
        ) {
            if (
                $revisiPenguji1->status == "diterima" &&
                $revisiPenguji2->status == "diterima" &&
                $revisiPembimbing1->status == "diterima" &&
                $revisiPembimbing2->status == "diterima"
            ) {
                $statusRevisi = "Diterima";
            } else {
                $statusRevisi = "Pending";
            }
        }

        return view('mahasiswa.seminar-hasil.upload-revisi', compact([
            'mainProposalInfo',
            'revisiPenguji1',
            'revisiPenguji2',
            'revisiPembimbing1',
            'revisiPembimbing2',
            'namaProposal',
            'namaLembarRevisiPenguji1',
            'namaLembarRevisiPenguji2',
            'namaLembarRevisiPembimbing1',
            'namaLembarRevisiPembimbing2',
            'isPengujiNotAssigned',
            'statusKelulusanSemhas',
            'statusRevisi',
            'visible'
        ]));
    }

    public function storeUploadRevisi(Request $request)
    {
        $penguji1ID = $request->input('penguji_1_id');
        $penguji2ID = $request->input('penguji_2_id');
        $pembimbing1ID = $request->input('pembimbing_1_id');
        $pembimbing2ID = $request->input('pembimbing_2_id');

        $proposalID = $request->input('proposal_id');
        $fileLembarRevisiPenguji1 = $request->file('lembar_revisi_penguji_1');
        $fileLembarRevisiPenguji2 = $request->file('lembar_revisi_penguji_2');
        $fileLembarRevisiPembimbing1 = $request->file('lembar_revisi_pembimbing_1');
        $fileLembarRevisiPembimbing2 = $request->file('lembar_revisi_pembimbing_2');
        $fileProposalRevisi = $request->file('proposal_revisi');

        // rename file
        $nameLembarRevisiPenguji1 = uniqid() . '.' . $fileLembarRevisiPenguji1->getClientOriginalExtension();
        $nameLembarRevisiPenguji2 = uniqid() . '.' . $fileLembarRevisiPenguji2->getClientOriginalExtension();
        $nameLembarRevisiPembimbing1 = uniqid() . '.' . $fileLembarRevisiPembimbing1->getClientOriginalExtension();
        $nameLembarRevisiPembimbing2 = uniqid() . '.' . $fileLembarRevisiPembimbing2->getClientOriginalExtension();
        $nameProposalRevisi = uniqid() . '.' . $fileProposalRevisi->getClientOriginalExtension();

        $pathProposalRevisi = $fileProposalRevisi->storeAs(
            'seminar-hasil/revisi/proposal',
            $nameProposalRevisi,
            'local'
        );
        $pathLembarRevisiPenguji1 = $fileLembarRevisiPenguji1->storeAs(
            'seminar-hasil/revisi/lembar-revisi-penguji-1',
            $nameLembarRevisiPenguji1,
            'local'
        );
        $pathLembarRevisiPenguji2 = $fileLembarRevisiPenguji2->storeAs(
            'seminar-hasil/revisi/lembar-revisi-penguji-2',
            $nameLembarRevisiPenguji2,
            'local'
        );
        $pathLembarRevisiPembimbing1 = $fileLembarRevisiPembimbing1->storeAs(
            'seminar-hasil/revisi/lembar-revisi-pembimbing-1',
            $nameLembarRevisiPembimbing1,
            'local'
        );
        $pathLembarRevisiPembimbing2 = $fileLembarRevisiPembimbing2->storeAs(
            'seminar-hasil/revisi/lembar-revisi-pembimbing-2',
            $nameLembarRevisiPembimbing2,
            'local'
        );

        $revisiPenguji1 = Revisi::where('proposal_id', $proposalID)
            ->where('dosen_id', $penguji1ID)
            ->where('jenis_revisi', 'semhas')
            ->first();
        $revisiPenguji2 = Revisi::where('proposal_id', $proposalID)
            ->where('dosen_id', $penguji2ID)
            ->where('jenis_revisi', 'semhas')
            ->first();
        $revisiPembimbing1 = Revisi::where('proposal_id', $proposalID)
            ->where('dosen_id', $pembimbing1ID)
            ->where('jenis_revisi', 'semhas')
            ->first();
        $revisiPembimbing2 = Revisi::where('proposal_id', $proposalID)
            ->where('dosen_id', $pembimbing2ID)
            ->where('jenis_revisi', 'semhas')
            ->first();


        $revisiPenguji1->update([
            'file_proposal_revisi' => $pathProposalRevisi,
            'file_lembar_revisi_dosen' => $pathLembarRevisiPenguji1,
            "status" => "diterima"
        ]);
        $revisiPenguji2->update([
            'file_proposal_revisi' => $pathProposalRevisi,
            'file_lembar_revisi_dosen' => $pathLembarRevisiPenguji2,
            "status" => "diterima"
        ]);
        $revisiPembimbing1->update([
            'file_proposal_revisi' => $pathProposalRevisi,
            'file_lembar_revisi_dosen' => $pathLembarRevisiPembimbing1,
            "status" => "diterima"
        ]);
        $revisiPembimbing2->update([
            'file_proposal_revisi' => $pathProposalRevisi,
            'file_lembar_revisi_dosen' => $pathLembarRevisiPembimbing2,
            "status" => "diterima"
        ]);


        return redirect()->back()->with('success', 'Revisi Berhasil Diupload');
    }

    public function riwayat()
    {
        $data = PendaftaranSemhas::with('proposal.dosenPembimbing1', 'proposal.dosenPembimbing2', 'statusDaftarSeminar')
            ->whereHas('proposal.proposalMahasiswas', function ($query) {
                $query->where('mahasiswa_id', auth('mahasiswa')->user()->id)
                    ->where('status_proposal_mahasiswa_id', 1);
            })
            ->latest()
            ->get();

        return view('mahasiswa.seminar-hasil.riwayat', compact('data'));
    }
}
