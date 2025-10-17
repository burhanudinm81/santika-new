@extends('panitia.home')

@section('content-panitia')
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

    @if ($errors->any())
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
                class="bg-white border-bottom-0 border-right-0 border-left-0 py-4 border-danger shadow shadow-md mx-auto alert alert-dismissible fade show relative"
                role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Rekap Nilai Seminar Proposal Tahap {{ $tahapInfo->tahap }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools d-flex justify-content-between align-items-center w-100 mx-1">
                                <div class="ml-1">
                                    <button type="button" class="btn btn-success" id="btn-publish-nilai">
                                        Publish Nilai
                                    </button>
                                    <button type="button" class="btn btn-danger" id="btn-hide-nilai">
                                        Sembunyikan Nilai
                                    </button>
                                </div>
                                <div class="input-group input-group-sm" style="width: 150px">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="my-2" style="width: 300px; margin-right: 300px">
                            <div class="input-group">
                                <select class="custom-select" id="periode_sempro_id"
                                    aria-label="Example select with button addon">

                                    <option disabled>Pilih Periode</option>
                                    @foreach ($periodeInfo as $periode)
                                        <option value="{{ $periode->id }}" @if($periode->aktif_sempro) selected @endif>
                                            {{ $periode->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button id="buttonTampilNilaiSemproByPeriode" class="btn btn-outline-secondary"
                                        type="button">Tampilkan</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="tahap_sempro_id" value="{{ $tahapInfo->id }}">
                        <input type="hidden" id="prodi_panitia_sempro_id" value="{{ $dosenPanitiaInfo->prodi_id }}">

                        <div class="card-body border border-2 border-danger table-responsive p-0" style="height: 320px">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    @if ($dosenPanitiaInfo->prodi_id == 1)
                                        <tr>
                                            <th class="text-center align-middle">No</th>
                                            <th class="text-center align-middle">Nama Mahasiswa 1</th>
                                            <th class="text-center align-middle">NIM Mahasiswa 1</th>
                                            <th class="text-center align-middle">Nama Mahasiswa 2</th>
                                            <th class="text-center align-middle">NIM Mahasiswa 2</th>
                                            <th class="text-center align-middle">Judul</th>
                                            <th class="text-center align-middle">Status</th>
                                            <th class="text-center align-middle">Revisi</th>
                                        </tr>
                                    @elseif($dosenPanitiaInfo->prodi_id == 2)
                                        <tr>
                                            <th class="text-center align-middle">No</th>
                                            <th class="text-center align-middle">NIM</th>
                                            <th class="text-center align-middle">Nama</th>
                                            <th class="text-center align-middle">Judul</th>
                                            <th class="text-center align-middle">Status</th>
                                            <th class="text-center align-middle">Revisi</th>
                                        </tr>
                                    @endif
                                </thead>
                                <tbody id="data-table-body">
                                    {{-- akan diisi oleh DOM javascript --}}
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <p class="text">
                Status Nilai Seminar Proposal Periode {{ $periodeAktif->tahun }} Tahap {{ $tahapInfo->tahap }}:
                @if ($visibilitasNilai)
                    <b class="text-green">Sudah Dipublikasikan</b>
                @else
                    <b class="text-red">Belum Dipublikasikan</b>
                @endif
            </p>
            <a href="{{ route("panitia.seminar-proposal.tahap-rekap-nilai") }}" class="btn btn-info mt-2">
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('modals')
    <div id="modal-publish-rekap-nilai-sempro" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title">Publish Rekap Nilai Seminar Proposal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin mempublish rekap nilai Seminar Proposal <b>Tahap {{ $tahapInfo->tahap }} Periode {{ $periodeAktif->tahun }}</b> ?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('panitia.kelola-seminar.visibilitas-nilai.publish') }}" method="post">
                        @csrf
                        <input type="hidden" name="tahap_id" value="{{ $tahapInfo->id }}">
                        <input type="hidden" name="periode_id" value="">
                        <input type="hidden" name="jenis_nilai_seminar" value="1">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" style="width: 75px">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-hide-rekap-nilai-sempro" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title">Sembunyikan Rekap Nilai Seminar Proposal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menyembunyikan rekap nilai Seminar Proposal <b>Tahap {{ $tahapInfo->tahap }} Periode {{ $periodeAktif->tahun }}</b> ?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('panitia.kelola-seminar.visibilitas-nilai.hide') }}" method="post">
                        @csrf
                        <input type="hidden" name="tahap_id" value="{{ $tahapInfo->id }}">
                        <input type="hidden" name="periode_id" value="">
                        <input type="hidden" name="jenis_nilai_seminar" value="1">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" style="width: 75px">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-panitia')
    <script src="{{ url("/custom/js/seminar/visibilitas-nilai.js") }}"></script>
@endsection