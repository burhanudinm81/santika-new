@extends('mahasiswa.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Logbook Bimbingan Dosen {{ $roleDospem }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            @if (session('success'))
                @include('notifications.success-alert', ['message' => session('success')])
            @endif

            <div class="col-md-15">
                <div id="cards-container" class="mt-1">
                    <!-- Card pertama (untuk duplikasi) -->
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div>
                                <a href="{{ route('mahasiswa.logbook.tambah-baru', $roleDospem) }}"
                                    class="btn btn-primary">Tambah
                                    Logbook</a>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- table --}}
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dosen Pembimbing</th>
                                        <th>Jenis Kegiatan</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($roleDospem == 1)
                                        @foreach ($logbooksDospem1 as $logbook)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dospem1Info->nama }}</td>
                                                <td>{{ $logbook->jenisKegiatanLogbook->nama_kegiatan }}</td>
                                                <td>{{ $logbook->nama_kegiatan }}</td>
                                                <td>{{ $logbook->tanggal_kegiatan }}</td>
                                                <td>
                                                    @if ($logbook->status == 0)
                                                        <span class="badge badge-warning">Belum Diverifikasi</span>
                                                    @elseif($logbook->status == 1)
                                                        <span class="badge badge-success">Diverifikasi Berhasil</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('mahasiswa.logbook.detail', $logbook->id) }}"
                                                        class="btn btn-sm btn-primary">Lihat Detail</a>
                                                    <a onclick="event.preventDefault(); if (confirm('Apakah anda yakin ingin menghapus logbook ini?')) { document.getElementById('delete-logbook-{{ $logbook->id }}').submit(); }"
                                                        href="" class="btn btn-sm btn-danger">Hapus</a>
                                                </td>
                                                <form id="delete-logbook-{{ $logbook->id }}"
                                                    action="{{ route('mahasiswa.logbook.delete', $logbook->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </tr>
                                        @endforeach
                                    @elseif($roleDospem == 2)
                                        @foreach ($logbooksDospem2 as $logbook)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dospem2Info->nama }}</td>
                                                <td>{{ $logbook->jenisKegiatanLogbook->nama_kegiatan }}</td>
                                                <td>{{ $logbook->nama_kegiatan }}</td>
                                                <td>{{ $logbook->tanggal_kegiatan }}</td>
                                                <td>
                                                    @if ($logbook->verifikasi == 0)
                                                        <span class="badge badge-warning">Belum Diverifikasi</span>
                                                    @elseif($logbook->verifikasi == 1)
                                                        <span class="badge badge-success">Diverifikasi Berhasil</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('mahasiswa.logbook.detail', $logbook->id) }}"
                                                        class="btn btn-sm btn-primary">Lihat Detail</a>
                                                    <a onclick="event.preventDefault(); if (confirm('Apakah anda yakin ingin menghapus logbook ini?')) { document.getElementById('delete-logbook-{{ $logbook->id }}').submit(); }"
                                                        href="" class="btn btn-sm btn-danger">Hapus</a>
                                                </td>
                                                <form id="delete-logbook-{{ $logbook->id }}"
                                                    action="{{ route('mahasiswa.logbook.delete', $logbook->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
