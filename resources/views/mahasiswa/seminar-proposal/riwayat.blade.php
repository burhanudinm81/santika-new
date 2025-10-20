@extends('mahasiswa.home')

@section('content')
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
                                    @if (is_null($data) || $data->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada riwayat pendaftaran seminar
                                                proposal.</td>
                                        </tr>
                                    @endif
                                    @foreach ($data as $key => $pendaftaranSempro)
                                        <tr class="row-clickable">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $pendaftaranSempro->proposal->tahap->tahap }}</td>
                                            <td>{{ $pendaftaranSempro->proposal->judul }}</td>
                                            <td>{{ $pendaftaranSempro->proposal->jenisJudul->jenis }}</td>
                                            <td>{{ $pendaftaranSempro->proposal->dosenPembimbing1->nama }}</td>
                                            <td class="d-flex align-items-center">
                                                @if ($pendaftaranSempro->status_daftar_sempro_id == 2)
                                                    <span
                                                        class="badge badge-danger">Ditolak</span>
                                                @elseif ($pendaftaranSempro->status_daftar_sempro_id == 1)
                                                    <span
                                                        class="badge badge-success">Diterima</span>
                                                @elseif ($pendaftaranSempro->status_daftar_sempro_id == 3)
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
