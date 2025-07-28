@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Mahasiswa Bimbingan</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                <div class="card card-primary card-outline mb-2">
                    <!--begin::Form-->
                    <form>
                        <!--begin::Body-->
                        <div class="card-body">
                            <p class="h4">Informasi Umum</p>
                            <hr style="border: 1px solid grey">

                            @if ($mahasiswa->prodi_id == 1)
                                <strong></i>Nama Mahasiswa 1</strong>
                                <p class="text-muted">{{ $mahasiswaInfo[0]->mahasiswa->nama }}</p>

                                <strong></i>Nama Mahasiswa 2</strong>
                                <p class="text-muted">{{ $mahasiswaInfo[1]->mahasiswa->nama }}</p>
                            @elseif($mahasiswa->prodi_id == 2)
                                <strong></i>Nama Mahasiswa </strong>
                                <p class="text-muted">{{ $mahasiswa->nama }}</p>

                                <strong></i>NIM Mahasiswa</strong>
                                <p class="text-muted">{{ $mahasiswa->nim }}</p>
                            @endif

                            <strong></i>Dosen Pembimbing 1</strong>
                            <p class="text-muted">{{ $proposalSemproInfo->dosenPembimbing1->nama }}</p>

                            <strong></i>Dosen Pembimbing 2</strong>
                            <p class="text-muted">{{ $proposalSemproInfo->dosenPembimbing2->nama }}</p>
                        </div>

                        <div class="card-body">
                            <p class="h4">Detail Proposal</p>
                            <hr style="border: 1px solid grey">
                            <strong></i>Judul Proposal</strong>
                            <p class="text-muted">{{ $proposalSemproInfo->judul }}</p>

                            <strong></i>Topik Proposal</strong>
                            <p class="text-muted">{{ $proposalSemproInfo->topik }}</p>

                            <strong></i>Tujuan Proposal</strong>
                            <p class="text-muted">{{ $proposalSemproInfo->tujuan }}</p>

                            <strong></i>Latar Belakang</strong>
                            <p class="text-muted">{{ $proposalSemproInfo->latar_belakang }}</p>

                            <strong></i>Diagram Blok Sistem</strong>
                            <div class="position-relative">
                                <img width="450" src="{{ $proposalSemproInfo->getBlokDiagramUrlAttribute() }}"
                                    class="img-fluid" alt="...">
                            </div>
                        </div>

                        <!--end::Body-->
                        <!--begin::Footer-->
                        <!--end::Footer-->
                    </form>
                    <!--end::Form-->

                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
