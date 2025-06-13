<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row justify-content-between mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Pengajuan Judul</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route("dosen.permohonan-judul") }}" class="btn btn-primary back-btn">Back</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-body">
                        <div class="list-group">
                            <div class="list-group-item pb-0">
                                <h5 class="font-weight-bold">Dosen Pembimbing 1</h5>
                                <p>{{ $pengajuanJudul->dosen->nama }}</p>
                            </div>
                            @if (auth("mahasiswa")->user()->prodi == App\Enum\Prodi::D4JTD)
                                <div class="list-group-item pb-0">
                                    <h5 class="font-weight-bold">Nama Mahasiswa</h5>
                                    <p>{{ $pengajuanJudul->mahasiswa1->nama }}</p>
                                </div>
                                <div class="list-group-item pb-0">
                                    <h5 class="font-weight-bold">NIM</h5>
                                    <p>{{ $pengajuanJudul->mahasiswa1->NIM }}</p>
                                </div>
                            @elseif(auth("mahasiswa")->user()->prodi == App\Enum\Prodi::D3TT)
                                <div class="list-group-item pb-0">
                                    <h5 class="font-weight-bold">Nama Mahasiswa 1</h5>
                                    <p>{{ $pengajuanJudul->mahasiswa1->nama }}</p>
                                </div>
                                <div class="list-group-item pb-0">
                                    <h5 class="font-weight-bold">NIM Mahasiswa 1</h5>
                                    <p>{{ $pengajuanJudul->mahasiswa1->NIM }}</p>
                                </div>
                                <div class="list-group-item pb-0">
                                    <h5 class="font-weight-bold">Nama Mahasiswa 2</h5>
                                    <p>{{ $pengajuanJudul->mahasiswa2->NIM }}</p>
                                </div>
                                <div class="list-group-item pb-0">
                                    <h5 class="font-weight-bold">NIM Mahasiswa 2</h5>
                                    <p>{{ $pengajuanJudul->mahasiswa2->NIM }}</p>
                                </div>
                            @endif
                            <div class="list-group-item pb-0">
                                <h5 class="font-weight-bold">Judul Proposal</h5>
                                <p>{{ $pengajuanJudul->judul }}</p>
                            </div>
                            <div class="list-group-item pb-0">
                                <h5 class="font-weight-bold">Jenis Judul</h5>
                                <p>{{ $pengajuanJudul->jenis_judul }}</p>
                            </div>
                            <div class="list-group-item pb-0">
                                <h5 class="font-weight-bold">Bidang</h5>
                                <p>{{ $pengajuanJudul->bidang }}</p>
                            </div>
                            <div class="list-group-item pb-0">
                                <h5 class="font-weight-bold">Topik/Tema Proposal</h5>
                                <p>{{ $pengajuanJudul->topik }}</p>
                            </div>
                            <div class="list-group-item pb-0">
                                <h5 class="font-weight-bold">Tujuan</h5>
                                <p>{{ $pengajuanJudul->tujuan }}</p>
                            </div>
                            <div class="list-group-item pb-0">
                                <h5 class="font-weight-bold">Latar Belakang</h5>
                                <p>{{ $pengajuanJudul->latar_belakang }}</p>
                            </div>
                            <div class="list-group-item">
                                <h5 class="font-weight-bold">Blok Diagram</h5>
                                <img class="img-fluid" style="width: 300px" src="{{ asset("/storage/" . $pengajuanJudul->blok_diagram_sistem) }}" alt="blok-diagram">
                            </div>
                            <div class="list-group-item pb-0">
                                <h5 class="font-weight-bold">Status</h5>
                                @if ($pengajuanJudul->status == App\Enum\StatusPengajuanJudul::DITOLAK->value)
                                    <div class="alert alert-danger"><b>{{ $pengajuanJudul->status }}</b></div>
                                @elseif ($pengajuanJudul->status == App\Enum\StatusPengajuanJudul::DITERIMA->value)
                                    <div class="alert alert-success"><b>{{ $pengajuanJudul->status }}</b></div>
                                @elseif ($pengajuanJudul->status == App\Enum\StatusPengajuanJudul::MENUNGGU_KONFIRMASI->value)
                                    <div class="alert alert-warning"><b>{{ $pengajuanJudul->status }}</b></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ url("/custom/js/back-to-previous-page.js") }}"></script>