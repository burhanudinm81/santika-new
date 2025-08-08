<?php

namespace App\Http\Controllers\Dosen\SeminarHasil;

use App\Http\Controllers\Controller;
use App\Models\NilaiAkhirMahasiswa;
use App\Models\Proposal;
use App\Models\Revisi;
use App\Models\StatusProposal;
use Illuminate\Http\Request;

class PenilaianSemhasController extends Controller
{
    public function showInputPenilaianSementara($proposal_id)
    {
        $prevRevisi = null;

        $proposal = Proposal::findOrFail($proposal_id);
        $listMahasiswa = $proposal->proposalMahasiswas()->with(['dosen', 'mahasiswa'])->get();

        $listStatusPenilaian = StatusProposal::all();
        // dd($listMahasiswa[1]->mahasiswa->nama);

        $prevRevisi = Revisi::where('proposal_id', $proposal_id)
            ->where('jenis_revisi', 'semhas')
            ->get();

        if (count($prevRevisi) > 0) {
            $prevRevisi = Revisi::with('dosen')->where('proposal_id', $proposal_id)->where('dosen_id', auth('dosen')->user()->id)->first();
        } else {
            $prevRevisi = null;
        }

        return view('dosen.penilaian.semhas.penilaian-sementara-semhas', compact([
            'proposal',
            'listMahasiswa',
            'listStatusPenilaian',
            'prevRevisi'
        ]));
    }

    public function showInputPenilaianAkhir($proposal_id)
    {
        $currentDosenInfo = null;
        $roleDosen = null;
        $nilaiAkhirMahasiswa1 = null;
        $nilaiAkhirMahasiswa2 = null;

        $mainProposal = Proposal::with(['statusSemhasTotal', 'proposalMahasiswas', 'dosenPembimbing1', 'dosenPembimbing2', 'dosenPengujiSidangTA1', 'dosenPengujiSidangTA2'])
            ->where('id', $proposal_id)
            ->first();

        if ($mainProposal->dosenPembimbing1->id == auth('dosen')->user()->id) {
            $roleDosen = 'Dosen Pembimbing 1';
            $currentDosenInfo = $mainProposal->dosenPembimbing1;
        } else if ($mainProposal->dosenPembimbing2->id == auth('dosen')->user()->id) {
            $roleDosen = 'Dosen Pembimbing 2';
            $currentDosenInfo = $mainProposal->dosenPembimbing2;
        } else if ($mainProposal->dosenPengujiSidangTA1->id == auth('dosen')->user()->id) {
            $roleDosen = 'Dosen Penguji Sidang TA 1';
            $currentDosenInfo = $mainProposal->dosenPengujiSidangTA1;
        } else if ($mainProposal->dosenPengujiSidangTA2->id == auth('dosen')->user()->id) {
            $roleDosen = 'Dosen Penguji Sidang TA 2';
            $currentDosenInfo = $mainProposal->dosenPengujiSidangTA2;
        }

        $nilaiAkhirMahasiswa1 = NilaiAkhirMahasiswa::where('proposal_id', $proposal_id)
            ->where('mahasiswa_id', $mainProposal->proposalMahasiswas[0]->mahasiswa->id)
            ->first();

        if ($mainProposal->prodi_id == 1) {
            $nilaiAkhirMahasiswa2 = NilaiAkhirMahasiswa::where('proposal_id', $proposal_id)
                ->where('mahasiswa_id', $mainProposal->proposalMahasiswas[1]->mahasiswa->id)
                ->first();
        }

        return view(
            'dosen.penilaian.semhas.penilaian-akhir-semhas',
            compact(['mainProposal', 'currentDosenInfo', 'roleDosen', 'nilaiAkhirMahasiswa1', 'nilaiAkhirMahasiswa2'])
        );
    }

