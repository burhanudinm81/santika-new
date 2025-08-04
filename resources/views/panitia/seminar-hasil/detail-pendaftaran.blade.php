@extends('panitia.home')

@section('content-panitia')
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
                            <div class="card-tools">
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
                                <select class="custom-select" id="periode_id"
                                    aria-label="Example select with button addon">

                                    <option disabled>Pilih Periode</option>
                                    @foreach ($periodeInfo as $periode)
                                        <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button id="buttonTampilByPeriodeSemhas" class="btn btn-outline-secondary" type="button">Tampilkan</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="tahap_id" value="{{ $tahapInfo->id }}">
                        <input type="hidden" id="prodi_panitia_id" value="{{ $dosenPanitiaInfo->prodi_id }}">

                        <div class="card-body border border-2 border-danger table-responsive p-0" style="height: 320px">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    @if($dosenPanitiaInfo->prodi_id == 1)
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
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
@endsection
