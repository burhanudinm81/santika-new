@extends('panitia.home')

@section('page-style')
    <style>
        .td-100-wrapper {
            width: 100px;
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            margin: 0 auto;
        }
    </style>
@endsection

@section('content-panitia')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Jadwal Sidang Ujian Akhir Prodi {{ $prodi->prodi }}</h1>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div>
            <div style="
                                    position: fixed;
                                    top: 30px;
                                    left: 60%;
                                    transform: translateX(-50%);
                                    z-index: 1050;
                                    width: 50%;
                                    transition: all 0.2s ease-in-out;
                                "
                class="bg-white border-bottom-0 border-right-0 border-left-0 py-4 border-success shadow shadow-md mx-auto alert alert-dismissible fade show relative"
                role="alert">
                <strong class="text-success">{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Buat Jadwal Sidang Ujian Akhir</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('panitia.jadwal-sidang-akhir.store') }}" method="POST">
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
                                @csrf
                                <div class="form-group">
                                    <label for="periode">Periode</label>
                                    <select class="custom-select" id="periode" name="periode_id" required>
                                        <option selected>Open this select menu</option>
                                        @foreach ($listPeriode as $periode)
                                            @if ($periode->aktif_sempro)
                                                <option value="{{ $periode->id }}" selected>{{ $periode->tahun }}</option>
                                            @else
                                                <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                            @endif
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
                                    <p class="form-text text-muted">Jumlah Proposal: <b class="jumlah-proposal">-</b>
                                    </p>
                                </div>
                                <hr>

                                <div class="form-group">
                                    <label for="jumlah-ruang">Pengaturan Ruang</label>
                                </div>
                                <table class="table table-striped table-bordered" id="input-ruang">
                                    <thead>
                                        <th>No</th>
                                        <th>Ruang</th>
                                        <th class="td-100-wrapper text-center">Aksi</th>
                                    </thead>
                                    <tbody id="ruang-table-body">
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <input type="text" class="form-control" name="ruang[]" required>
                                            </td>
                                            <td class="td-100-wrapper">
                                                <button type="button" class="btn btn-danger remove-ruang">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success mb-2" id="tambah-ruang">Tambah Ruang</button>
                                <hr>

                                <div class="form-group">
                                    <label for="jumlah-tanggal">Tanggal Pelaksanaan</label>
                                </div>
                                <table class="table table-striped table-bordered" id="input-tanggal">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th class="td-100-wrapper text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tanggal-table-body">
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <input type="date" class="form-control" name="tanggal[]" required>
                                            </td>
                                            <td class="td-100-wrapper">
                                                <button type="button" class="btn btn-danger remove-tanggal">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success mb-2" id="tambah-tanggal">Tambah Hari</button>
                                <hr>

                                <div class="form-group">
                                    <label for="jumlah-sesi">Jumlah Sesi</label>
                                    <input type="number" class="form-control" id="jumlah-sesi" name="jumlah_sesi" value="1"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="waktu-mulai">Waktu Mulai</label>
                                    <input type="time" class="form-control" name="waktu_mulai" id="waktu-mulai" required>
                                </div>
                                <div class="form-group">
                                    <label for="durasi-seminar">Durasi Seminar</label>
                                    <div class="input-group">
                                        <input type="number" name="durasi_seminar" id="durasi-seminar" class="form-control"
                                            required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Menit</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jeda-antar-seminar">Jeda Antar Seminar</label>
                                    <div class="input-group">
                                        <input type="number" name="jeda_antar_seminar" id="jeda-antar-seminar"
                                            class="form-control" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Menit</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="waktu-berhalangan-dosen"
                                            name="waktu_berhalangan_dosen" value="1">
                                        <label class="custom-control-label" for="waktu-berhalangan-dosen">Waktu Berhalangan
                                            Dosen</label>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered" id="input-waktu-berhalangan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dosen</th>
                                            <th>Tanggal</th>
                                            <th>Waktu Mulai</th>
                                            <th>Waktu Selesai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="waktu-berhalangan-table-body">
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <select class="custom-select" name="waktu_berhalangan[0][dosen_id]">
                                                    <option selected>Open this select menu</option>
                                                    @foreach ($listDosen as $dosen)
                                                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control" id="tanggal_berhalangan"
                                                    name="waktu_berhalangan[0][tanggal]" value="2024-01-01" required>
                                            </td>
                                            <td>
                                                <input type="time" class="form-control" id="waktu_mulai_berhalangan"
                                                    name="waktu_berhalangan[0][waktu_mulai]" value="00:00" required>
                                            </td>
                                            <td>
                                                <input type="time" class="form-control" id="waktu_selesai_berhalangan"
                                                    name="waktu_berhalangan[0][waktu_selesai]" value="01:00" required>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-sesi">Hapus</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success btn-sm mb-2"
                                    id="tambah-waktu-berhalangan">Tambah Waktu Berhalangan</button>
                                <small id="info-waktu-berhalangan" class="form-text text-muted mb-4">Pasangan Waktu Mulai
                                    dan Waktu Selesai harus sama persis dengan waktu mulai dan waktu selesai pada input
                                    sesi</small>
                                <hr>
                                
                                <small class="form-text text-muted">Untuk Men-generate Jadwal, (Jumlah Ruang x Jumlah Hari x Jumlah Sesi) > Jumlah Proposal</small>
                                <small class="form-text text-muted">Jumlah Proposal = <b class="jumlah-proposal">-</b></small>
                                <small class="form-text text-muted mb-2">(Jumlah Ruang x Jumlah Hari x Jumlah Sesi) Saat ini = <b id="total-rhs">-</b></small>
                                <a href="{{ route("jadwal-sempro.index") }}"
                                    class="btn btn-secondary w-100 mb-2">
                                    Batal
                                </a>
                                <button type="submit" id="btn-generate-jadwal" class="btn btn-primary w-100 mb-2" disabled>Generate
                                    Jadwal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-panitia')
    <script src="{{ asset('/custom/js/seminar/generate-jadwal.js') }}"></script>
    <script src="{{ asset('/custom/js/seminar/check-generate-jadwal-semhas.js') }}"></script>
@endsection