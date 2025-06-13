<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Riwayat Pengajuan Judul</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (count($riwayatPengajuanJudul) === 0)
                    <div class="alert alert-danger text-center" role="alert">
                        Anda Belum Pernah Mengajukan Judul Proposal !
                    </div>
                @else
                    <div class="card">
                        <!-- ... (bagian header tetap sama) ... -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Bidang Keahlihan</th>
                                        <th>Dosen Pembimbing 1</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayatPengajuanJudul as $key => $riwayat)
                                        <tr class="row-clickable" data-href="{{ "/mahasiswa/pengajuan-judul/$riwayat->id/detail" }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $riwayat->judul  }}</td>
                                            <td>{{ $riwayat->bidang }}</td>
                                            <td>{{ $riwayat->dosen->nama }}</td>
                                            <td class="d-flex align-items-center">
                                                @if ($riwayat->status == App\Enum\StatusPengajuanJudul::DITOLAK->value)
                                                    <p class="btn btn-danger">{{ $riwayat->status }}</p>
                                                @elseif ($riwayat->status == App\Enum\StatusPengajuanJudul::DITERIMA->value)
                                                    <p class="btn btn-success">{{ $riwayat->status }}</p>
                                                @elseif ($riwayat->status == App\Enum\StatusPengajuanJudul::MENUNGGU_KONFIRMASI->value)
                                                    <p class="btn btn-warning">{{ $riwayat->status }}</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!-- baris lainnya dengan pola yang sama -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /.content -->

<script src="{{ url("/custom/js/pengajuan-judul.js") }}"></script>
<script src="{{ url("/custom/js/open-detail-page.js") }}"></script>