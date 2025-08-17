@extends('admin-prodi.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dosen</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <form id="search-dosen-form" action="{{ route("admin-prodi.dosen.search") }}" method="get">
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
                            <table id="tabel-dosen" class="table table-head-fixed text-nowrap"
                                data-url="{{ route("admin-prodi.dosen") }}">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIDN</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody id="dosen-table-body">

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-body">
                            <form id="impor-file" action="{{ route("admin-prodi.dosen.import") }}" method="post"
                                enctype="multipart/form-data">
                                <label>Impor Data Dosen</label>
                                @csrf
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
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection

@push('page-scripts')
    <script src="{{ url("/custom/js/dosen/load-data-dosen.js") }}"></script>
    <script src="{{ url("/custom/js/dosen/search-dosen.js") }}"></script>
    <script src="{{ url("/custom/js/dosen/impor-data-excel.js") }}"></script>
    <script src="{{ url("/custom/js/animate-custom-file-input.js") }}"></script>
@endpush