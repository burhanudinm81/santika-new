<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Riwayat Pendaftaran Seminar Proposal</h1>
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
                <div class="card">
                    <!-- ... (bagian header tetap sama) ... -->
                    <div class="card-body p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahap</th>
                                    <th>Judul</th>
                                    <th>Jenis Judul</th>
                                    <th>Dosen Pembimbing 1</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesertaTugasAkhir as $key => $peserta)
                                    <tr class="row-clickable"
                                        data-href="{{ route("mahasiswa.seminar-proposal.detail-riwayat", ["id" => $peserta->pendaftaranSeminarProposal->id]) }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $peserta->pendaftaranSeminarProposal->tahap  }}</td>
                                        <td>{{ $peserta->pengajuanJudul->judul }}</td>
                                        <td>{{ $peserta->pengajuanJudul->jenis_judul }}</td>
                                        <td>{{ $peserta->dosenPembimbing1->nama }}</td>
                                        <td class="d-flex align-items-center">
                                            @if ($statusPendaftaran[$key] === "Ditolak")
                                                <span class="badge badge-danger">{{ $statusPendaftaran[$key] }}</span>
                                            @elseif ($statusPendaftaran[$key] === "Diterima")
                                                <span class="badge badge-success">{{ $statusPendaftaran[$key] }}</span>
                                            @elseif ($statusPendaftaran[$key] === "Belum Dicek")
                                                <span class="badge badge-warning">{{  $statusPendaftaran[$key] }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- baris lainnya dengan pola yang sama -->
                            </tbody>
                        </table>
                        <!-- Todo: Tampilkan Riwayat Pendaftaran Seminar Proposal Dalam Bentuk List -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
<script src="{{ url("/custom/js/open-detail-page.js") }}"></script>