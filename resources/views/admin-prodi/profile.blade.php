@extends('admin-prodi.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profil</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @isset(auth()->user()->foto_profil)
                                <img class="profile-user-img img-circle" data-toggle="tooltip" data-placement="right"
                                    title="Klik untuk mengubah foto profil"
                                    src="{{ asset("/storage/" . auth()->user()->foto_profil) }}" alt="User profile picture"
                                    width="100px" height="100px" />
                            @else
                                <img class="profile-user-img img-circle" src="{{url("/images/blank-profile-64x64.png")}}"
                                    alt="User profile picture" data-toggle="tooltip" data-placement="right"
                                    title="Klik untuk mengubah foto profil" width="100px" height="100px" />
                            @endisset
                        </div>

                        <h3 class="profile-username text-center">{{ auth()->user()->nama }}</h3>

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-1">Email</h5>
                                <p id="email-text" class="card-text">{{ auth()->user()->email ?? '-' }}</p>
                                <input type="hidden" class="form-control mb-2" id="email-input" name="email"
                                    placeholder="name@student.polinema.ac.id" value="{{ auth()->user()->email ?? '' }}"
                                    maxlength="255" required>
                                <button id="ubah-email-btn" type="button" class="btn btn-success">Ubah Email</button>
                                <button id="ganti-password-btn" type="button" class="btn btn-primary">Ganti
                                    Password</button>
                            </div>
                        </div>

                        <!-- <ul class="list-group list-group-unbordered mb-3">
                                            <form action="#" method="post"
                                                id="edit-email-form">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="email-input" class="form-label">Email address</label>
                                                    @if (!is_null(auth()->user()->email))
                                                        <input type="email" class="form-control" id="email-input" name="email"
                                                            placeholder="name@student.polinema.ac.id" value="{{ auth()->user()->email }}"
                                                            maxlength="255" required>
                                                    @else
                                                        <input type="email" class="form-control" id="email-input" name="email"
                                                            placeholder="name@student.polinema.ac.id" maxlength="255" required>
                                                    @endif
                                                </div>
                                                <button type="submit" class="btn btn-block btn-success btn-block"
                                                    id="save-email-btn"><b>Simpan
                                                        Email</b></button>
                                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                                    data-target="#modal-ubah-password">
                                                    <b>Ubah Password</b>
                                                </button>
                                            </form>
                                        </ul> -->
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('modals')
    <!-- Modal Ganti Password -->
    <div class="modal fade" id="modal-ganti-password" tabindex="-1" role="dialog"
        aria-labelledby="modal-ganti-password-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-ganti-password" class="modal-content" action="{{ route('admin-prodi.profile.change-password') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-ganti-password-label">Ubah Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="current-password">Password Lama</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="current-password" name="current_password"
                                placeholder="Masukkan Password Lama" required>

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
                                name="new_password_confirmation" placeholder="Konfirmasi password baru" required>
                            <div class="input-group-append toggle-password" data-target="#new_password_confirmation">
                                <span class="input-group-text" style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="save-password-btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script src="{{ url('custom/js/profile/admin-prodi.js') }}"></script>
@endpush