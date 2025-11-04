@extends('panitia.home')

@section('content-panitia')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Rekap Nilai Seminar Hasil Tahap {{ $tahapInfo->tahap }}</h1>
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
                                    <button type="button" class="btn btn-success" id="btn-publish-nilai-semhas">
                                        Publish Nilai
                                    </button>
                                    <button type="button" class="btn btn-danger" id="btn-hide-nilai-semhas">
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
                                <select class="custom-select" id="periode_semhas_id"
                                    aria-label="Example select with button addon">

                                    <option disabled>Pilih Periode</option>
                                    @foreach ($periodeInfo as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button id="buttonTampilNilaiSemhasByPeriode" class="btn btn-outline-secondary"
                                        type="button">Tampilkan</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="tahap_semhas_id" value="{{ $tahapInfo->id }}">
                        <input type="hidden" id="prodi_panitia_semhas_id" value="{{ $dosenPanitiaInfo->prodi_id }}">

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
            <div class="row">
                <p class="text">
                    Status Nilai Sidang Laporan Akhir Periode {{ $periodeAktif->tahun }} Tahap {{ $tahapInfo->tahap }}:
                    @if ($visibilitasNilai)
                        <b class="text-green">Sudah Dipublikasikan</b>
                    @else
                        <b class="text-red">Belum Dipublikasikan</b>
                    @endif
                </p>
            </div>
            <div class="row">
                <a href="{{ route("panitia.seminar-hasil.tahap-rekap-nilai") }}" class="btn btn-info mt-2">
                    Kembali
                </a>
            </div>

        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('modals')
    <div id="modal-publish-rekap-nilai-semhas" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title">Publish Rekap Nilai Sidang Laporan Akhir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin mempublish rekap nilai Sidang Laporan Akhir <b>Tahap {{ $tahapInfo->tahap }} Periode {{ $periodeAktif->tahun }}</b> ?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('panitia.kelola-seminar.visibilitas-nilai.publish') }}" method="post">
                        @csrf
                        <input type="hidden" name="tahap_id" value="{{ $tahapInfo->id }}">
                        <input type="hidden" name="periode_id" value="">
                        <input type="hidden" name="jenis_nilai_seminar" value="2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" style="width: 75px">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-hide-rekap-nilai-semhas" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title">Sembunyikan Rekap Nilai Sidang Laporan Akhir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menyembunyikan rekap nilai Sidang Laporan Akhir <b>Tahap {{ $tahapInfo->tahap }} Periode {{ $periodeAktif->tahun }}</b> ?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('panitia.kelola-seminar.visibilitas-nilai.hide') }}" method="post">
                        @csrf
                        <input type="hidden" name="tahap_id" value="{{ $tahapInfo->id }}">
                        <input type="hidden" name="periode_id" value="">
                        <input type="hidden" name="jenis_nilai_seminar" value="2">
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