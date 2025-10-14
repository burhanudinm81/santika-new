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
                                <label class="form-label d-block fw-bold">Status File Rekomendasi Dosen</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusRekomDospem"
                                        id="statusRekomTolak" value="0"
                                        {{ $pendaftaranSemhasInfo->status_file_rekom_dosen == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-semibold" for="statusRekomTolak">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusRekomDospem"
                                        id="statusRekomTerima" value="1"
                                        {{ $pendaftaranSemhasInfo->status_file_rekom_dosen == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-semibold" for="statusRekomTerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </label>
                                </div>
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
                                <label class="form-label d-block fw-bold">Status File Proposal Sidang Akhir</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusProposalSemhas"
                                        id="statusProposalSemhasTolak" value="0"
                                        {{ $pendaftaranSemhasInfo->status_file_proposal_semhas == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-semibold" for="statusProposalSemhasTolak">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusProposalSemhas"
                                        id="statusProposalSemhasTerima" value="1"
                                        {{ $pendaftaranSemhasInfo->status_file_proposal_semhas == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-semibold"
                                        for="statusProposalSemhasTerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </label>
                                </div>
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
                                <label class="form-label d-block fw-bold">Status File Draft Jurnal Sidang Akhir</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusDraftJurnal"
                                        id="statusDraftJurnalTolak" value="0"
                                        {{ $pendaftaranSemhasInfo->status_file_draft_jurnal == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-semibold" for="statusDraftJurnalTolak">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusDraftJurnal"
                                        id="statusDraftJurnalTerima" value="1"
                                        {{ $pendaftaranSemhasInfo->status_file_draft_jurnal == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-semibold" for="statusDraftJurnalTerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </label>
                                </div>
                            </div>
                            {{-- End input verifikasi draft jurnal --}}

                            {{-- Input verifikasi surat ia mitra --}}
                            <label class="form-label mb-1">Surat IA Mitra .pdf</label>
                            <div class="container">
                                <iframe src="{{ $pendaftaranSemhasInfo->getPathIAMitra() }}" frameborder="2"
                                    width="88%" height="500px" scrolling="yes"></iframe>
                            </div>
                            <!-- Dropdown for surat ia mitra -->
                            {{-- <div class="mb-3">
                                <label class="form-label d-block fw-bold">Status Lembar Kerjasama Sidang Akhir</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio"
                                        name="statusLembarKerjasama" id="statusLembarKerjasamaTolak" value="0">
                                    <label class="form-check-label text-danger fw-semibold"
                                        for="statusLembarKerjasamaTolak">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio"
                                        name="statusLembarKerjasama" id="statusLembarKerjasamaTerima" value="1">
                                    <label class="form-check-label text-success fw-semibold"
                                        for="statusLembarKerjasamaTerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </label>
                                </div>
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
                                <label class="form-label d-block fw-bold">Status File Bebas Tanggungan PKL</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio"
                                        name="statusBebasTanggunganPkl" id="statusBebasTanggunganTolak" value="0"
                                        {{ $pendaftaranSemhasInfo->status_file_bebas_tanggungan_pkl == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-semibold"
                                        for="statusBebasTanggunganTolak">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio"
                                        name="statusBebasTanggunganPkl" id="statusBebasTanggunganTerima" value="1"
                                        {{ $pendaftaranSemhasInfo->status_file_bebas_tanggungan_pkl == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-semibold"
                                        for="statusBebasTanggunganTerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </label>
                                </div>
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
                                <label class="form-label d-block fw-bold">Status SKLA</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusSKLA"
                                        id="statusSKLATolak" value="0"
                                        {{ $pendaftaranSemhasInfo->status_file_skla == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-semibold" for="statusSKLATolak">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input status-radio" type="radio" name="statusSKLA"
                                        id="statusSKLATerima" value="1"
                                        {{ $pendaftaranSemhasInfo->status_file_skla == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-success fw-semibold" for="statusSKLATerima">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </label>
                                </div>
                            </div>
                            {{-- End input verifikasi skla --}}

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terimaSemuaDokumen">
                                    <label class="form-check-label fw-bold text-success" for="terimaSemuaDokumen">
                                        <i class="bi bi-check2-square"></i> Terima Semua Dokumen Syarat Pendaftaran
                                    </label>
                                </div>
                            </div>

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
