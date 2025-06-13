<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Panitia Tugas Akhir</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-15">
            <div class="card card-default">
                <div class="card-body">
                    <h4>Panitia TA D3 Teknik Telekomunikasi</h4>
                    <div class="list-group">
                        @foreach ($semuaJabatan as $jabatan)
                            <div class="list-group-item">
                                <label class="form-label">{{ $jabatan->jabatan }}</label>
                                <p class="mb-0">{{ $panitiaD3[$jabatan->jabatan] ?? '-' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    @can("addOrEditPanitiaD3", App\Models\Panitia::class)
                        @if ($panitiaD3Kosong)
                            <button type="button" class="btn btn-danger manage-panitia-btn" id="tambah-panitia-d3" data-url="{{ route("admin-prodi.panitia-tugas-akhir.halaman-tambah", ["prodi" => $prodiD3Id]) }}">Tambah</button>
                        @else
                            <button type="button" class="btn btn-success manage-panitia-btn" id="edit-panitia-d3"  data-url="{{ route("admin-prodi.panitia-tugas-akhir.edit", ["prodi" => $prodiD3Id]) }}">Edit</button>
                        @endif
                    @endcan
                </div>
            </div>
            <div class="card card-default">
                <div class="card-body">
                    <h4>Panitia TA D4 Jaringan Telekomunikasi Digital</h4>
                    <div class="list-group">
                        @foreach ($semuaJabatan as $jabatan)
                            <div class="list-group-item">
                                <label class="form-label">{{ $jabatan->jabatan }}</label>
                                <p class="mb-0">{{ $panitiaD4[$jabatan->jabatan] ?? '-' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    @can("addOrEditPanitiaD4", App\Models\Panitia::class)
                        @if ($panitiaD4Kosong)
                            <button type="button" class="btn btn-danger manage-panitia-btn" id="tambah-panitia-d4" data-url="{{ route("admin-prodi.panitia-tugas-akhir.halaman-tambah", ["prodi" => $prodiD4Id]) }}">Tambah</button>
                        @else
                            <button type="button" class="btn btn-success manage-panitia-btn" id="edit-panitia-d4" data-url="{{ route("admin-prodi.panitia-tugas-akhir.edit", ["prodi" => $prodiD4Id]) }}">Edit</button>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script src={{ url("/custom/js/kelola-panitia-ta/panitia-tugas-akhir.js") }}></script>