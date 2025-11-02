@extends('mahasiswa.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Logbook Bimbingan Dosen {{ $roleDospem }}</h1>
                </div>
            </div>
        </div>
    </div>
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
                                @if ($roleDospem == 1)
                                    @if (!is_null($logbooksDospem1))
                                            <a href="{{ route('mahasiswa.logbook.tambah-baru', $roleDospem) }}"
                                                class="btn btn-primary">Tambah Logbook</a>
                                    @endif
                                @elseif($roleDospem == 2)
                                    @if (!is_null($logbooksDospem2))
                                        <a href="{{ route('mahasiswa.logbook.tambah-baru', $roleDospem) }}"
                                            class="btn btn-primary">Tambah Logbook</a>
                                    @endif
                                @endif
                                
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
                                        @if (is_null($logbooksDospem1))
                                            <tr>
                                                <td colspan="7" style="text-align: center">Anda Belum Mempunyai Dosen Pembimbing 1!</td>
                                            </tr>
                                        @else
                                            @foreach ($logbooksDospem1 as $logbook)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $dospem1Info->nama }}</td>
                                                    <td>{{ $logbook->jenisKegiatanLogbook->nama_kegiatan }}</td>
                                                    <td>{{ $logbook->nama_kegiatan ?? "-" }}</td>
                                                    <td>{{ $logbook->tanggal ?? "-" }}</td>
                                                    <td>
                                                        @if($logbook->status_logbook_id == 1)
                                                            <span class="badge badge-warning">{{ $logbook->statusLogbook->status }}</span>
                                                        @elseif ($logbook->status_logbook_id == 2)
                                                            <span class="badge badge-danger">{{ $logbook->statusLogbook->status }}</span>
                                                        @elseif($logbook->status_logbook_id == 3)
                                                            <span class="badge badge-success">{{ $logbook->statusLogbook->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('mahasiswa.logbook.detail', $logbook->id) }}"
                                                            class="btn btn-sm btn-primary">Lihat Detail</a>
                                                        <a onclick="event.preventDefault(); if (confirm('Apakah anda yakin ingin menghapus logbook ini?')) { document.getElementById('delete-logbook-{{ $logbook->id }}').submit(); }"
                                                            href="" class="btn btn-sm btn-danger">Hapus</a>
                                                    </td>
                                                    <form id="delete-logbook-{{ $logbook->id }}"
                                                        action="{{ route('mahasiswa.logbook.delete', $logbook->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @elseif($roleDospem == 2)
                                        @if (is_null($logbooksDospem2))
                                            <tr>
                                                <td colspan="7" style="text-align: center">Anda Belum Mempunyai Dosen Pembimbing 2!</td>
                                            </tr>
                                        @else
                                            @foreach ($logbooksDospem2 as $logbook)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $dospem2Info->nama }}</td>
                                                    <td>{{ $logbook->jenisKegiatanLogbook->nama_kegiatan }}</td>
                                                    <td>{{ $logbook->nama_kegiatan }}</td>
                                                    <td>{{ $logbook->tanggal_kegiatan }}</td>
                                                    <td>
                                                        @if($logbook->status_logbook_id == 1)
                                                            <span class="badge badge-warning">{{ $logbook->statusLogbook->status }}</span>
                                                        @elseif ($logbook->status_logbook_id == 2)
                                                            <span class="badge badge-danger">{{ $logbook->statusLogbook->status }}</span>
                                                        @elseif($logbook->status_logbook_id == 3)
                                                            <span class="badge badge-success">{{ $logbook->statusLogbook->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('mahasiswa.logbook.detail', $logbook->id) }}"
                                                            class="btn btn-sm btn-primary">Lihat Detail</a>
                                                        <a onclick="event.preventDefault(); if (confirm('Apakah anda yakin ingin menghapus logbook ini?')) { document.getElementById('delete-logbook-{{ $logbook->id }}').submit(); }"
                                                            href="" class="btn btn-sm btn-danger">Hapus</a>
                                                    </td>
                                                    <form id="delete-logbook-{{ $logbook->id }}"
                                                        action="{{ route('mahasiswa.logbook.delete', $logbook->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </tr>
                                            @endforeach
                                        @endif
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