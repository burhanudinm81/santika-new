@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jadwal Seminar Proposal</h1>
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
                                <h3>Tahap {{ $tahap->tahap }}</h3>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <a href="{{ route('dosen.seminar-proposal.jadwal', ['tahapId' => $tahap->tahap]) }}" class="small-box-footer">
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