    public function updatePenilaianSementara(Request $request)
    {
        // ambil value dari request
        $proposalId = $request->input('proposal_id');
        $dosenId = $request->input('dosen_id');
        $statusPenilaianSementara = $request->input('status_penilaian_sementara');
        $catatanRevisiAkhir = $request->input('catatan_revisi_akhir');

        // cek apakah revisi yang dibuat dosen saat ini sebelumnya sudah dibuat
        $prevRevisi = Revisi::where('proposal_id', $proposalId)
            ->where('dosen_id', $dosenId)
            ->where('jenis_revisi', 'semhas')
            ->first();
        // dd($prevRevisi);

        if ($prevRevisi == null) { //  jika null, artinya revisi belum dibuat
            // buat data revisi baru
            Revisi::create([
                'proposal_id' => $proposalId,
                'dosen_id' => $dosenId,
                'catatan_revisi' => $catatanRevisiAkhir,
                'jenis_revisi' => 'semhas',
            ]);
        } else {
            // update revisi sebelumnya yang sudah dibuat
            $prevRevisi->update([
                'catatan_revisi' => $catatanRevisiAkhir,
            ]);
        }

        // cek dosen yang sekarang mengisi revisi itu sebagai dospem 1 atau 2
        $levelDospem = 0;
        $proposalInfo = Proposal::findOrFail($proposalId);

        if ($proposalInfo->penguji_sidang_ta_1_id == auth('dosen')->user()->id) { // pengecekan apakah dosen yang sekarang mengisi revisi itu adalah dospem 1
            $levelDospem = 1;
        } else if ($proposalInfo->penguji_sidang_ta_2_id == auth('dosen')->user()->id) { // pengecekan apakah dosen yang sekarang mengisi revisi itu adalah dospem 2
            $levelDospem = 2;
        }

        if ($levelDospem != 0) { // update status penilaian sempro berdasarkan dosen penguji (penguji 1 atau 2)
            if ($levelDospem == 1) {
                $proposalInfo->update([
                    'status_semhas_penguji_1_id' => $statusPenilaianSementara,
                ]);
            } else if ($levelDospem == 2) {
                $proposalInfo->update([
                    'status_semhas_penguji_2_id' => $statusPenilaianSementara,
                ]);
            }
        }

        if ($proposalInfo->status_semhas_penguji_1_id != null && $proposalInfo->status_semhas_penguji_2_id != null) {
            if ($proposalInfo->status_semhas_penguji_2_id == 3 || $proposalInfo->status_semhas_penguji_2_id == 3) {
                $proposalInfo->update(['status_semhas_proposal_id' => 3]);
            } else if ($proposalInfo->status_semhas_penguji_2_id == 2 || $proposalInfo->status_semhas_penguji_2_id == 2) {
                $proposalInfo->update(['status_semhas_proposal_id' => 2]);
            } else if ($proposalInfo->status_semhas_penguji_2_id == 1 || $proposalInfo->status_semhas_penguji_2_id == 1) {
                $proposalInfo->update(['status_semhas_proposal_id' => 1]);
            }
        }

        return redirect()->back()->with('success', 'Penilaian Sementara Semhas berhasil disimpan.');
    }

