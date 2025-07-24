<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
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

    @include('required-js')
    @stack('page-scripts')

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('mahasiswa.navbar')

        @include('mahasiswa.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if (session('error'))
                @include('notifications.error-alert', ['message' => session('error')])
            @endif

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


        @include('mahasiswa.footer')
        <!-- ./wrapper -->

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
                        <!-- route("mahasiswa.profile.edit-image") -->
                        <form id="form-ubah-foto-profil" action="{{ route('mahasiswa.profile.edit-image') }}"
                            method="post" enctype="multipart/form-data">
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

        <!-- Modal Ganti Password -->
        <div class="modal fade" id="modal-ubah-password" tabindex="-1" role="dialog"
            aria-labelledby="modal-ganti-password-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-ganti-password-label">Ubah Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- route("mahasiswa.change-password") -->
                        <form action="{{ route('mahasiswa.profile.change-password') }}" method="post" id="form-ubah-password">
                            @csrf
                            <div class="form-group">
                                <label for="current-password">Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current-password"
                                        name="current_password" placeholder="Masukkan password lama">
                                    <div class="input-group-append toggle-password" data-target="#current-password">
                                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                                <span class="invalid-feedback d-block" id="current_password_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="new-password">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new-password" name="new_password"
                                        placeholder="Masukkan password baru">
                                    <div class="input-group-append toggle-password" data-target="#new-password">
                                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                                <span class="invalid-feedback d-block" id="new_password_error" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm-password"
                                        name="new_password_confirmation" placeholder="Konfirmasi password baru">
                                    <div class="input-group-append toggle-password" data-target="#confirm-password">
                                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                                <span class="invalid-feedback d-block" id="new_password_confirmation_error" role="alert"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="save-password-btn" form="form-ubah-password">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- REQUIRED SCRIPTS -->

    @include('required-js')
    <script src="{{ asset('/custom/js/home/mahasiswa.js') }}"></script>
    <script src="{{ asset('/custom/js/animate-custom-file-input.js') }}"></script>
    <script src="{{ asset('/custom/js/auth/change-password.js') }}"></script>
    <script src="{{ asset('/custom-assets/js/pengajuan-judul.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    {{-- <!-- @if ($forceChangePassword)
<script>
    $("#modal-ubah-password").modal();

    $("#modal-ubah-password").on("hidden.bs.modal", function() {
        document.location = "/logout";
    });
</script> -->
    @endif --}}

</body>

</html>