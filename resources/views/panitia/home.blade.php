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
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('panitia.navbar')

        @include('panitia.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content-panitia')
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>

        @include('panitia.footer')

        <!-- Modal Pop Up Sukses -->
        <div class="modal" id="modal-popup-sukses" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="mr-2 fas fa-2x fa-check-circle" style="color: green"></i>
                        <h5 class="modal-title">Modal Title</h5>
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
                        <h5 class="modal-title">Modal Title</h5>
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

        <!-- Modal Ganti Password -->
        <div class="modal fade" id="modal-ubah-password" tabindex="-1" role="dialog"
            aria-labelledby="modal-ganti-password-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-ganti-password-label">Ubah Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="form-ubah-password">
                            @csrf
                            <div class="form-group">
                                <label for="current-password">Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current-password"
                                        name="current_password" placeholder="Masukkan password lama">
                                    <div class="input-group-append" id="show-current-password">
                                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="new-password">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new-password"
                                        name="new_password" placeholder="Masukkan password baru">
                                    <div class="input-group-append" id="show-new-password">
                                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm-password"
                                        name="new_password_confirmation" placeholder="Konfirmasi password baru">
                                    <div class="input-group-append" id="show-confirm-password">
                                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="save-password-btn">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Kuota Dosen -->
        <div class="modal fade" id="editKuotaModal" tabindex="-1" role="dialog"
            aria-labelledby="editKuotaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKuotaModalLabel">Edit Kuota Dosen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editKuotaForm">
                        <div class="modal-body">
                            <input type="hidden" id="edit-kuota-id" name="kuota_id">
                            <input type="hidden" id="edit-prodi-id" name="prodi_id">
                            <div class="form-group">
                                <label>Nama Dosen</label>
                                <p id="edit-nama-dosen"></p>
                            </div>
                            <div class="form-group">
                                <label for="edit-kuota-value">Kuota Pembimbing 1</label>
                                <input type="number" class="form-control" id="edit-kuota-value" min="0"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- REQUIRED SCRIPTS -->
    @include('required-js')
    <script src="{{ asset('/custom-assets/js/seminar-proposal.js') }}"></script>
    <script src="{{ asset('/custom-assets/js/seminar-hasil.js') }}"></script>
    <script src={{ url('/custom/js/load-content.js') }}></script>
    <script src="{{ url('/custom/js/animate-custom-file-input.js') }}"></script>
    <script src="{{ url('/custom/js/profile/change-password.js') }}"></script>

    @yield('scripts-panitia')
</body>

</html>
