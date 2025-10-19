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
                            <p>{{ $pendaftaranSemproInfo->proposal->proposalMahasiswas[1]->mahasiswa->nama ?? '-' }}</p>
                        @elseif($pendaftaranSemproInfo->proposal->prodi_id == 2)
                            <label class="form-label mb-1">Nama Mahasiswa</label>
                            <p>{{ $pendaftaranSemproInfo->proposal->proposalMahasiswas->first()->mahasiswa->nama }}</p>
                        @endif

                        <label class="form-label mb-1">Judul Proposal</label>
                        <p>{{ $pendaftaranSemproInfo->proposal->judul }}</p>

                        <label class="form-label mb-1">Bidang Keahlihan</label>
                        <p>{{ $pendaftaranSemproInfo->proposal->bidangMinat->bidang_minat }}</p>

                        <form action="{{ route('panitia.seminar-proposal.update-verifikasi', $pendaftaranSemproInfo->id) }}"
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
                                <label class="form-label d-block fw-bold">Status File Proposal</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusProposal"
                                        id="statusProposalTolak" value="0"
                                        {{ $pendaftaranSemproInfo->status_file_proposal == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-semibold" for="statusProposalTolak">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusProposal"
                                        id="statusProposalTerima" value="1"
                                        {{ $pendaftaranSemproInfo->status_file_proposal == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-semibold" for="statusProposalTerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </label>
                                </div>
                            </div>

                            {{-- End input verifikasi file proposal --}}

                            {{-- Input verifikasi lembar konsultasi --}}
                            <label class="form-label mb-1">Lembar Konsultasi .pdf</label>
                            <div class="container">
                                <iframe src="{{ $pendaftaranSemproInfo->getPathLembarKonsultasiFile() }}" frameborder="2"
                                    width="88%" height="500px" scrolling="yes"></iframe>
                            </div>
                            <!-- Dropdown for Lembar Konsultasi Status -->
                            <div class="mb-3">
                                <label class="form-label d-block fw-bold">Status Lembar Konsultasi</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio"
                                        name="statusLembarKonsultasi" id="statusDitolak" value="0"
                                        {{ $pendaftaranSemproInfo->status_lembar_konsultasi == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-semibold" for="statusDitolak">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio"
                                        name="statusLembarKonsultasi" id="statusDiterima" value="1"
                                        {{ $pendaftaranSemproInfo->status_lembar_konsultasi == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-semibold" for="statusDiterima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </label>
                                </div>
                            </div>

                            {{-- End input verifikasi lembar konsultasi --}}

                            {{-- Input verifikasi lembar kerjasama mitra --}}
                            @if ($pendaftaranSemproInfo->proposal->jenis_judul_id == 2)
                                <label class="form-label mb-1">Lembar Kerjasama Mitra .pdf</label>
                                <div class="container">
                                    <iframe src="{{ $pendaftaranSemproInfo->getPathLembarKerjaSamaMitraFile() }}"
                                        frameborder="2" width="88%" height="500px" scrolling="yes"></iframe>
                                </div>
                                <!-- Dropdown for Lembar Kerjasama Mitra Status -->
                                <div class="mb-3">
                                    <label class="form-label d-block fw-bold">Status Lembar Kerjasama Mitra</label>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input status-radio" type="radio"
                                            name="statusLembarKerjasama" id="statusKerjasamaTolak" value="0"
                                            {{ $pendaftaranSemproInfo->status_lembar_kerjasama_mitra == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label text-danger fw-semibold" for="statusKerjasamaTolak">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input status-radio" type="radio"
                                            name="statusLembarKerjasama" id="statusKerjasamaTerima" value="1"
                                            {{ $pendaftaranSemproInfo->status_lembar_kerjasama_mitra == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label text-success fw-semibold"
                                            for="statusKerjasamaTerima">
                                            <i class="bi bi-check-circle"></i> Terima
                                        </label>
                                    </div>
                                </div>
                            @endif
                            {{-- End input verifikasi lembar kerjasama mitra --}}

                            {{-- Input verifikasi bukti cek plagiasi --}}
                            <label class="form-label mb-1">Bukti Cek Plagiasi</label>
                            <div class="container">
                                <img src="{{ $pendaftaranSemproInfo->getPathBuktiCekPlagiasiFile() }}" width="30%"
                                    alt="Bukti Cek Plagiasi">
                            </div>
                            <!-- Dropdown for Lembar Kerjasama Mitra Status -->
                            <div class="mb-3">
                                <label class="form-label d-block fw-bold">Status Bukti Cek Plagiasi</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio"
                                        name="statusBuktiCekPlagiasi" id="statusPlagiasiTolak" value="0"
                                        {{ $pendaftaranSemproInfo->status_bukti_cek_plagiasi == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-semibold" for="statusPlagiasiTolak">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio"
                                        name="statusBuktiCekPlagiasi" id="statusPlagiasiTerima" value="1"
                                        {{ $pendaftaranSemproInfo->status_bukti_cek_plagiasi == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-semibold" for="statusPlagiasiTerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </label>
                                </div>
                            </div>
                            {{-- End input verifikasi bukti cek plagiasi --}}

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terimaSemuaDokumen">
                                    <label class="form-check-label fw-bold text-success" for="terimaSemuaDokumen">
                                        <i class="bi bi-check2-square"></i> Terima Semua Dokumen Syarat Pendaftaran
                                    </label>
                                </div>
                            </div>

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

                            <a href="{{ route('panitia.seminar-proposal.pendaftaran-detail', ['tahapId' => $pendaftaranSemproInfo->proposal->tahap_id]) }}"
                                class="btn btn-info mt-2">
                                Kembali
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const terimaSemuaCheckbox = document.getElementById('terimaSemuaDokumen');
        const semuaRadio = document.querySelectorAll('.status-radio');

        terimaSemuaCheckbox.addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.status-radio[value="1"]').forEach(r => r.checked = true);
            }
        });

        semuaRadio.forEach(radio => {
            radio.addEventListener('change', function() {
                const semuaTerima = Array.from(semuaRadio).every(r => r.value == "1" ? r.checked : true);
                terimaSemuaCheckbox.checked = semuaTerima;
            });
        });

        window.addEventListener('load', function() {
            const semuaTerima = Array.from(semuaRadio).every(r => r.value == "1" ? r.checked : true);
            terimaSemuaCheckbox.checked = semuaTerima;
        });
    </script>
@endsection
