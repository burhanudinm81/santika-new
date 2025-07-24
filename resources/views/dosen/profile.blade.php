@extends('dosen.home')

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
                        @isset(auth("dosen")->user()->foto_profil)
                            <img class="profile-user-img img-circle" data-toggle="tooltip" data-placement="right"
                                title="Klik untuk mengubah foto profil"
                                src="{{ asset("/storage/" . auth("dosen")->user()->foto_profil) }}"
                                alt="User profile picture" width="100px" height="100px" />
                        @else
                            <img class="profile-user-img img-circle" src="{{url("/images/blank-profile-64x64.png")}}"
                                alt="User profile picture" data-toggle="tooltip" data-placement="right"
                                title="Klik untuk mengubah foto profil" width="100px" height="100px" />
                        @endisset
                    </div>

                    <h3 class="profile-username text-center">{{ auth("dosen")->user()->nama ?? "-"}}</h3>
                    <p class="text-muted text-center">Jurusan Teknik Elektro</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <div class="list-group-item mb-3">
                            <div>
                                <label for="" class="form-label mb-1">NIDN</label>
                                <p>{{ auth("dosen")->user()->nidn ?? "-" }}</p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">NIP</label>
                                <p>{{ auth("dosen")->user()->nip ?? "-" }}</p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Email</label>
                                <p>{{ auth("dosen")->user()->email ?? "-" }}</p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Nomor Handphone</label>
                                <p>{{ auth("dosen")->user()->no_handphone ?? "-" }}</p>
                            </div>
                            @php
                                $keahlian = $dosen->bidangMinats->pluck('bidang_minat')->values();
                            @endphp
                            <div>
                                <label class="form-label mb-1">Bidang Keahlian 1</label>
                                <p>{{ $keahlian->get(0) ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="form-label mb-1">Bidang Keahlian 2</label>
                                <p>{{ $keahlian->get(1) ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="form-label mb-1">Bidang Keahlian 3</label>
                                <p>{{ $keahlian->get(2) ?? '-' }}</p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Profil</label>
                                <p>{{ auth("dosen")->user()->deskripsi_profil ?? "-" }}</p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Peminatan Riset</label>
                                <div class="card">
                                    @isset(auth("dosen")->user()->gambar_peminatan_riset)
                                        <img src="{{ asset("/storage/" . auth("dosen")->user()->gambar_peminatan_riset) }}"
                                            class="card-img-top img-fluid mx-auto" alt="Gambar Peminatan Riset" style="max-width: 600px">
                                    @endisset
                                    <div class="card-body">
                                        <p class="card-text">
                                            {{ auth("dosen")->user()->deskripsi_peminatan_riset ?? "-" }}</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Publikasi</label>
                                <p>{{ auth("dosen")->user()->publikasi ?? "-" }}</p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Google Scholar</label>
                                <p>
                                    <a href="{{ auth("dosen")->user()->link_google_scholar ?? "#" }}" target="_blank">
                                        {{ auth("dosen")->user()->link_google_scholar ?? "-" }}</a>
                                </p>
                            </div>
                            <div>
                                <label for="" class="form-label mb-1">Penghargaan Yang Pernah Diberikan</label>
                                <p>{{ auth("dosen")->user()->penghargaan ?? "-" }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn btn-block btn-success btn-block" id="edit-profile-btn"><b>Edit
                                Profil</b></button>
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                            data-target="#modal-ubah-password">
                            <b>Ubah Password</b>
                        </button>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@push('page-scripts')
    <script src="{{ asset('/custom/js/profile/edit-profile-image.js') }}"></script>
    <script src="{{ asset('/custom/js/profile/edit-dosen-profile.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(".profile-user-img").tooltip();
            $(".profile-user-img").click(function () {
                $("#modal-ubah-foto-profil").modal();
            });
        });
    </script>
@endpush