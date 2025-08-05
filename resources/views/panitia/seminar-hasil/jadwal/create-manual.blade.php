@extends('panitia.home')

@section('content-panitia')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Buat Jadwal Sidang Ujian Akhir</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ups!</strong> Terjadi beberapa masalah dengan input Anda.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Pilih Periode dan Tahap</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="periode">Periode</label>
                                <select class="custom-select" id="periode" name="periode_id" required>
                                    <option selected>Open this select menu</option>
                                    @foreach ($listPeriode as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tahap">Tahap</label>
                                <select class="custom-select" id="tahap" name="tahap_id" required>
                                    <option selected>Open this select menu</option>
                                    @foreach ($listTahap as $tahap)
                                        <option value="{{ $tahap->id }}">{{ $tahap->tahap }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button id="pilih-periode-tahap" class="btn btn-success" style="width: 100px">Pilih</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Daftar Calon Peserta</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('panitia.jadwal-sidang-akhir.store-manual') }}" method="post">
                                @csrf
                                <div class="table-responsive" style="height: 500px">
                                    <table id="tabel-buat-jadwal" class="table table-bordered table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 25px">No</th>
                                                <th>Ruang</th>
                                                <th>Tanggal</th>
                                                <th>Sesi</th>
                                                <th>Waktu Mulai</th>
                                                <th>Waktu Selesai</th>
                                                <th>Judul</th>
                                                <th>Mahasiswa 1</th>
                                                @if ($prodiIdPanitia == 1)
                                                    <th>Mahasiswa 2</th>
                                                @endif
                                                <th>Dosen Pembimbing 1</th>
                                                <th>Dosen Pembimbing 2</th>
                                                <th>Dosen Penguji 1</th>
                                                <th>Dosen Penguji 2</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-daftar-calon-peserta"></tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-panitia')
    <script src="{{ asset('/custom/js/seminar-hasil/generate-jadwal-manual.js') }}"></script>
@endsection