@extends('mahasiswa.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Logbook Bimbingan Dosen</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                @include('notifications.success-alert', ['message' => session('success')])
            @endif

            <div class="col-md-15">
                <div id="cards-container" class="mt-1">
                    <!-- Card pertama (untuk duplikasi) -->
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Detail Logbook</h3>
                        </div>
                        <form>
                            {{-- hidden input --}}
                            <input type="hidden" name="mahasiswaId" value="{{ auth('mahasiswa')->user()->id }}">
                            <input type="hidden" name="statusVerifKegiatan" value="0" class="form-control"
                                id="StatusVerifikasi" />

                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="NamaKegiatan" class="form-label">Dosen Pembimbing</label>
                                        <input type="text" value="{{ $logbook->dosen->nama }}" class="form-control"
                                            id="NamaKegiatan" value="" readonly />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleDataList" class="form-label">Jenis Kegiatan</label>
                                    <input type="text" class="form-control" id="NamaKegiatan"
                                        value="{{ $logbook->jenisKegiatanLogbook->nama_kegiatan }}" readonly />
                                    {{-- <select name="jenisKegiatanId" class="form-control" id="" required>
                                        @foreach ($jenisKegiatanLogbook as $jenisKegiatan)
                                            <option value="{{ $jenisKegiatan->id }}">{{ $jenisKegiatan->nama_kegiatan }}
                                            </option>
                                        @endforeach
                                    </select> --}}
                                </div>
                                <div class="mb-3">
                                    <label for="NamaKegiatan" class="form-label">Nama Kegiatan</label>
                                    <input type="text" value="{{ $logbook->nama_kegiatan }}" name="namaKegiatan"
                                        class="form-control" id="NamaKegiatan" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="TanggalKegiatan" class="form-label">Tanggal</label>
                                    <input type="date" value="{{ $logbook->tanggal_kegiatan }}" name="tanggalKegiatan"
                                        class="form-control" id="TanggalKegiatan" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="hasilKegiatan" class="form-label">Catatan Kegiatan</label>
                                    <textarea class="form-control" name="hasilKegiatan" id="hasilKegiatan" rows="3" readonly>{{ $logbook->hasil_kegiatan }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="StatusVerifikasi" class="form-label">Status Verifikasi</label>
                                    <input type="text"
                                        value="{{ $logbook->status_verifikasi == 1 ? 'Diverifikasi Berhasil' : 'Belum Diverifikasi' }}"
                                        class="form-control
                                            @if ($logbook->status_verifikasi != 1) bg-warning
                                            @elseif($logbook->status_verifikasi == 1) bg-success
                                            @else bg-info @endif
                                        " id="StatusVerifikasi" readonly />

                                </div>

                            </div>
                            <div class="card-footer">
                                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
