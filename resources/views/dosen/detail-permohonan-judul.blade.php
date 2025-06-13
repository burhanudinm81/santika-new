<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row justify-content-between mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Permohonan Judul</h1>
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
                            @if ($permohonanJudul->mahasiswa1->prodi == App\Enum\Prodi::D4JTD)
                                <div>
                                    <h5 class="font-weight-bold">Nama Mahasiswa</h5>
                                    <p>{{ $permohonanJudul->mahasiswa1->nama }}</p>
                                </div>
                            @elseif($permohonanJudul->mahasiswa1->prodi == App\Enum\Prodi::D3TT)
                                <div>
                                    <h5 class="font-weight-bold">Nama Mahasiswa 1</h5>
                                    <p>{{ $permohonanJudul->mahasiswa1->nama }}</p>
                                </div>
                                <div>
                                    <h5 class="font-weight-bold">Nama Mahasiswa 2</h5>
                                    <p>{{ $permohonanJudul->mahasiswa2->nama }}</p>
                                </div>
                            @endif
                            <div>
                                <h5 class="font-weight-bold">Judul Proposal</h5>
                                <p>{{ $permohonanJudul->judul }}</p>
                            </div>
                            <div>
                                <h5 class="font-weight-bold">Jenis Judul</h5>
                                <p>{{ $permohonanJudul->jenis_judul }}</p>
                            </div>
                            <div>
                                <h5 class="font-weight-bold">Bidang</h5>
                                <p>{{ $permohonanJudul->bidang }}</p>
                            </div>
                            <div>
                                <h5 class="font-weight-bold">Topik/Tema Proposal</h5>
                                <p>{{ $permohonanJudul->topik }}</p>
                            </div>
                            <div>
                                <h5 class="font-weight-bold">Tujuan</h5>
                                <p>{{ $permohonanJudul->tujuan }}</p>
                            </div>
                            <div>
                                <h5 class="font-weight-bold">Latar Belakang</h5>
                                <p>{{ $permohonanJudul->latar_belakang }}</p>
                            </div>
                            <div>
                                <h5 class="font-weight-bold">Blok Diagram</h5>
                                <img class="img-fluid" style="width: 300px"
                                    src="{{ asset("/storage/" . $permohonanJudul->blok_diagram_sistem) }}"
                                    alt="blok-diagram">
                            </div>
                            @if ($permohonanJudul->status == App\Enum\StatusPengajuanJudul::MENUNGGU_KONFIRMASI->value)
                                <div>
                                    <div class="konfirmasi-aksi">
                                        <label>Konfirmasi</label>
                                        <div class="button">
                                            <form id="form-konfirmasi-permohonan-judul" method="POST"
                                                action="{{ route("dosen.permohonan-judul.konfirmasi") }}">
                                                @csrf
                                                <input type="hidden" name="id_pengajuan" value="{{ $permohonanJudul->id }}">
                                                @if ($permohonanJudul->mahasiswa1->prodi == App\Enum\Prodi::D3TT)
                                                    <input type="hidden" name="prodi" value="d3">
                                                @elseif ($permohonanJudul->mahasiswa1->prodi == App\Enum\Prodi::D4JTD)
                                                    <input type="hidden" name="prodi" value="d4">
                                                @endif
                                                <button type="button" name="aksi" value="terima"
                                                    class="btn btn-success terima-btn btn-block">Terima</button>
                                                <button type="button" name="aksi" value="tolak"
                                                    class="btn btn-danger tolak-btn btn-block">Tolak</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ url("/custom/js/back-to-previous-page.js") }}"></script>
<script src="{{ url("/custom/js/pengajuan-judul.js") }}"></script>