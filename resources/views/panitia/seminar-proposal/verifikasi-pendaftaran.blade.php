@extends('panitia.home')

@section('content-panitia')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kelengkapan Data Mahasiswa</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    @if (session('success'))
        @include('notifications.success-alert', ['message' => session('success')])
    @endif

    <!-- Main con
    <div class="content">tent -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-4">
                        <div class="list-group-item mb-3">
                            <label class="form-label mb-1">Dosen Pembimbing 1</label>
                            <p>{{ $pendaftaranSemproInfo->proposal->proposalMahasiswas[0]->dosen->nama }}</p>

                            <label class="form-label mb-1">Dosen Pembimbing 2</label>
                            <p>Dosen Pembimbing 2 menyusul</p>

                            @if ($pendaftaranSemproInfo->proposal->prodi_id == 1)
                                <label class="form-label mb-1">Nama Mahasiswa 1</label>
                                <p>{{ $pendaftaranSemproInfo->proposal->proposalMahasiswas[0]->mahasiswa->nama }}</p>

                                <label class="form-label mb-1">Nama Mahasiswa 2</label>
                                <p>{{ $pendaftaranSemproInfo->proposal->proposalMahasiswas[1]->mahasiswa->nama }}</p>
                            @elseif($pendaftaranSemproInfo->proposal->prodi_id == 2)
                                <label class="form-label mb-1">Nama Mahasiswa</label>
                                <p>{{ $pendaftaranSemproInfo->proposal->proposalMahasiswas->first()->mahasiswa->nama }}</p>
                            @endif

                            <label class="form-label mb-1">Judul Proposal</label>
                            <p>{{ $pendaftaranSemproInfo->proposal->judul }}</p>

                            <label class="form-label mb-1">Bidang Keahlihan</label>
                            <p>{{ $pendaftaranSemproInfo->proposal->bidangMinat->bidang_minat }}</p>

                            <form
                                action="{{ route('panitia.seminar-proposal.update-verifikasi', $pendaftaranSemproInfo->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                {{-- Input verifikasi file proposal --}}
                                <label class="form-label mb-1">File Proposal .pdf</label>
                                <div class="container">
                                    <iframe src="{{ $pendaftaranSemproInfo->getPathProposalFile() }}" frameborder="2"
                                        width="88%" height="500px" scrolling="yes"></iframe>
                                </div>
                                <!-- Dropdown for File Proposal Status -->
                                <div class="mb-3">
                                    <select class="form-control" id="fileProposalStatus" name="statusProposal">
                                        <option @if ($pendaftaranSemproInfo->status_file_proposal == 1) selected @endif value="1">Diterima
                                        </option>
                                        <option @if ($pendaftaranSemproInfo->status_file_proposal == 0) selected @endif value="0">Ditolak
                                        </option>
                                    </select>
                                </div>
                                {{-- End input verifikasi file proposal --}}

                                {{-- Input verifikasi lembar konsultasi --}}
                                <label class="form-label mb-1">Lembar Konsultasi .pdf</label>
                                <div class="container">
                                    <iframe src="{{ $pendaftaranSemproInfo->getPathLembarKonsultasiFile() }}"
                                        frameborder="2" width="88%" height="500px" scrolling="yes"></iframe>
                                </div>
                                <!-- Dropdown for Lembar Konsultasi Status -->
                                <div class="mb-3">
                                    <select class="form-control" id="lembarKonsultasiStatus" name="statusLembarKonsultasi">
                                        <option @if ($pendaftaranSemproInfo->status_lembar_konsultasi == 1) selected @endif value="1">Diterima
                                        </option>
                                        <option @if ($pendaftaranSemproInfo->status_lembar_konsultasi == 0) selected @endif value="0">Ditolak
                                        </option>
                                    </select>
                                </div>
                                {{-- End input verifikasi lembar konsultasi --}}

                                {{-- Input verifikasi lembar kerjasama mitra --}}
                                <label class="form-label mb-1">Lembar Kerjasama Mitra .pdf</label>
                                <div class="container">
                                    <iframe src="{{ $pendaftaranSemproInfo->getPathLembarKerjaSamaMitraFile() }}"
                                        frameborder="2" width="88%" height="500px" scrolling="yes"></iframe>
                                </div>
                                <!-- Dropdown for Lembar Kerjasama Mitra Status -->
                                <div class="mb-3">
                                    <select class="form-control" id="lembarKerjasamaStatus" name="statusLembarKerjasama">
                                        <option @if ($pendaftaranSemproInfo->status_lembar_kerjasama_mitra == 1) selected @endif value="1">Diterima
                                        </option>
                                        <option @if ($pendaftaranSemproInfo->status_lembar_kerjasama_mitra == 0) selected @endif value="0">Ditolak
                                        </option>
                                    </select>
                                </div>
                                {{-- End input verifikasi lembar kerjasama mitra --}}

                                {{-- Input verifikasi bukti cek plagiasi --}}
                                <label class="form-label mb-1">Bukti Cek Plagiasi</label>
                                <div class="container">
                                    <img src="{{ $pendaftaranSemproInfo->getPathBuktiCekPlagiasiFile() }}" width="30%"
                                        alt="Bukti Cek Plagiasi">
                                </div>
                                <!-- Dropdown for Lembar Kerjasama Mitra Status -->
                                <div class="mb-3">
                                    <select class="form-control" id="lembarKerjasamaStatus" name="statusBuktiCekPlagiasi">
                                        <option @if ($pendaftaranSemproInfo->status_bukti_cek_plagiasi == 1) selected @endif value="1">Diterima
                                        </option>
                                        <option @if ($pendaftaranSemproInfo->status_bukti_cek_plagiasi == 0) selected @endif value="0">Ditolak
                                        </option>
                                    </select>
                                </div>
                                {{-- End input verifikasi bukti cek plagiasi --}}

                                <div class="mb-3">
                                    <label for="exampleDataList" class="form-label">Status Pendaftaran Sempro</label>
                                    <input
                                        class="form-control
                                        @if ($pendaftaranSemproInfo->status_daftar_sempro_id == 1) bg-success
                                        @elseif($pendaftaranSemproInfo->status_daftar_sempro_id == 2)
                                            bg-danger
                                        @elseif($pendaftaranSemproInfo->status_daftar_sempro_id == 3)
                                            bg-warning @endif
                                    "
                                        value="{{ $pendaftaranSemproInfo->statusDaftarSempro->status }}"
                                        list="datalistOptions" id="exampleDataList" disabled />
                                </div>

                                <button type="submit"
                                    onclick="
                                    // confirm
                                    if (confirm('Yakin update verifikasi daftar sempro?')) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                "
                                    class="btn btn-primary btn-block
                                    @if ($pendaftaranSemproInfo->status_daftar_sempro_id == 1) disabled @endif
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
