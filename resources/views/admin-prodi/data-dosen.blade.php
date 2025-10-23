@extends('admin-prodi.home')

@section('page-style')
    <link rel="stylesheet" href="{{ url('/custom/css/custom.css') }}">
@endsection

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
                                        <th class="text-center">No</th>
                                        <th class="text-center">NIDN</th>
                                        <th class="text-center">NIP</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Kelola Akun</th>
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
                                    <a href="{{ asset('/templates/template-impor-data-dosen.xlsx') }}"
                                        id="download-template" class="form-text text-primary">Download template Impor Data
                                        Dosen</a>
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

@section('modals')
    <div id="modal-hapus-dosen" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin-prodi.dosen.delete') }}" id="form-hapus-dosen" class="modal-content"
                method="post">
                @csrf
                @method('DELETE')
                <input type="hidden" name="dosen_id">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-center">Konfirmasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                </div>
            </form>
        </div>
    </div>
    <div id="modal-ganti-password-dosen" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin-prodi.dosen.change-password') }}" id="form-ganti-password-dosen" class="modal-content" method="post">
                @csrf
                @method('PATCH')
                <input type="hidden" name="dosen_id">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold text-center">Ganti Password Dosen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama-dosen">Dosen</label>
                        <input type="text" class="form-control" id="nama-dosen" readonly>
                    </div>
                    <div class="form-group">
                        <label for="new-password">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new-password" name="new_password"
                                placeholder="Masukkan password baru" required>
                            <div class="input-group-append toggle-password" data-target="#new-password">
                                <span class="input-group-text" style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new-password-confirmation">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new-password-confirmation"
                                name="new_password_confirmation" placeholder="Konfirmasi password baru" required>
                            <div class="input-group-append toggle-password" data-target="#new-password-confirmation">
                                <span class="input-group-text" style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script src="{{ url("/custom/js/dosen/load-data-dosen.js") }}"></script>
    <script src="{{ url("/custom/js/dosen/delete-dosen.js") }}"></script>
    <script src="{{ url("/custom/js/dosen/change-password-dosen.js") }}"></script>
    <script src="{{ url("/custom/js/dosen/search-dosen.js") }}"></script>
    <script src="{{ url("/custom/js/dosen/impor-data-excel.js") }}"></script>
    <script src="{{ url("/custom/js/animate-custom-file-input.js") }}"></script>
@endpush