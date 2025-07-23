@extends('panitia.home')

@section('content-panitia')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pendaftaran Seminar Hasil</h1>
                    <!-- Tombol Buka Tahap Baru -->
                    <button type="button" id="btnBukaTahap" class="btn btn-primary mt-3">
                        Buka Tahap Baru
                    </button>
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
                                <h5>15 Mahasiswa</h5>
                                <h3>Tahap {{ $tahap->tahap }}</h3>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <a href="{{ route('panitia.seminar-hasil.pendaftaran-detail', $tahap->id) }}"
                                class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach


                <!-- kotak tahap berikutnya akan ditambahkan di sini -->
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
