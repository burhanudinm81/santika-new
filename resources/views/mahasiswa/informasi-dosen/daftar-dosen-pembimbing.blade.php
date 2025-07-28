@extends('mahasiswa.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Dosen Pembimbing</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card card-solid">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                    Dosen Pembimbing 1
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b>{{ $proposal->dosenPembimbing1->nama }}</b></h2>
                                        </div>
                                        <div class="col-5 text-center">
                                            <img src="{{ $proposal->dosenPembimbing1->foto_profil ?? url('/images/blank-profile-64x64.png') }}"
                                                alt="user-avatar" class="img-circle img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <a href="{{ route('mahasiswa.informasi-dosen.profil-dosen', ['id' => $proposal->dosenPembimbing1->id]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-user"></i> View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (!is_null($proposal->dosenPembimbing2))
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-header text-muted border-bottom-0">
                                        Dosen Pembimbing 2
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="lead"><b>{{ $proposal->dosenPembimbing2->nama }}</b></h2>
                                            </div>
                                            <div class="col-5 text-center">
                                                <img src="{{ $proposal->dosenPembimbing2->foto_profil ?? url('/images/blank-profile-64x64.png') }}"
                                                    alt="user-avatar" class="img-circle img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-right">
                                            <a href="{{ route('mahasiswa.informasi-dosen.profil-dosen', ['id' => $proposal->dosenPembimbing2->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-user"></i> View Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection