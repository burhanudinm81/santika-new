@extends('admin-prodi.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Mahasiswa D4 Jaringan Telekomunikasi Digital</h1>
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
                                <form id="search-mahasiswa-form" action="{{ route("admin-prodi.mahasiswa.d4.search") }}"
                                    method="get">
                                    <div class="input-group input-group-sm" style="width: 150px">
                                        <input type="text" name="table_search" class="form-control float-right"
                                            placeholder="Search" />

                                        <div class="input-group-append">
                                            <button id="search-button" type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 400px">
                            <table id="tabel-mahasiswa" class="table table-head-fixed text-nowrap"
                                data-url="{{ route("admin-prodi.mahasiswa.d4") }}">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Periode</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Program Studi</th>
                                        <th>Kelas</th>
                                        <th>Angkatan</th>
                                    </tr>
                                </thead>
                                <tbody id="mahasiswa-table-body">

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card -->
                    </div>

                    @can("createMhsD4", App\Models\Mahasiswa::class)
                        <div class="card">
                            <div class="card-body">
                                <form id="impor-file" action="{{ route("admin-prodi.mahasiswa.d4.import") }}" method="post"
                                    enctype="multipart/form-data">
                                    <label>Impor Data Mahasiswa D4</label>
                                    @csrf
                                    <div class="form-group">
                                        <label for="periode">Periode</label>
                                        <select class="custom-select" id="periode" name="periode">
                                            <option selected>-</option>
                                            @foreach ($periode as $prd)
                                                <option value="{{ $prd->id }}">{{ $prd->tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="file-excel"> File Spreadsheet (.xlsx)</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="file-excel"
                                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                                    name="file_excel">
                                                <label class="custom-file-label" for="file-excel" aria-describedby="test">Pilih
                                                    file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button id="upload-btn" type="submit" class="btn btn-success">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script src="{{ url("/custom/js/animate-custom-file-input.js") }}"></script>
    <script src="{{ url("/custom/js/mahasiswa/load-data-mahasiswa.js") }}"></script>
    <script src="{{ url("/custom/js/mahasiswa/search-mahasiswa.js") }}"></script>
    <script src={{ url("/custom/js/mahasiswa/impor-data-excel.js") }}></script>
@endpush