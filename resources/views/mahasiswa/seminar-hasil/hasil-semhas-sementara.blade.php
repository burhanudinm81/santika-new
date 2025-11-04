@extends('mahasiswa.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hasil Sidang Tugas Akhir</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                @if ($visible)
                    @if ($statusKelulusanSemhas == 1)
                        <div class="alert alert-success my-2" role="alert">
                            <h4 class="alert-heading">Selamat!</h4>
                            <p>Anda dinyatakan <strong>Lulus Sidang Tugas Akhir tanpa revisi</strong>.</p>
                            <hr>
                            <p class="mb-0">Silahkan menunggu informasi selanjutnya dari Panitia.</p>
                        </div>
                    @elseif($statusKelulusanSemhas == 2)
                        @if ($revisiSelesai)
                            <div class="alert alert-success my-2" role="alert">
                                <h4 class="alert-heading">Selamat!</h4>
                                <p>Anda dinyatakan <strong>Lulus Sidang Tugas Akhir dengan revisi</strong>.</p>
                                <hr>
                                <p class="mb-0">Revisi Telah Diselesaikan. Silahkan menunggu informasi selanjutnya dari
                                    Panitia.</p>
                            </div>
                        @else
                            <div class="alert alert-warning my-2" role="alert">
                                <h4 class="alert-heading">Selamat!</h4>
                                <p>Anda dinyatakan <strong>Lulus Sidang Tugas Akhir dengan revisi</strong>.</p>
                                <hr>
                                <p class="mb-0">Selesaikan revisi sebelum tenggat waktu yang telah ditentukan!</p>
                            </div>
                        @endif
                    @elseif($statusKelulusanSemhas == 3)
                        <div class="alert alert-danger my-2" role="alert">
                            <h4 class="alert-heading">Mohon Maaf!</h4>
                            <p>Anda dinyatakan <strong>Tidak Lulus Sidang Tugas Akhir</strong>.</p>
                            <hr>
                            <p class="mb-0">Jangan berkecil hati. Jadikan kegagalan ini sebagai pembelajaran yang berharga
                                untuk bangkit kembali. Tetap semangat!</p>
                        </div>
                    @endif
                @endif
                <div class="card card-primary card-outline mb-4">
                    <!--begin::Form-->
                    <form>
                        @if (is_null($mainProposalInfo) || $isPengujiNotAssigned)
                            <div class="card-body">
                                <p>Anda Belum Pernah Mengikuti Sidang Tugas Akhir</p>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="DosenPenguji1" class="form-label">Dosen Penguji 1</label>
                                    <input type="text" class="form-control" id="DosenPenguji1"
                                        aria-describedby="DosenPenguji1"
                                        value="{{ $mainProposalInfo->dosenPengujiSidangTA1->nama ?? '' }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="StatusNilaiPenguji1" class="form-label">Status Nilai Dosen Penguji 1</label>
                                    @if ($visible)
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
                                    @else
                                        <input type="text" id="StatusNilaiPenguji1" aria-describedby="StatusNilaiPenguji1"
                                            class="form-control" value="-" readonly/>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="CatatanPenguji1" class="form-label">Catatan Penguji 1</label>
                                    @if ($visible)
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" 
                                            readonly>{{ $revisiDosen1 ? $revisiDosen1->catatan_revisi ?? '' : 'Belum ada catatan dari Dosen Penguji 1.' }}</textarea>
                                    @else
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" 
                                            readonly>-</textarea>
                                    @endif
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
                                    @if ($visible)
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
                                    @else
                                        <input type="text" id="StatusNilaiPenguji2" aria-describedby="StatusNilaiPenguji2"
                                            class="form-control" value="-" readonly />
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="CatatanPenguji2" class="form-label">Catatan Penguji 2</label>
                                    @if ($visible)
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" 
                                            readonly>{{ $revisiDosen2 ? $revisiDosen2->catatan_revisi ?? '' : 'Belum ada catatan dari Dosen Penguji 2.' }}</textarea>
                                    @else
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" 
                                            readonly>-</textarea>
                                    @endif
                                </div>

                                <hr>
                                <div class="mb-3">
                                    <label for="DosenPembimbing1" class="form-label">Dosen Pembimbing 1</label>
                                    <input type="text" class="form-control" id="DosenPembimbing1"
                                        aria-describedby="DosenPembimbing1"
                                        value="{{ $mainProposalInfo->dosenPembimbing1->nama ?? '' }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="StatusNilaiPembimbing1" class="form-label">Status Nilai Dosen Pembimbing 1</label>
                                    @if ($visible)
                                        <input type="text" id="StatusNilaiPembimbing1" aria-describedby="StatusNilaiPembimbing"
                                            @if ($mainProposalInfo->statusSemhasPembimbing1?->status == 'Ditolak')
                                                class="form-control bg-danger"
                                            @elseif ($mainProposalInfo->statusSemhasPembimbing1?->status == 'Diterima tanpa revisi')
                                                class="form-control bg-success"
                                            @elseif ($mainProposalInfo->statusSemhasPembimbing1?->status == 'Diterima dengan revisi')
                                                @if ($revisiSelesai)
                                                    class="form-control bg-success"
                                                @else
                                                    class="form-control bg-warning"
                                                @endif
                                            @else
                                                class="form-control"
                                            @endif
                                            value="{{ $mainProposalInfo->statusSemhasPembimbing1->status ?? '' }}" readonly />
                                    @else
                                        <input type="text" class="form-control" id="StatusNilaiPembimbing1" aria-describedby="StatusNilaiPembimbing"
                                            value="-" readonly />
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="CatatanPembimbing1" class="form-label">Catatan Pembimbing 1</label>
                                    @if ($visible)
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" 
                                            readonly>{{ $revisiDosbing1 ? $revisiDosbing1->catatan_revisi ?? '' : 'Belum ada catatan dari Dosen Pembimbing 1.' }}</textarea>
                                    @else
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" 
                                            readonly>-</textarea>
                                    @endif
                                </div>

                                <hr>
                                <div class="mb-3">
                                    <label for="DosenPembimbing2" class="form-label">Dosen Pembimbing 2</label>
                                    <input type="text" class="form-control" id="DosenPembimbing2"
                                        aria-describedby="DosenPembimbing2"
                                        value="{{ $mainProposalInfo->dosenPembimbing2->nama ?? '' }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="StatusNilaiPembimbing2" class="form-label">Status Nilai Dosen Pembimbing
                                        2</label>
                                    @if ($visible)
                                        <input type="text" id="StatusNilaiPembimbing2" aria-describedby="StatusNilaiPembimbing2"
                                            @if ($mainProposalInfo->statusSemhasPembimbing2?->status == 'Ditolak')
                                                class="form-control bg-danger"
                                            @elseif ($mainProposalInfo->statusSemhasPembimbing2?->status == 'Diterima tanpa revisi')
                                                class="form-control bg-success"
                                            @elseif ($mainProposalInfo->statusSemhasPembimbing2?->status == 'Diterima dengan revisi')
                                                @if ($revisiSelesai)
                                                    class="form-control bg-success"
                                                @else
                                                    class="form-control bg-warning"
                                                @endif
                                            @else
                                                class="form-control"
                                            @endif
                                            value="{{ $mainProposalInfo->statusSemhasPembimbing2->status ?? '' }}" readonly />
                                    @else
                                        <input type="text" class="form-control" id="StatusNilaiPembimbing2" aria-describedby="StatusNilaiPembimbing2"
                                            value="-" readonly />
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="CatatanPenguji2" class="form-label">Catatan Pembimbing 2</label>
                                    @if ($visible)
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" 
                                            readonly>{{ $revisiDosbing2 ? $revisiDosbing2->catatan_revisi ?? '' : 'Belum ada catatan dari Dosen Pembimbing 2.' }}</textarea>
                                    @else
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" 
                                            readonly>-</textarea>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
