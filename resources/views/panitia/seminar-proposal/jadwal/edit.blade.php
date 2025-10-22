@extends('panitia.home')

@section('page-style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

    <style>
        #table-edit-jadwal{
            table-layout: fixed;
            width: 100%;
        }
        .td-100-wrapper{
            min-width: 100px;
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            margin: 0 auto;
        }
        .td-150-wrapper{
            min-width: 150px;
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            margin: 0 auto;
        }
        .td-200-wrapper{
            min-width: 200px;
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            margin: 0 auto;
        }
        .td-300-wrapper{
            min-width: 300px;
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            margin: 0 auto;
        }

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
        <div id="pop-up-success" style="display: none">
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
                <strong class="text-success"></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    
    <div id="pop-up-error" style="display: none">
            <div style="
                                                                                                                                            position: fixed;
                                                                                                                                            top: 30px;
                                                                                                                                            left: 60%;
                                                                                                                                            transform: translateX(-50%);
                                                                                                                                            z-index: 1050;
                                                                                                                                            width: 50%;
                                                                                                                                            transition: all 0.2s ease-in-out;
                                                                                                                                        "
                class="bg-white border-bottom-0 border-right-0 border-left-0 py-4 border-danger shadow shadow-md mx-auto alert alert-dismissible fade show relative"
                role="alert">
                <ul class="text-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>

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
                    <div class="card" style="overflow: hidden">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Peserta Periode {{ $periode->tahun }} Tahap
                                {{ $tahap->tahap }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="post">
                                @csrf
                                @method('PUT')
                                <div class="table-responsive" id="container-tabel-edit-jadwal" style="height: 500px">
                                    <table id="tabel-edit-jadwal" class="table table-bordered table-head-fixed">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px" class="text-center">No</th>
                                                <th style="width: 150px" class="text-center">Ruang</th>
                                                <th style="width: 150px" class="text-center">Tanggal</th>
                                                <th style="width: 50px" class="text-center">Sesi</th>
                                                <th class="text-center td-150-wrapper">Waktu</th>
                                                <th class="text-center td-300-wrapper">Judul</th>
                                                <th class="text-center td-200-wrapper">Mahasiswa 1</th>
                                                @if ($prodiIdPanitia == 1)
                                                    <th class="text-center td-200-wrapper">Mahasiswa 2</th>
                                                @endif
                                                <th class="text-center .td-200-wrapper">Moderator</th>
                                                <th class="text-center .td-200-wrapper">Dosen Penguji 1</th>
                                                <th class="text-center .td-200-wrapper">Dosen Penguji 2</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-daftar-calon-peserta">
                                            @foreach ($jadwalSempro as $idx => $jadwal)
                                                <tr>
                                                    <td style="width: 50px" class="text-center">
                                                        {{ $idx + 1}}</th>
                                                    <td style="width: 150px" class="text-center">
                                                        <div class="input-group" style="width: 150px; margin: 0 auto;">
                                                            <input type="text" name="ruang" class="form-control edit-ruang"
                                                            value="{{ $jadwal->ruang ?? "-" }}" readonly>
                                                            <!-- <div class="input-group-append">
                                                                <button class="btn btn-success edit-ruang-btn">
                                                                    <i class="fas fa-edit text-white"></i>
                                                                </button>
                                                            </div> -->
                                                        </div>
                                                    </td>
                                                    <td style="width: 150px" class="text-center">
                                                        <input type='date' class="form-control" name='tanggal'
                                                            class="form-control" value="{{ optional($jadwal->tanggal)->format('Y-m-d') }}" readonly>
                                                    </td>
                                                    <td style="width: 50px" class="text-center">
                                                        {{ $jadwal->sesi }}
                                                        <!-- <select name="sesi" id="sesi" class="custom-select" style="width: 50px">
                                                            @foreach ($listSesi as $sesi)
                                                                <option value="{{ $sesi }}" @if($sesi == $jadwal->sesi) selected
                                                                @endif>{{ $sesi }}</option>
                                                            @endforeach
                                                        </select> -->
                                                    </td>
                                                    <td class="text-center td-150-wrapper">
                                                        {{ $jadwal->waktu_mulai->isoFormat("HH:mm") ?? "-" }} -
                                                        {{ $jadwal->waktu_selesai->isoFormat("HH:mm") ?? "-" }}</td>
                                                    <td class="text-center td-300-wrapper">
                                                        {{ $jadwal->proposal?->judul ?? "-" }}</td>
                                                    <td class="text-center td-200-wrapper">
                                                        {{ $jadwal->proposal?->proposalMahasiswas[0]?->mahasiswa?->nama ?? '-' }}</td>
                                                    @if ($prodiIdPanitia == 1)
                                                        <th style="width: 300px" class="text-center td-200-wrapper">
                                                            {{ $jadwal->proposal?->proposalMahasiswas[1]?->mahasiswa?->nama ?? '-' }}</th>
                                                    @endif
                                                    <td class="text-center">
                                                        {{ $jadwal->proposal?->dosenPembimbing1?->nama ?? "-" }}</td>
                                                    <td class="text-center">
                                                        <select name="dosen_penguji_1_id" data-id="{{ $jadwal->id }}" data-prevent-change="false"
                                                            @foreach ($listDosenPenguji1 as $dosen)
                                                                @if($dosen->id == $jadwal->proposal?->dosenPengujiSempro1?->id)
                                                                    data-prev-id="{{ $dosen->id }}"
                                                                    data-prev-name="{{ $dosen->nama }}"
                                                                @endif
                                                            @endforeach
                                                            class="custom-select dosen-penguji-select dosen-penguji-1-select" style="width: 200px">
                                                            @foreach ($listDosenPenguji1 as $dosen)
                                                                <option value="{{ $dosen->id }}"
                                                                    @if($dosen->id == $jadwal->proposal?->dosenPengujiSempro1?->id)
                                                                    selected @endif>{{ $dosen->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <select name="dosen_penguji_2_id" data-id="{{ $jadwal->id }}" data-prevent-change="false"
                                                            @foreach ($listDosenPenguji2 as $dosen)
                                                                @if($dosen->id == $jadwal->proposal?->dosenPengujiSempro2?->id)
                                                                    data-prev-id="{{ $dosen->id }}"
                                                                    data-prev-name="{{ $dosen->nama }}"
                                                                @endif
                                                            @endforeach
                                                            class="custom-select dosen-penguji-select dosen-penguji-2-select" style="width: 200px">
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
            <div class="row">
                <a href="{{ route("jadwal-sempro.detail", ["tahap_id" => $tahap->id, "periode_id" => $periode->id]) }}" class="btn btn-info">
                    Kembali
                </a>
            </div>
        </div>
        <!-- /.content -->
    </div>
@endsection

@section('scripts-panitia')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('/custom/js/seminar-proposal/edit-jadwal.js') }}"></script>
@endsection