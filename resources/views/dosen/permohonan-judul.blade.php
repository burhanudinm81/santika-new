<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Permohonan Judul</h1>
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
                <!--begin::Body-->
                <nav class="nav">
                    <a class="nav-link" href="#Permohonan-Judul-D3TT">D3 Teknik Telekomunikasi</a>
                    <a class="nav-link" href="#Permohonan-Judul-D4JTD">D4 Jaringan Telekomunikasi Digital</a>
                </nav>
                <div class="card-body" id="Permohonan-Judul-D3TT">
                    <div class="mb-2 d-flex justify-content-between">
                        <label class="form-label"> D3 Teknik Telekomunikasi</label>
                        <div class="input-group input-group-sm float-right" style="width: 150px">
                            <input type="text" id="search-permohonan-judul-d4" name="table_search"
                                class="form-control float-right" placeholder="Search" />

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Nama Mahasiswa 1</th>
                                    <th scope="col" class="text-center">Nama Mahasiswa 2</th>
                                    <th scope="col" class="text-center">Judul Proposal</th>
                                    <th scope="col" class="text-center">Jenis Judul</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuanJudulD3 as $key => $pengajuanJudul)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $pengajuanJudul->mahasiswa1->nama }}</td>
                                        <td>{{ $pengajuanJudul->mahasiswa2->nama }}</td>
                                        <td>{{ $pengajuanJudul->judul }}</td>
                                        <td>{{ $pengajuanJudul->jenis_judul }}</td>
                                        @if ($pengajuanJudul->status == App\Enum\StatusPengajuanJudul::DITERIMA->value)
                                            <td class="d-flex justify-content-center align-items-center">
                                                <p class="btn btn-success mb-0">{{ $pengajuanJudul->status }}</p>
                                            </td>
                                        @elseif ($pengajuanJudul->status == App\Enum\StatusPengajuanJudul::DITOLAK->value)
                                            <td class="d-flex justify-content-center align-items-center">
                                                <p class="btn btn-danger mb-0">{{ $pengajuanJudul->status }}</p>
                                            </td>
                                        @elseif ($pengajuanJudul->status == App\Enum\StatusPengajuanJudul::MENUNGGU_KONFIRMASI->value)
                                            <td class="d-flex justify-content-center align-items-center">
                                                <p class="btn btn-warning mb-0">{{ $pengajuanJudul->status }}</p>
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ "/dosen/permohonan-judul/$pengajuanJudul->id/detail" }}"
                                                class="buka-detail-button btn btn-primary">Buka</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p id="kuota-dosen-d3"><b>Sisa Kuota: </b> {{ $kuotaDosen->kuota_pembimbing_1_D3 }}</p>
                </div>

                <div class="card-body" id="Permohonan-Judul-D4JTD">
                    <div class="mb-2 d-flex justify-content-between">
                        <label class="form-label"> D4 Jaringan Telekomunikasi Digital</label>
                        <div class="input-group input-group-sm float-right" style="width: 150px">
                            <input type="text" id="search-permohonan-judul-d4" name="table_search"
                                class="form-control float-right" placeholder="Search" />

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Nama Mahasiswa</th>
                                    <th scope="col" class="text-center">Judul Proposal</th>
                                    <th scope="col" class="text-center">Jenis Judul</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengajuanJudulD4 as $key => $pengajuanJudul)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $pengajuanJudul->mahasiswa1->nama }}</td>
                                        <td>{{ $pengajuanJudul->judul }}</td>
                                        <td>{{ $pengajuanJudul->jenis_judul }}</td>
                                        @if ($pengajuanJudul->status == App\Enum\StatusPengajuanJudul::DITERIMA->value)
                                            <td class="d-flex justify-content-center align-items-center">
                                                <p class="btn btn-success mb-0">{{ $pengajuanJudul->status }}</p>
                                            </td>
                                        @elseif ($pengajuanJudul->status == App\Enum\StatusPengajuanJudul::DITOLAK->value)
                                            <td class="d-flex justify-content-center align-items-center">
                                                <p class="btn btn-danger mb-0">{{ $pengajuanJudul->status }}</p>
                                            </td>
                                        @elseif ($pengajuanJudul->status == App\Enum\StatusPengajuanJudul::MENUNGGU_KONFIRMASI->value)
                                            <td class="d-flex justify-content-center align-items-center">
                                                <p class="btn btn-warning mb-0">{{ $pengajuanJudul->status }}</p>
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ "/dosen/permohonan-judul/$pengajuanJudul->id/detail" }}"
                                                class="buka-detail-button btn btn-primary">Buka</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p id="kuota-dosen-d4"><b>Sisa Kuota: </b> {{ $kuotaDosen->kuota_pembimbing_1_D4 }}</p>
                </div>
                <!--end::Body-->

                <!--end::Form-->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="{{ url("/custom/js/pengajuan-judul.js") }}"></script>