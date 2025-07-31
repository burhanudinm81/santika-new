@extends('mahasiswa.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Logbook Bimbingan Dosen {{ $roleDospem }} </h1>
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
                            <h3 class="card-title">Tambah Logbook</h3>
                        </div>
                        <form action="{{ route('mahasiswa.logbook.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            {{-- hidden input --}}
                            <input type="hidden" name="mahasiswaId" value="{{ auth('mahasiswa')->user()->id }}">
                            <input type="hidden" name="statusVerifKegiatan" value="0" class="form-control"
                                id="StatusVerifikasi" />
                            <input type="hidden" name="roleDospem" value="{{ $roleDospem }}">

                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="NamaKegiatan" class="form-label">Dosen Pembimbing
                                            {{ $roleDospem }}</label>

                                        @if ($roleDospem == 1)
                                            <input type="hidden" name="dosenPembimbingId" value="{{ $dospem1Info->id }}">
                                            <input type="text" class="form-control" id="NamaKegiatan"
                                                value="{{ $dospem1Info->nama }}" readonly />
                                        @elseif($roleDospem == 2)
                                            <input type="hidden" name="dosenPembimbingId" value="{{ $dospem2Info->id }}">
                                            <input type="text" class="form-control" id="NamaKegiatan"
                                                value="{{ $dospem2Info->nama }}" readonly />
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleDataList" class="form-label">Jenis Kegiatan</label>
                                    <select name="jenisKegiatanId" class="form-control" id="" required>
                                        @foreach ($jenisKegiatanLogbook as $jenisKegiatan)
                                            <option value="{{ $jenisKegiatan->id }}">{{ $jenisKegiatan->nama_kegiatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="NamaKegiatan" class="form-label">Nama Kegiatan</label>
                                    <input type="text" name="namaKegiatan" class="form-control" id="NamaKegiatan"
                                        required />
                                </div>
                                <div class="mb-3">
                                    <label for="TanggalKegiatan" class="form-label">Tanggal</label>
                                    <input type="date" name="tanggalKegiatan" class="form-control" id="TanggalKegiatan"
                                        required />
                                </div>
                                <div class="mb-3">
                                    <label for="hasilKegiatan" class="form-label">Catatan Kegiatan</label>
                                    <textarea class="form-control" name="hasilKegiatan" id="hasilKegiatan" rows="3" required></textarea>
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="StatusVerifikasi" class="form-label">Status Verifikasi</label>
                                </div> --}}

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
