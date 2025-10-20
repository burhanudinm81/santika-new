@extends('panitia.home')

@section('page-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

    <style>
        /* batasi lebar container select2 agar tidak melebihi viewport */
        .select2-container { max-width: 100% !important; box-sizing: border-box; }
        .select2-container--bootstrap4 .select2-selection--single {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* batasi lebar dropdown (mencegah memaksa body melebar) */
        .select2-dropdown {
            max-width: calc(100vw - 20px) !important;
            box-sizing: border-box;
            word-break: break-word;
        }
        /* batasi tinggi list hasil dan beri scroll internal */
        .select2-dropdown .select2-results__options {
            max-height: 50vh;
            overflow-y: auto;
        }
        /* pastikan tabel tetap menggunakan wrapper horizontal internal */
        .table-responsive { overflow-x: auto; }
    </style>
@endsection

@section('content-panitia')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Jadwal Seminar Proposal</h1>
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
                            <h3 class="card-title font-weight-bold">Peserta Periode {{ $periode->tahun }} Tahap
                                {{ $tahap->tahap }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="post">
                                @csrf
                                @method('PUT')
                                <div class="table-responsive" style="height: 500px">
                                    <table id="tabel-edit-jadwal" class="table table-bordered table-head-fixed">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px" class="text-center">No</th>
                                                <th style="width: 150px" class="text-center">Ruang</th>
                                                <th style="width: 150px" class="text-center">Tanggal</th>
                                                <th style="width: 50px" class="text-center">Sesi</th>
                                                <th style="width: 200px" class="text-center">Waktu</th>
                                                <th style="width: 300px" class="text-center">Judul</th>
                                                <th style="width: 300px" class="text-center">Mahasiswa 1</th>
                                                @if ($prodiIdPanitia == 1)
                                                    <th style="width: 300px" class="text-center">Mahasiswa 2</th>
                                                @endif
                                                <th style="width: 300px" class="text-center">Moderator</th>
                                                <th style="width: 300px" class="text-center">Dosen Penguji 1</th>
                                                <th style="width: 300px" class="text-center">Dosen Penguji 2</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-daftar-calon-peserta">
                                            @foreach ($jadwalSempro as $idx => $jadwal)
                                                <tr>
                                                    <td style="width: 50px" class="text-center" data-id="{{ $jadwal->id }}">
                                                        {{ $idx + 1}}</th>
                                                    <td style="width: 150px" class="text-center">
                                                        <div class="input-group" style="width: 150px; margin: 0 auto;">
                                                            <input type="text" name="ruang" class="form-control edit-ruang"
                                                            value="{{ $jadwal->ruang ?? "-" }}" readonly>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-success edit-ruang-btn">
                                                                    <i class="fas fa-edit text-white"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 150px" class="text-center">
                                                        <input type='date' class="form-control" name='tanggal'
                                                            class="form-control" value="{{ optional($jadwal->tanggal)->format('Y-m-d') }}">
                                                    </td>
                                                    <td style="width: 50px" class="text-center">
                                                        <select name="sesi" id="sesi" class="custom-select" style="width: 50px">
                                                            @foreach ($listSesi as $sesi)
                                                                <option value="{{ $sesi }}" @if($sesi == $jadwal->sesi) selected
                                                                @endif>{{ $sesi }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="width: 200px" class="text-center">
                                                        {{ $jadwal->waktu_mulai->isoFormat("HH:mm") ?? "-" }} -
                                                        {{$jadwal->waktu_selesai->isoFormat("HH:mm") ?? "-" }}</td>
                                                    <td style="width: 300px" class="text-center">
                                                        {{ $jadwal->proposal?->judul ?? "-" }}</td>
                                                    <td style="width: 300px" class="text-center">
                                                        {{ $jadwal->proposal?->proposalMahasiswas[0]?->mahasiswa?->nama ?? '-' }}</td>
                                                    @if ($prodiIdPanitia == 1)
                                                        <th style="width: 300px" class="text-center">
                                                            {{ $jadwal->proposal?->proposalMahasiswas[1]?->mahasiswa?->nama ?? '-' }}</th>
                                                    @endif
                                                    <td style="width: 300px" class="text-center">
                                                        {{ $jadwal->proposal?->dosenPembimbing1?->nama ?? "-" }}</td>
                                                    <td style="width: 300px" class="text-center">
                                                        <select name="dosen_penguji_1"
                                                            class="custom-select dosen-penguji-select" style="width: 300px">
                                                            @foreach ($listDosenPenguji1 as $dosen)
                                                                <option value="{{ $dosen->id }}"
                                                                    @if($dosen->id == $jadwal->proposal?->dosenPengujiSempro1?->id)
                                                                    selected @endif>{{ $dosen->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="width: 300px" class="text-center">
                                                        <select name="dosen_penguji_2"
                                                            class="custom-select dosen-penguji-select" style="width: 300px">
                                                            @foreach ($listDosenPenguji2 as $dosen)
                                                                <option value="{{ $dosen->id }}"
                                                                    @if($dosen->id == $jadwal->proposal?->dosenPengujiSempro2?->id)
                                                                    selected @endif>{{ $dosen->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
@endsection

@section('scripts-panitia')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('/custom/js/seminar-proposal/edit-jadwal.js') }}"></script>
@endsection