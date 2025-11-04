@extends('mahasiswa.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat Pendaftaran Sidang Tugas Akhir</h1>
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
                                        <th>Dosen Pembimbing 2</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $pendaftaranSemhas)
                                        <tr class="row-clickable">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $pendaftaranSemhas->proposal->tahap->tahap ?? "-" }}</td>
                                            <td>{{ $pendaftaranSemhas->proposal->judul ?? "-" }}</td>
                                            <td>{{ $pendaftaranSemhas->proposal->jenisJudul->jenis ?? "-" }}</td>
                                            <td>{{ $pendaftaranSemhas->proposal->dosenPembimbing1->nama ?? "-" }}</td>
                                            <td>{{ $pendaftaranSemhas->proposal->dosenPembimbing2->nama ?? "-" }}</td>
                                            <td class="d-flex align-items-center">
                                                @if ($pendaftaranSemhas->status_daftar_semhas_id == 2)
                                                    <span
                                                        class="badge badge-danger">Ditolak</span>
                                                @elseif ($pendaftaranSemhas->status_daftar_semhas_id == 1)
                                                    <span
                                                        class="badge badge-success">Diterima</span>
                                                @elseif ($pendaftaranSemhas->status_daftar_semhas_id == 3)
                                                    <span
                                                        class="badge badge-warning">Belum Dicek</span>
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
    <script src="{{ url('/custom/js/open-detail-page.js') }}"></script>
@endsection
