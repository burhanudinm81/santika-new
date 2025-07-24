@extends('mahasiswa.home')

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
                        @isset(auth("mahasiswa")->user()->foto_profil)
                            <img class="profile-user-img img-circle" data-toggle="tooltip" data-placement="right"
                                title="Klik untuk mengubah foto profil"
                                src="{{ asset("/storage/" . auth("mahasiswa")->user()->foto_profil) }}"
                                alt="User profile picture" width="100px" height="100px" />
                        @else
                            <img class="profile-user-img img-circle" src="{{url("/images/blank-profile-64x64.png")}}"
                                alt="User profile picture" data-toggle="tooltip" data-placement="right"
                                title="Klik untuk mengubah foto profil" width="100px" height="100px" />
                        @endisset
                    </div>

                    <h3 class="profile-username text-center">{{ auth("mahasiswa")->user()->nama }}</h3>
                    <p class="text-muted text-center">{{ auth("mahasiswa")->user()->NIM }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <div class="list-group-item mb-3">
                            <div>
                                <label for="" class="form-label mb-1">NIM</label>
                                <p>{{ auth("mahasiswa")->user()->nim  }}</p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Program Studi</label>
                                <p>{{ auth("mahasiswa")->user()->prodi->prodi  }}</p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Angkatan</label>
                                <p>{{ auth("mahasiswa")->user()->angkatan  }}</p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Kelas</label>
                                <p>{{ auth("mahasiswa")->user()->kelas  }}</p>
                            </div>
                        </div>
                        <form action="{{ route('mahasiswa.profile.edit-email') }}" method="post" id="edit-email-form">
                            @csrf
                            <div class="mb-3">
                                <label for="email-input" class="form-label">Email address</label>
                                @if (!is_null(auth("mahasiswa")->user()->email))
                                    <input type="email" class="form-control" id="email-input" name="email"
                                        placeholder="name@student.polinema.ac.id"
                                        value="{{ auth("mahasiswa")->user()->email }}" maxlength="255" required>
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
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

{{-- Modal Pop-up Berhasil --}}
<div class="modal fade" id="modal-popup-sukses">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sukses</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Data berhasil diperbarui</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Pop-up Gagal --}}
<div class="modal fade" id="modal-popup-error">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Gagal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Terjadi kesalahan saat memperbarui data.</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script src="{{ asset('/custom/js/profile/edit-email.js') }}"></script>
<script src="{{ asset('/custom/js/profile/edit-profile-image.js') }}"></script>
<script>
    $(function () {
        $('.profile-user-img').tooltip().on('click', function () {
            $('#modal-ubah-foto-profil').modal('show');
        });
    });
</script>
@endpush
