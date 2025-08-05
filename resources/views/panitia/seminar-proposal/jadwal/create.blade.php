@extends('panitia.home')

@section('content-panitia')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Jadwal Seminar Proposal Prodi {{ $prodi->prodi }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    {{-- floating notification --}}
    @if (session('success'))
        <div>
            {{-- modal popup success --}}
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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Buat Jadwal Seminar Proposal</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('jadwal-sempro.store') }}" method="POST">
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
                                        @foreach ($periodes as $periode)
                                            <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tahap">Tahap</label>
                                    <select class="custom-select" id="tahap" name="tahap_id" required>
                                        <option selected>Open this select menu</option>
                                        @foreach ($tahaps as $tahap)
                                            <option value="{{ $tahap->id }}">{{ $tahap->tahap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah-ruang">Jumlah Ruang</label>
                                    <input type="number" class="form-control" id="jumlah-ruang" name="jumlah_ruang"
                                        value="1" required>
                                </div>
                                <table class="table table-striped table-bordered" id="input-ruang">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Ruang</th>
                                    </thead>
                                    <tbody id="ruang-table-body">
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <input type="text" class="form-control" id="ruang" name="ruang[]"
                                                    required>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label for="jumlah-tanggal">Jumlah Tanggal</label>
                                    <input type="number" class="form-control" id="jumlah-tanggal" name="jumlah_tanggal"
                                        value="1" required>
                                </div>
                                <table class="table table-striped table-bordered" id="input-tanggal">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tanggal-table-body">
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal[]"
                                                    required>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label for="jumlah-sesi">Jumlah Sesi</label>
                                    <input type="number" class="form-control" id="jumlah-sesi" name="jumlah_sesi"
                                        value="1" required>
                                </div>
                                <table class="table table-striped table-bordered" id="input-sesi">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu Mulai</th>
                                            <th>Waktu Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sesi-table-body">
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <input type="time" class="form-control" id="waktu_mulai"
                                                    name="sesi[0][waktu_mulai]" required>
                                            </td>
                                            <td>
                                                <input type="time" class="form-control" id="waktu_selesai"
                                                    name="sesi[0][waktu_selesai]" required>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                                    @foreach ($dosens as $dosen)
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
                                <button type="submit" class="btn btn-primary">Generate Jadwal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>


@endsection

@section('scripts-panitia')
    <script src="{{ asset('/custom/js/seminar/generate-jadwal.js') }}"></script>
@endsection
