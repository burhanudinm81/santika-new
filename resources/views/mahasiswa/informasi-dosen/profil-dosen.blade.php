@extends('mahasiswa.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row justify-content-between mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profil Dosen</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route("mahasiswa.informasi-dosen.daftar-dosen") }}"
                        class="btn btn-primary back-btn">Back</a>
                </div>
            </div>
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
                            @isset($dosen->foto_profil)
                                <img class="profile-user-img img-circle" data-toggle="tooltip" data-placement="right"
                                    title="Klik untuk mengubah foto profil" src="{{ asset("/storage/" . $dosen->foto_profil) }}"
                                    alt="User profile picture" width="100px" height="100px" />
                            @else
                                <img class="profile-user-img img-circle" src="https://placehold.co/100x100"
                                    alt="User profile picture" data-toggle="tooltip" data-placement="right"
                                    title="Klik untuk mengubah foto profil" width="100px" height="100px" />
                            @endisset
                        </div>

                        <h3 class="profile-username text-center">{{ $dosen->nama ?? "-" }}</h3>
                        <p class="text-muted text-center">Jurusan Teknik Elektro</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <div class="list-group-item mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div>
                                            <label for="" class="form-label mb-1">NIDN</label>
                                            <p>{{ $dosen->nidn ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label for="" class="form-label mb-1">NIP</label>
                                            <p>{{ $dosen->nip ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label for="" class="form-label mb-1">Email</label>
                                            <p>{{ $dosen->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="" class="form-label mb-1">Nomor Handphone</label>
                                            <p>{{ $dosen->no_handphone ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label for="" class="form-label mb-1">Bidang Keahlian</label>
                                            @if ($dosen->bidangMinats->isNotEmpty())
                                                <ul>
                                                    @foreach ($dosen->bidangMinats as $bidangMinat)
                                                        <li>{{ $bidangMinat->bidang_minat }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p>-</p>
                                            @endif
                                        </div>
                                        <div>
                                            <label for="" class="form-label mb-1">Profil</label>
                                            <p>{{ $dosen->deskripsi_profil ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <label for="" class="form-label mb-1">Peminatan Riset</label>
                                    <div class="card">
                                        @isset($dosen->gambar_peminatan_riset)
                                            <img src="{{ asset("/storage/" . $dosen->gambar_peminatan_riset) }}"
                                                class="card-img-top img-fluid mx-auto" alt="Gambar Peminatan Riset"
                                                style="max-width: 600px">
                                        @endisset
                                        <div class="card-body">
                                            <p class="card-text">
                                                {{ $dosen->deskripsi_peminatan_riset ?? "-" }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <label for="" class="form-label mb-1">Publikasi</label>
                                    <p>{{ $dosen->publikasi ?? '-' }}</p>
                                </div>
                                <hr>
                                <div>
                                    <label for="" class="form-label mb-1">Google Scholar</label>
                                    <p>
                                        <a href="{{ $dosen->link_google_scholar ?? '#' }}" target="_blank">
                                            {{ $dosen->link_google_scholar ?? '-' }}</a>
                                    </p>
                                </div>
                                <hr>
                                <div>
                                    <label for="" class="form-label mb-1">Penghargaan Yang Pernah Diberikan</label>
                                    <p>{{ $dosen->penghargaan ?? '-' }}</p>
                                </div>
                                <hr>
                                <div>
                                    <label for="" class="form-label mb-1">Sisa Kuota Pembimbing 1:</label>

                                    @if ($userProdi === 'D3 Teknik Telekomunikasi')
                                        <p>{{ optional($dosen->kuotaDosen)->kuota_pembimbing_1_D3 ?? '-' }}</p>
                                    @elseif ($userProdi === 'D4 Jaringan Telekomunikasi Digital')
                                        <p>{{ optional($dosen->kuotaDosen)->kuota_pembimbing_1_D4 ?? '-' }}</p>
                                    @else
                                        <p>-</p>
                                    @endif
                                </div>
                            </div>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection
<!-- /.content -->
<script src="{{ url("/custom/js/back-to-previous-page.js") }}"></script>