@extends('panitia.home')

@section('content-panitia')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Rekap Nilai Seminar Proposal</h1>
                    <hr>
                    <h5>Periode {{ $periodeAktif->tahun }}</h5>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
            <div class="row" id="containerTahap">

                @foreach ($listTahap as $tahap)
                    <div class="col-lg-3 col-6">
                        <!-- kotak tahap -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h5>{{ $tahap->jumlahPeserta }} Mahasiswa</h5>
                                <h3>Tahap {{ $tahap->tahap }}</h3>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <a href="{{ route('panitia.seminar-proposal.beranda-rekap-nilai', $tahap->id) }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
