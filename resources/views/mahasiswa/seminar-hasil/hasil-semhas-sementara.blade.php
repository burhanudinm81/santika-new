@extends('mahasiswa.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hasil Sementara Seminar Hasil</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                @if ($statusKelulusanSemhas == 1)
                    <div class="alert alert-success my-2" role="alert">
                        <h4 class="alert-heading">Selamat!</h4>
                        <p>Anda dinyatakan <strong>Lulus Seminar Hasil tanpa revisi</strong>.</p>
                        <hr>
                        <p class="mb-0">Silahkan menunggu informasi selanjutnya dari Panitia.</p>
                    </div>
                @elseif($statusKelulusanSemhas == 2)
                    @if ($revisiSelesai)
                        <div class="alert alert-success my-2" role="alert">
                            <h4 class="alert-heading">Selamat!</h4>
                            <p>Anda dinyatakan <strong>Lulus Seminar Hasil dengan revisi</strong>.</p>
                            <hr>
                            <p class="mb-0">Revisi Telah Diselesaikan. Silahkan menunggu informasi selanjutnya dari
                                Panitia.</p>
                        </div>
                    @else
                        <div class="alert alert-warning my-2" role="alert">
                            <h4 class="alert-heading">Selamat!</h4>
                            <p>Anda dinyatakan <strong>Lulus Seminar Hasil dengan revisi</strong>.</p>
                            <hr>
                            <p class="mb-0">Selesaikan revisi sebelum tenggat waktu yang telah ditentukan!</p>
                        </div>
                    @endif
                @elseif($statusKelulusanSemhas == 3)
                    <div class="alert alert-danger my-2" role="alert">
                        <h4 class="alert-heading">Mohon Maaf!</h4>
                        <p>Anda dinyatakan <strong>Tidak Lulus Seminar Hasil</strong>.</p>
                        <hr>
                        <p class="mb-0">Jangan berkecil hati. Jadikan kegagalan ini sebagai pembelajaran yang berharga
                            untuk bangkit kembali. Tetap semangat!</p>
                    </div>
                @endif
                <div class="card card-primary card-outline mb-4">
                    <!--begin::Form-->
                    <form>
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="DosenPenguji1" class="form-label">Dosen Penguji 1</label>
                                <input type="text" class="form-control" id="DosenPenguji1"
                                    aria-describedby="DosenPenguji1"
                                    value="{{ $mainProposalInfo->dosenPengujiSidangTA1->nama ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="StatusNilaiPenguji1" class="form-label">Status Nilai Dosen Penguji 1</label>
                                <input type="text"
                                    @if ($mainProposalInfo->statusSemhasPenguji1?->status == 'Ditolak')
                                        class="form-control bg-danger"
                                    @elseif ($mainProposalInfo->statusSemhasPenguji1?->status == 'Diterima tanpa revisi')
                                        class="form-control bg-success"
                                    @elseif ($mainProposalInfo->statusSemhasPenguji1?->status == 'Diterima dengan revisi')
                                        @if ($revisiSelesai)
                                            class="form-control bg-success"
                                        @else
                                            class="form-control bg-warning"
                                        @endif
                                    @else
                                        class="form-control"
                                    @endif
                                    id="StatusNilaiPenguji1"
                                    aria-describedby="StatusNilaiPenguji1"
                                    value="{{ $mainProposalInfo->statusSemhasPenguji1->status ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="CatatanPenguji1" class="form-label">Catatan Penguji 1</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>
                                    @if ($revisiDosen1)
                                    {{ $revisiDosen1->catatan_revisi ?? '' }}
                                    @else
                                    Belum ada catatan dari Dosen Penguji 1.
                                    @endif
                                </textarea>
                            </div>

                            <hr>
                            <div class="mb-3">
                                <label for="DosenPenguji2" class="form-label">Dosen Penguji 2</label>
                                <input type="text" class="form-control" id="DosenPenguji2"
                                    aria-describedby="DosenPenguji2"
                                    value="{{ $mainProposalInfo->dosenPengujiSidangTA2->nama ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="StatusNilaiPenguji2" class="form-label">Status Nilai Dosen Penguji 2</label>
                                <input type="text"
                                     @if ($mainProposalInfo->statusSemhasPenguji2?->status == 'Ditolak')
                                        class="form-control bg-danger"
                                    @elseif ($mainProposalInfo->statusSemhasPenguji2?->status == 'Diterima tanpa revisi')
                                        class="form-control bg-success"
                                    @elseif ($mainProposalInfo->statusSemhasPenguji2?->status == 'Diterima dengan revisi')
                                        @if ($revisiSelesai)
                                            class="form-control bg-success"
                                        @else
                                            class="form-control bg-warning"
                                        @endif
                                    @else
                                        class="form-control"
                                    @endif
                                    id="StatusNilaiPenguji2"
                                    aria-describedby="StatusNilaiPenguji2"
                                    value="{{ $mainProposalInfo->statusSemhasPenguji2->status ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="CatatanPenguji2" class="form-label">Catatan Penguji 2</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>
                                     @if ($revisiDosen2)
                                    {{ $revisiDosen2->catatan_revisi ?? '' }}
                                    @else
                                    Belum ada catatan dari Dosen Penguji 2.
                                    @endif
                                </textarea>
                            </div>

                            <hr>
                            <div class="mb-3">
                                <label for="DosenPenguji2" class="form-label">Dosen Pembimbing 1</label>
                                <input type="text" class="form-control" id="DosenPenguji2"
                                    aria-describedby="DosenPenguji2"
                                    value="{{ $mainProposalInfo->dosenPembimbing1->nama ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="StatusNilaiPenguji2" class="form-label">Status Nilai Dosen Pembimbing 1</label>
                                <input type="text" class="form-control" id="StatusNilaiPenguji2"
                                    aria-describedby="StatusNilaiPenguji2"
                                    value="{{ $mainProposalInfo->statusSemhasPembimbing1->status ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="CatatanPenguji2" class="form-label">Catatan Pembimbing 1</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>
                                     @if ($revisiDosbing1)
                                    {{ $revisiDosbing1->catatan_revisi ?? '' }}
                                    @else
                                    Belum ada catatan dari Dosen Pembimbing 1.
                                    @endif
                                </textarea>
                            </div>

                            <hr>
                            <div class="mb-3">
                                <label for="DosenPenguji2" class="form-label">Dosen Pembimbing 2</label>
                                <input type="text" class="form-control" id="DosenPenguji2"
                                    aria-describedby="DosenPenguji2"
                                    value="{{ $mainProposalInfo->dosenPembimbing2->nama ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="StatusNilaiPenguji2" class="form-label">Status Nilai Dosen Pembimbing
                                    2</label>
                                <input type="text" class="form-control" id="StatusNilaiPenguji2"
                                    aria-describedby="StatusNilaiPenguji2"
                                    value="{{ $mainProposalInfo->statusSemhasPembimbing2->status ?? '' }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="CatatanPenguji2" class="form-label">Catatan Pembimbing 2</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>
                                     @if ($revisiDosbing2)
                                    {{ $revisiDosbing2->catatan_revisi ?? '' }}
                                    @else
                                    Belum ada catatan dari Dosen Pembimbing 2.
                                    @endif
                                </textarea>
                            </div>
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <!--end::Footer-->
                    </form>
                    <!--end::Form-->
                </div>

            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
