@extends('dosen.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Logbook</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">

            @if (session()->has('success'))
                @include('notifications.success-alert', ['message' => session('success')])
            @endif

            <div class="col-md-15">
                <div class="card card-primary card-outline mb-2">
                    <form action="{{ route('dosen.bimbingan.update-verifikasi-logbook') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="logbook_id" value="{{ $logbook->id }}">
                        <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->id }}">
                        <div class="card-body">
                            <p class="h4">Logbook 1</p>
                            <hr>

                            @if ($mahasiswa->prodi_id == 1)
                                <strong></i>Nama Mahasiswa 1</strong>
                                <p class="text-muted">
                                   {{$mahasiswaInfo[0]->mahasiswa->nama}}
                                </p>
                                <strong></i>Nama Mahasiswa 2</strong>
                                <p class="text-muted">
                                    {{ $mahasiswaInfo[1]->mahasiswa->nama }}
                                </p>
                            @elseif($mahasiswa->prodi_id == 2)
                                <strong></i>Nama Mahasiswa 1</strong>
                                <p class="text-muted">
                                    {{ $mahasiswa->nama }}
                                </p>
                            @endif
                            <strong></i>Jenis Kegiatan</strong>
                            <p class="text-muted">
                                {{ $logbook->jenisKegiatanLogbook->nama_kegiatan }}
                            </p>
                            <strong></i>Nama Kegiatan</strong>
                            <p class="text-muted">
                                {{ $logbook->nama_kegiatan }}
                            </p>
                            <strong></i>Tanggal/Waktu</strong>
                            <p class="text-muted">
                                {{ $logbook->tanggal_kegiatan }}
                            </p>
                            <strong></i>Hasil Kegiatan</strong>
                            <p class="text-muted">
                                {{ $logbook->hasil_kegiatan }}
                            </p>

                            <div class="mb-3">
                                <label for="CatatanPenguji1" class="form-label">Catatan Khusus dari Dosen</label>
                                <textarea name="catatan_khusus_dosen" class="form-control" id="exampleFormControlTextarea1" rows="10">{{ $logbook->catatan_khusus_dosen ?? '' }}</textarea>
                            </div>
                            <strong></i>Status Logbook</strong>
                            <br>

                            <div class="d-grid gap-2">
                                <button name="status_verif_logbook" value="3" type="submit"
                                    class="btn btn-block btn-primary" type="button">Terima</button>
                                <button name="status_verif_logbook" value="2" type="submit"
                                    class="btn btn-block btn-danger" type="button">Tolak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
