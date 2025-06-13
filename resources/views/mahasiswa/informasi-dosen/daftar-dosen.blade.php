<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profil Dosen</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body pb-0">
                <div class="row">
                    @foreach ($dosen as $dsn)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                    {{ $dsn->bidang_minat_1 }}
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b>{{ $dsn->nama }}</b></h2>
                                        </div>
                                        <div class="col-5 text-center">
                                            @if (is_null($dsn->foto_profil))
                                                <img src="{{ url("/images/blank-profile-64x64.png") }}" alt="user-avatar"
                                                    class="img-circle img-fluid">
                                            @else
                                                <img src="{{ asset("/storage/" . $dsn->foto_profil) }}" alt="user-avatar"
                                                    class="img-circle img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer container">
                                    <div class="row justify-content-between">
                                        <div class="col">
                                            @if (auth("mahasiswa")->user()->prodi == App\Enum\Prodi::D3TT)
                                                <p><b>Sisa Kuota Pembimbing 1: </b>{{ $dsn->kuotaDosen->kuota_pembimbing_1_D3 }}</p>
                                            @elseif (auth("mahasiswa")->user()->prodi == App\Enum\Prodi::D4JTD)
                                                <p><b>Sisa Kuota Pembimbing 1: </b>{{ $dsn->kuotaDosen->kuota_pembimbing_1_D4 }}</p>
                                            @endif
                                        </div>
                                        <div class="col text-right">
                                            <a href="{{ route("mahasiswa.informasi-dosen.profil-dosen", ["id" => $dsn->id]) }}" class="btn btn-sm btn-primary view-profile-btn">
                                                <i class="fas fa-user"></i> Lihat Profil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <nav aria-label="Contacts Page Navigation">
                    <ul class="pagination justify-content-center m-0">
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                        <li class="page-item"><a class="page-link" href="#">8</a></li>
                    </ul>
                </nav>
            </div>
            <!-- /.card-footer -->
        </div>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
 <script src="{{ url("/custom/js/open-detail-page.js") }}"></script>