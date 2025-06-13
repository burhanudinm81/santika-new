<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row justify-content-between mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pendaftaran Seminar Proposal Tahap 1</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="" class="btn btn-primary back-btn">Back</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search" />
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Buka Pendaftaran (Hijau) -->
                        <button class="btn btn-success btn-sm ml-2" onclick="alert('Pendaftaran dibuka!')">Buka
                            Pendaftaran</button>

                        <!-- Tombol Tutup Pendaftaran (Merah) -->
                        <button class="btn btn-danger btn-sm ml-2" onclick="alert('Pendaftaran ditutup!')">Tutup
                            Pendaftaran</button>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body table-responsive p-0" style="height: 320px">
                        @if ($prodi == App\Enum\Prodi::D3TT->value)
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">No</th>
                                        <th class="text-center align-middle">NIM Mhs 1</th>
                                        <th class="text-center align-middle">Nama Mhs 1</th>
                                        <th class="text-center align-middle">NIM Mhs 2</th>
                                        <th class="text-center align-middle">Nama Mhs 2</th>
                                        <th class="text-center align-middle">Judul</th>
                                        <th class="text-center align-middle">Status</th>
                                        <th class="text-center align-middle">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendaftaranSempro as $key => $item)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="text-center align-middle">{{ $item->pesertaTugasAkhir->mahasiswa1->NIM }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $item->pesertaTugasAkhir->mahasiswa1->nama }}
                                            </td>
                                            <td class="text-center align-middle">{{ $item->pesertaTugasAkhir->mahasiswa2->NIM }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $item->pesertaTugasAkhir->mahasiswa2->nama }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $item->pesertaTugasAkhir->pengajuanJudul->judul }}
                                            </td>
                                            <td class="text-center align-middle">
                                                @if ($statusPendaftaran[$key] === "Belum Dicek")
                                                    <span class="badge badge-warning">{{ $statusPendaftaran[$key] }}</span>
                                                @elseif($statusPendaftaran[$key] === "Diterima")
                                                    <span class="badge badge-success">{{ $statusPendaftaran[$key] }}</span>
                                                @elseif($statusPendaftaran[$key] === "Ditolak")
                                                    <span class="badge badge-danger">{{ $statusPendaftaran[$key] }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ "/panitia/seminar-proposal/pendaftaran/" . $item->id }}" button
                                                    type="button" class="btn btn-primary btn-sm">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif ($prodi == App\Enum\Prodi::D4JTD->value)
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">No</th>
                                        <th class="text-center align-middle">NIM</th>
                                        <th class="text-center align-middle">Nama</th>
                                        <th class="text-center align-middle">Judul</th>
                                        <th class="text-center align-middle">Status</th>
                                        <th class="text-center align-middle">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendaftaranSempro as $key => $item)
                                        <tr>
                                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                                            <td class="text-center align-middle">{{ $item->pesertaTugasAkhir->mahasiswa1->NIM }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $item->pesertaTugasAkhir->mahasiswa1->nama }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $item->pesertaTugasAkhir->pengajuanJudul->judul }}
                                            </td>
                                            <td class="text-center align-middle">
                                                @if ($statusPendaftaran[$key] === "Belum Dicek")
                                                    <span class="badge badge-warning">{{ $statusPendaftaran[$key] }}</span>
                                                @elseif($statusPendaftaran[$key] === "Diterima")
                                                    <span class="badge badge-success">{{ $statusPendaftaran[$key] }}</span>
                                                @elseif($statusPendaftaran[$key] === "Ditolak")
                                                    <span class="badge badge-danger">{{ $statusPendaftaran[$key] }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ "/panitia/seminar-proposal/pendaftaran/" . $item->id }}" button
                                                    type="button" class="btn btn-primary btn-sm">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->