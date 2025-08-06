@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Logbook Mahasiswa</h1>
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
                    <div class="container-fluid my-3 text-center">
                        <table class="table table-bordered table-hover text-nowrap w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Jenis Kegiatan</th>
                                    <th scope="col" class="text-center">Nama Kegiatan</th>
                                    <th scope="col" class="text-center">Tanggal Kegiatan</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logbooksInfo as $logbook)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $logbook->jenisKegiatanLogbook->nama_kegiatan }}</td>
                                        <td>{{ $logbook->nama_kegiatan }}</td>
                                        <td>{{ $logbook->tanggal_kegiatan }}</td>
                                        <td>
                                            @if ($logbook->status_logbook_id == 1)
                                                <span class="badge badge-warning">{{ $logbook->statusLogbook->status }}</span>
                                            @elseif ($logbook->status_logbook_id == 2)
                                                <span class="badge badge-danger">{{ $logbook->statusLogbook->status }}</span>
                                            @elseif ($logbook->status_logbook_id == 3)
                                                <span class="badge badge-success">{{ $logbook->statusLogbook->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('dosen.bimbingan.detail-logbook-mahasiswa', ['mahasiswa' => $logbook->mahasiswa->id, 'logbook' => $logbook->id]) }}"
                                                class="aksi-button btn btn-primary">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($logbooksInfo->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">belum ada data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
