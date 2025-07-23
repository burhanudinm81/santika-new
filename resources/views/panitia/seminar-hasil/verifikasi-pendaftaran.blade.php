@extends('panitia.home')

@section('content-panitia')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kelengkapan Pendaftaran Seminar Hasil</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    @if (session('success'))
        @include('notifications.success-alert', ['message' => session('success')])
    @endif

    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline mb-4">
                    <div class="list-group-item mb-3">
                        <label class="form-label mb-1">Dosen Pembimbing 1</label>
                        <p>{{ $pendaftaranSemhasInfo->proposal->proposalMahasiswas[0]->dosen->nama }}</p>

                        <label class="form-label mb-1">Dosen Pembimbing 2</label>
                        <p>Dosen Pembimbing 2 menyusul</p>

                        @if ($pendaftaranSemhasInfo->proposal->prodi_id == 1)
                            <label class="form-label mb-1">Nama Mahasiswa 1</label>
                            <p>{{ $pendaftaranSemhasInfo->proposal->proposalMahasiswas[0]->mahasiswa->nama }}</p>

                            <label class="form-label mb-1">Nama Mahasiswa 2</label>
                            <p>{{ $pendaftaranSemhasInfo->proposal->proposalMahasiswas[1]->mahasiswa->nama }}</p>
                        @elseif($pendaftaranSemhasInfo->proposal->prodi_id == 2)
                            <label class="form-label mb-1">Nama Mahasiswa</label>
                            <p>{{ $pendaftaranSemhasInfo->proposal->proposalMahasiswas->first()->mahasiswa->nama }}</p>
                        @endif

                        <label class="form-label mb-1">Judul Proposal</label>
                        <p>{{ $pendaftaranSemhasInfo->proposal->judul }}</p>

                        <label class="form-label mb-1">Bidang Keahlihan</label>
                        <p>{{ $pendaftaranSemhasInfo->proposal->bidangMinat->bidang_minat }}</p>

                        <form action="{{ route('panitia.seminar-hasil.update-verifikasi', $pendaftaranSemhasInfo->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Input verifikasi surat rekomendasi --}}
                            <label class="form-label mb-1">Surat Rekomendasi Pembimbing .pdf</label>
                            <div class="container">
                                <iframe src="{{ $pendaftaranSemhasInfo->getPathSuratRekom() }}" frameborder="2"
                                    width="88%" height="500px" scrolling="yes"></iframe>
                                </iframe>
                            </div>
                            <!-- Dropdown for File surat rekomendasi -->
                            <div class="mb-3">
                                <select class="form-control" id="fileProposalStatus" name="statusRekomDospem">
                                    <option @if ($pendaftaranSemhasInfo->status_file_rekom_dosen == 1) selected @endif value="1">Diterima
                                    </option>
                                    <option @if ($pendaftaranSemhasInfo->status_file_rekom_dosen == 0) selected @endif value="0">Ditolak
                                    </option>
                                </select>
                            </div>
                            {{-- End input verifikasi surat rekomendasi --}}

                            {{-- Input verifikasi file proposal --}}
                            <label class="form-label mb-1">File Proposal .pdf</label>
                            <div class="container">
                                <iframe src="{{ $pendaftaranSemhasInfo->getPathProposalSemhas() }}" frameborder="2"
                                    width="88%" height="500px" scrolling="yes"></iframe>
                            </div>
                            <!-- Dropdown for File Proposal Status -->
                            <div class="mb-3">
                                <select class="form-control" id="fileProposalStatus" name="statusProposalSemhas">
                                    <option @if ($pendaftaranSemhasInfo->status_file_proposal_semhas == 1) selected @endif value="1">Diterima
                                    </option>
                                    <option @if ($pendaftaranSemhasInfo->status_file_proposal_semhas == 0) selected @endif value="0">Ditolak
                                    </option>
                                </select>
                            </div>
                            {{-- End input verifikasi file proposal --}}

                            {{-- Input verifikasi draft jurnal --}}
                            <label class="form-label mb-1">Draft Jurnal .pdf</label>
                            <div class="container">
                                <iframe src="{{ $pendaftaranSemhasInfo->getPathDraftJurnal() }}" frameborder="2"
                                    width="88%" height="500px" scrolling="yes"></iframe>
                            </div>
                            <!-- Dropdown for draft jurnal -->
                            <div class="mb-3">
                                <select class="form-control" id="lembarKonsultasiStatus" name="statusDraftJurnal">
                                    <option @if ($pendaftaranSemhasInfo->status_file_draft_jurnal == 1) selected @endif value="1">Diterima
                                    </option>
                                    <option @if ($pendaftaranSemhasInfo->status_file_draft_jurnal == 0) selected @endif value="0">Ditolak
                                    </option>
                                </select>
                            </div>
                            {{-- End input verifikasi draft jurnal --}}

                            {{-- Input verifikasi surat ia mitra --}}
                            <label class="form-label mb-1">Surat IA Mitra .pdf</label>
                            <div class="container">
                                <iframe src="{{ $pendaftaranSemhasInfo->getPathIAMitra() }}" frameborder="2" width="88%"
                                    height="500px" scrolling="yes"></iframe>
                            </div>
                            <!-- Dropdown for surat ia mitra -->
                            {{-- <div class="mb-3">
                                <select class="form-control" id="lembarKerjasamaStatus" name="statusLembarKerjasama">
                                    <option  value="1">Diterima
                                    </option>
                                    <option value="0">Ditolak
                                    </option>
                                </select>
                            </div> --}}
                            {{-- End input verifikasi surat ia mitra --}}

                            {{-- Input verifikasi bebas tanggungan pkl --}}
                            <label class="form-label mb-1">Surat Bebas Tanggungan PKL</label>
                            <div class="container">
                                <iframe src="{{ $pendaftaranSemhasInfo->getPathBebasTanggunganPkl() }}" frameborder="2"
                                    width="88%" height="500px" scrolling="yes"></iframe>
                            </div>
                            <!-- Dropdown for bebas tanggungan pkl-->
                            <div class="mb-3">
                                <select class="form-control" id="lembarKerjasamaStatus" name="statusBebasTanggunganPkl">
                                    <option @if ($pendaftaranSemhasInfo->status_file_bebas_tanggungan_pkl == 1) selected @endif value="1">Diterima
                                    </option>
                                    <option @if ($pendaftaranSemhasInfo->status_file_bebas_tanggungan_pkl == 0) selected @endif value="0">Ditolak
                                    </option>
                                </select>
                            </div>
                            {{-- End input verifikasi bebas tanggungan pkl --}}

                            {{-- Input verifikasi skla --}}
                            <label class="form-label mb-1">Surat Keterangan Lulus Akademik (SKLA)</label>
                            <div class="container">
                                <iframe src="{{ $pendaftaranSemhasInfo->getPathSkla() }}" frameborder="2" width="88%"
                                    height="500px" scrolling="yes"></iframe>
                            </div>
                            <!-- Dropdown for skla-->
                            <div class="mb-3">
                                <select class="form-control" id="lembarKerjasamaStatus" name="statusSKLA">
                                    <option @if ($pendaftaranSemhasInfo->status_skla == 1) selected @endif value="1">Diterima
                                    </option>
                                    <option @if ($pendaftaranSemhasInfo->status_skla == 0) selected @endif value="0">Ditolak
                                    </option>
                                </select>
                            </div>
                            {{-- End input verifikasi skla --}}


                            <div class="mb-3">
                                <label for="exampleDataList" class="form-label">Status Pendaftaran Semhas</label>
                                <input
                                    class="form-control
                                        @if ($pendaftaranSemhasInfo->status_daftar_semhas_id == 1) bg-success
                                        @elseif($pendaftaranSemhasInfo->status_daftar_semhas_id == 2)
                                            bg-danger
                                        @elseif($pendaftaranSemhasInfo->status_daftar_semhas_id == 3)
                                            bg-warning @endif
                                    "
                                    value="{{ $pendaftaranSemhasInfo->statusDaftarSeminar->status }}"
                                    list="datalistOptions" id="exampleDataList" disabled />
                            </div>

                            <button type="submit"
                                onclick="
                                    // confirm
                                    if (confirm('Yakin update verifikasi daftar semhas?')) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                 "
                                class="btn btn-primary btn-block
                                    @if ($pendaftaranSemhasInfo->status_daftar_semhas_id == 1) disabled @endif
                                    ">Simpan</button>

                            <a href="{{ url()->previous() }}" class="btn btn-info mt-2">Kembali</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
