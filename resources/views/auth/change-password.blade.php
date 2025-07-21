<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>STAKOM | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    @include('required-css')

    <link rel="stylesheet" href={{ url("/custom/css/login.css") }}>
</head>

<body class="hold-transition login-page">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title font-weight-bold">Ubah Password Default</h4>
                    </div>

                    {{-- Form menunjuk ke route yang akan memproses perubahan password --}}
                    <form action="{{ route('password.change.submit') }}" method="post" id="form-ubah-password">
                        @csrf
                        <div class="card-body">

                            {{-- Menampilkan pesan peringatan dari Middleware --}}
                            @if (session('warning'))
                                <div class="alert alert-warning">
                                    {{ session('warning') }}
                                </div>
                            @endif

                            {{-- Placeholder untuk menampilkan error validasi umum --}}
                            <div id="validation-errors" class="alert alert-danger" style="display: none;"></div>

                            <div class="form-group">
                                <label for="current-password">Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current-password"
                                        name="current_password" placeholder="Masukkan Password Lama" required>

                                    <div class="input-group-append toggle-password" data-target="#current-password">
                                        <span class="input-group-text" style="cursor: pointer;">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <small class="form-text text-danger error-text" id="current_password_error"></small>
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
                                <small class="form-text text-danger error-text" id="new_password_error"></small>
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        name="new_password_confirmation" placeholder="Konfirmasi password baru"
                                        required>
                                    <div class="input-group-append toggle-password"
                                        data-target="#new_password_confirmation">
                                        <span class="input-group-text" style="cursor: pointer;">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('logout') }}" class="btn btn-secondary" onclick="{{--}event.preventDefault();
                document.getElementById('logout-form').submit();--}}">
                                Kembali (Logout)
                            </a>
                            <button type="submit" class="btn btn-primary" id="save-password-btn">Simpan Password
                                Baru</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('required-js')

    <script src={{ url("/custom/js/auth/change-password.js") }}></script>
</body>

</html>