    public function updatePenilaianAkhir(Request $request)
    {
        $proposalId = $request->input('proposal_id');
        $prodiId = $request->input('prodi_id');
        $roleDosen = $request->input('role_dosen');
        $mahasiswa1Id = $request->input('mahasiswa1_id');
        $mahasiswa2Id = $request->input('mahasiswa2_id');

        $currentProposal = Proposal::findOrFail($proposalId);

        // cek prodi
        $nilaiSikap1 = $request->input('sikap1');
        $nilaiKemampuan1 = $request->input('kemampuan1');
        $nilaiHasilKarya1 = $request->input('hasil_karya1');
        $nilaiLaporan1 = $request->input('laporan1');
        $nilaiRataRata1 = $request->input('rata_rata1');

        if ($prodiId == 1) {
            $nilaiSikap2 = $request->input('sikap2');
            $nilaiKemampuan2 = $request->input('kemampuan2');
            $nilaiHasilKarya2 = $request->input('hasil_karya2');
            $nilaiLaporan2 = $request->input('laporan2');
            $nilaiRataRata2 = $request->input('rata_rata2');
        }

        // cek data nilai akhir mahasiswa
        $nilaiAkhirMahasiswa1 = NilaiAkhirMahasiswa::where('proposal_id', $proposalId)->where('mahasiswa_id', $mahasiswa1Id)->first();
        if ($nilaiAkhirMahasiswa1 == null) {
            $nilaiAkhirMahasiswa1 = NilaiAkhirMahasiswa::create([
                'proposal_id' => $proposalId,
                'mahasiswa_id' => $mahasiswa1Id,
            ]);
        }

        if ($prodiId == 1) {
            $nilaiAkhirMahasiswa2 = NilaiAkhirMahasiswa::where('proposal_id', $proposalId)->where('mahasiswa_id', $mahasiswa2Id)->first();
            if ($nilaiAkhirMahasiswa2 == null) {
                $nilaiAkhirMahasiswa2 = NilaiAkhirMahasiswa::create([
                    'proposal_id' => $proposalId,
                    'mahasiswa_id' => $mahasiswa2Id,
                ]);
            }
        }

        // cek role dosen yang saat ini mengisi penilaian
        if ($roleDosen == 'Dosen Pembimbing 1') {
            $nilaiAkhirMahasiswa1->update([
                'nilai_sikap_pemb1' => $nilaiSikap1 ?? $nilaiAkhirMahasiswa1->nilai_sikap_pemb1,
                'nilai_kemampuan_pemb1' => $nilaiKemampuan1 ?? $nilaiAkhirMahasiswa1->nilai_kemampuan_pemb1,
                'nilai_hasilKarya_pemb1' => $nilaiHasilKarya1 ?? $nilaiAkhirMahasiswa1->nilai_hasilKarya_pemb1,
                'nilai_laporan_pemb1' => $nilaiLaporan1 ?? $nilaiAkhirMahasiswa1->nilai_laporan_pemb1,
                'avg_nilai_dospem1' => $nilaiRataRata1 ?? $nilaiAkhirMahasiswa1->avg_nilai_dospem1,
            ]);

            if ($prodiId == 1) {
                $nilaiAkhirMahasiswa2->update([
                    'nilai_sikap_pemb1' => $nilaiSikap2 ?? $nilaiAkhirMahasiswa2->nilai_sikap_pemb1,
                    'nilai_kemampuan_pemb1' => $nilaiKemampuan2 ?? $nilaiAkhirMahasiswa2->nilai_kemampuan_pemb1,
                    'nilai_hasilKarya_pemb1' => $nilaiHasilKarya2 ?? $nilaiAkhirMahasiswa2->nilai_hasilKarya_pemb1,
                    'nilai_laporan_pemb1' => $nilaiLaporan2 ?? $nilaiAkhirMahasiswa2->nilai_laporan_pemb1,
                    'avg_nilai_dospem1' => $nilaiRataRata2 ?? $nilaiAkhirMahasiswa2->avg_nilai_dospem1,
                ]);
            }
        } else if ($roleDosen == 'Dosen Pembimbing 2') {
            $nilaiAkhirMahasiswa1->update([
                'nilai_sikap_pemb2' => $nilaiSikap1 ?? $nilaiAkhirMahasiswa1->nilai_sikap_pemb2,
                'nilai_kemampuan_pemb2' => $nilaiKemampuan1 ?? $nilaiAkhirMahasiswa1->nilai_kemampuan_pemb2,
                'nilai_hasilKarya_pemb2' => $nilaiHasilKarya1 ?? $nilaiAkhirMahasiswa1->nilai_hasilKarya_pemb2,
                'nilai_laporan_pemb2' => $nilaiLaporan1 ?? $nilaiAkhirMahasiswa1->nilai_laporan_pemb2,
                'avg_nilai_dospem2' => $nilaiRataRata1 ?? $nilaiAkhirMahasiswa1->avg_nilai_dospem2,
            ]);

            if ($prodiId == 1) {
                $nilaiAkhirMahasiswa2->update([
                    'nilai_sikap_pemb2' => $nilaiSikap2 ?? $nilaiAkhirMahasiswa2->nilai_sikap_pemb2,
                    'nilai_kemampuan_pemb2' => $nilaiKemampuan2 ?? $nilaiAkhirMahasiswa2->nilai_kemampuan_pemb2,
                    'nilai_hasilKarya_pemb2' => $nilaiHasilKarya2 ?? $nilaiAkhirMahasiswa2->nilai_hasilKarya_pemb2,
                    'nilai_laporan_pemb2' => $nilaiLaporan2 ?? $nilaiAkhirMahasiswa2->nilai_laporan_pemb2,
                    'avg_nilai_dospem2' => $nilaiRataRata2 ?? $nilaiAkhirMahasiswa2->avg_nilai_dospem2,
                ]);
            }
        } else if ($roleDosen == 'Dosen Penguji Sidang TA 1') {
            $nilaiAkhirMahasiswa1->update([
                'nilai_sikap_peng1' => $nilaiSikap1 ?? $nilaiAkhirMahasiswa1->nilai_sikap_peng1,
                'nilai_kemampuan_peng1' => $nilaiKemampuan1 ?? $nilaiAkhirMahasiswa1->nilai_kemampuan_peng1,
                'nilai_hasilKarya_peng1' => $nilaiHasilKarya1 ?? $nilaiAkhirMahasiswa1->nilai_hasilKarya_peng1,
                'nilai_laporan_peng1' => $nilaiLaporan1 ?? $nilaiAkhirMahasiswa1->nilai_laporan_peng1,
                'avg_nilai_penguji1' => $nilaiRataRata1 ?? $nilaiAkhirMahasiswa1->avg_nilai_penguji1,
            ]);

            if ($prodiId == 1) {
                $nilaiAkhirMahasiswa2->update([
                    'nilai_sikap_peng1' => $nilaiSikap2 ?? $nilaiAkhirMahasiswa2->nilai_sikap_peng1,
                    'nilai_kemampuan_peng1' => $nilaiKemampuan2 ?? $nilaiAkhirMahasiswa2->nilai_kemampuan_peng1,
                    'nilai_hasilKarya_peng1' => $nilaiHasilKarya2 ?? $nilaiAkhirMahasiswa2->nilai_hasilKarya_peng1,
                    'nilai_laporan_peng1' => $nilaiLaporan2 ?? $nilaiAkhirMahasiswa2->nilai_laporan_peng1,
                    'avg_nilai_penguji1' => $nilaiRataRata2 ?? $nilaiAkhirMahasiswa2->avg_nilai_penguji1,
                ]);
            }
        }else if ($roleDosen == 'Dosen Penguji Sidang TA 2') {
            $nilaiAkhirMahasiswa1->update([
                'nilai_sikap_peng2' => $nilaiSikap1 ?? $nilaiAkhirMahasiswa1->nilai_sikap_peng2,
                'nilai_kemampuan_peng2' => $nilaiKemampuan1 ?? $nilaiAkhirMahasiswa1->nilai_kemampuan_peng2,
                'nilai_hasilKarya_peng2' => $nilaiHasilKarya1 ?? $nilaiAkhirMahasiswa1->nilai_hasilKarya_peng2,
                'nilai_laporan_peng2' => $nilaiLaporan1 ?? $nilaiAkhirMahasiswa1->nilai_laporan_peng2,
                'avg_nilai_penguji2' => $nilaiRataRata1 ?? $nilaiAkhirMahasiswa1->avg_nilai_penguji2,
            ]);

            if ($prodiId == 1) {
                $nilaiAkhirMahasiswa2->update([
                    'nilai_sikap_peng2' => $nilaiSikap2 ?? $nilaiAkhirMahasiswa2->nilai_sikap_peng2,
                    'nilai_kemampuan_peng2' => $nilaiKemampuan2 ?? $nilaiAkhirMahasiswa2->nilai_kemampuan_peng2,
                    'nilai_hasilKarya_peng2' => $nilaiHasilKarya2 ?? $nilaiAkhirMahasiswa2->nilai_hasilKarya_peng2,
                    'nilai_laporan_peng2' => $nilaiLaporan2 ?? $nilaiAkhirMahasiswa2->nilai_laporan_peng2,
                    'avg_nilai_penguji2' => $nilaiRataRata2 ?? $nilaiAkhirMahasiswa2->avg_nilai_penguji2,
                ]);
            }
        }

        // hitung nilai total dospem
        if ($nilaiAkhirMahasiswa1->avg_nilai_dospem1 != null && $nilaiAkhirMahasiswa1->avg_nilai_dospem2 != null) {
            $nilaiAkhirMahasiswa1->update([
                'avg_nilai_totalDospem' => ($nilaiAkhirMahasiswa1->avg_nilai_dospem1 + $nilaiAkhirMahasiswa1->avg_nilai_dospem2) / 2,
            ]);
        }
        if ($prodiId == 1) {
            if ($nilaiAkhirMahasiswa2->avg_nilai_dospem1 != null && $nilaiAkhirMahasiswa2->avg_nilai_dospem2 != null) {
                $nilaiAkhirMahasiswa2->update([
                    'avg_nilai_totalDospem' => ($nilaiAkhirMahasiswa2->avg_nilai_dospem1 + $nilaiAkhirMahasiswa2->avg_nilai_dospem2) / 2,
                ]);
            }
        }

        // hitung nilai total penguji
        if ($nilaiAkhirMahasiswa1->avg_nilai_penguji1 != null && $nilaiAkhirMahasiswa1->avg_nilai_penguji2 != null) {
            $nilaiAkhirMahasiswa1->update([
                'avg_nilai_totalPenguji' => ($nilaiAkhirMahasiswa1->avg_nilai_penguji1 + $nilaiAkhirMahasiswa1->avg_nilai_penguji2) / 2,
            ]);
        }
        if ($prodiId == 1) {
            if ($nilaiAkhirMahasiswa2->avg_nilai_penguji1 != null && $nilaiAkhirMahasiswa2->avg_nilai_penguji2 != null) {
                $nilaiAkhirMahasiswa2->update([
                    'avg_nilai_totalPenguji' => ($nilaiAkhirMahasiswa2->avg_nilai_penguji1 + $nilaiAkhirMahasiswa2->avg_nilai_penguji2) / 2,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Penilaian Akhir Semhas berhasil disimpan.');
    }
}
