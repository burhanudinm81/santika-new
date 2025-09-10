<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SANTIKA</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @include('required-css')
    @yield('page-style')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div id="loading-overlay">
            <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        @include('admin-prodi.navbar')

        @include('admin-prodi.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        @include('admin-prodi.footer')

        <!-- Modal Pop Up Sukses -->
        <div class="modal" id="modal-popup-sukses" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="mr-2 fas fa-2x fa-check-circle" style="color: green"></i>
                        <h5 class="modal-title">Sukses</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Pop Up Error -->
        <div class="modal" id="modal-popup-error" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="mr-2 fas fa-2x fa-exclamation-circle" style="color: red"></i>
                        <h5 class="modal-title">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background-color: #f8d7da; color: #721c24;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ubah Foto Profil -->
        <div class="modal fade" id="modal-ubah-foto-profil" data-backdrop="static" data-keyboard="false" tab-index="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-ubah-foto-profil-label">Ubah Foto Profil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- route("admin-prodi.profile.edit-image") -->
                        <form id="form-ubah-foto-profil" action="#" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="foto-profil-baru">Upload Foto Profil:</label>
                                <div class="custom-file">
                                    <input type="file" name="foto_profil_baru" id="foto-profil-baru"
                                        class="custom-file-input" accept="image/jpg, image/jpeg, image/png" required>
                                    <label class="custom-file-label" for="foto-profil-baru">Pilih File</label>
                                </div>
                                <small class="form-text text-muted">Tipe file yang diizinkan:
                                    jpg, jpeg, png</small>
                                <small class="form-text text-muted">Ukuran file maksimal 2 MB</small>
                                <small class="form-text text-muted">Disarankan untuk mengupload foto dengan aspect ratio
                                    1:1</small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="simpan-foto-profil-btn">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        @yield('modals')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @include('required-js')
    <!-- <script src={{ url("/custom/js/load-content.js") }}></script> -->
    <script src={{ url("/custom/js/animate-custom-file-input.js") }}></script>
    <script src="{{ url("/custom/js/profile/change-password.js") }}"></script>

    @stack('page-scripts')
</body>

</html>