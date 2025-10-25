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
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Pendaftaran Seminar Hasil Tahap {{ $tahapInfo->tahap }}</h1>
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
                                    <button type="button" class="btn btn-success" id="btn-buka-pendaftaran-sidang-ta">
                                        Buka Pendaftaran
                                    </button>
                                    @if ($tahapInfo->aktif_sidang_akhir)
                                        <button type="button" class="btn btn-danger" id="btn-nonaktifkan-tahap-sidang-ta">
                                            Tutup Pendaftaran
                                        </button>
                                    @endif
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
                                <select class="custom-select" id="periode_id" aria-label="Example select with button addon">

                                    <option disabled>Pilih Periode</option>
                                    @foreach ($periodeInfo as $periode)
                                        <option value="{{ $periode->id }}" {{ request('periode') == $periode->id ? 'selected' : '' }}>{{ $periode->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button id="buttonTampilByPeriodeSemhas" class="btn btn-outline-secondary"
                                        type="button">Tampilkan</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="tahap_id" value="{{ $tahapInfo->id }}">
                        <input type="hidden" id="prodi_panitia_id" value="{{ $dosenPanitiaInfo->prodi_id }}">

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
                                            <th class="text-center align-middle">Detail</th>
                                        </tr>
                                    @elseif($dosenPanitiaInfo->prodi_id == 2)
                                        <tr>
                                            <th class="text-center align-middle">No</th>
                                            <th class="text-center align-middle">NIM</th>
                                            <th class="text-center align-middle">Nama</th>
                                            <th class="text-center align-middle">Judul</th>
                                            <th class="text-center align-middle">Status</th>
                                        </tr>
                                    @endif
                                </thead>
                                <tbody id="data-table-body">
                                    {{-- <tr>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">2141160091</td>
                                        <td class="text-center align-middle">Dwiki Raditya Krisdyanto</td>
                                        <td class="text-center align-middle">Rancang Bangun Sistem Informasi Tugas Akhir
                                            Prodi D4 Jaringan Telekomunikasi Digital</td>
                                        <td class="text-center align-middle">
                                            <span class="badge badge-success">Telah di Verifikasi</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="sempro3.php" button type="button"
                                                class="btn btn-primary btn-sm">View</a>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <a href="{{ route("panitia.seminar-hasil.pendaftaran") }}" class="btn btn-info mt-2">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div id="modal-buka-pendaftaran-sidang-ta" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('panitia.kelola-periode-tahap.ubah-tahap-sidang-ta-aktif') }}" method="post">
                    @csrf
                    <input type="hidden" name="tahap_id" value="{{ $tahapInfo->id }}">
                    <div class="modal-header">
                        <h5 class=" modal-title">Buka Pendaftaran Sidang Tugas Akhir</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin membuka pendaftaran Sidang Tugas Akhir Tahap {{ $tahapInfo->tahap }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Buka Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-tutup-pendaftaran-sidang-ta" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title">Tutup Pendaftaran Sidang Tugas Akhir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menutup pendaftaran Sidang Tugas Akhir?</p>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tidak</button>
                    <a href="{{ route('panitia.kelola-periode-tahap.nonaktifkan-tahap-sidang-ta') }}" class="btn btn-danger"
                        style="width: 75px">Ya</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-panitia')
    <script src="{{ url("/custom/js/seminar/pengaturan-seminar.js") }}"></script>
@endsection