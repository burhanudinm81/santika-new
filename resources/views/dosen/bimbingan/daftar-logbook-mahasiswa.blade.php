@extends('dosen.home')

@section('content')
    @if (session('success'))
        <div>
            <div style="
                                                                                                                                                                                                            position: fixed;
                                                                                                                                                                                                            top: 30px;
                                                                                                                                                                                                            left: 60%;
                                                                                                                                                                                                            transform: translateX(-50%);
                                                                                                                                                                                                            z-index: 1050;
                                                                                                                                                                                                            width: 50%;
                                                                                                                                                                                                            transition: all 0.2s ease-in-out;
                                                                                                                                                                                                        "
                class="bg-white border-bottom-0 border-right-0 border-left-0 py-4 border-success shadow shadow-md mx-auto alert alert-dismissible fade show relative"
                role="alert">
                <strong class="text-success">{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
            </div>
            <div class="d-flex justify-content-between align-items-center my-2">
                <a href="{{ route("dosen.bimbingan.daftar-bimbingan") }}" class="btn btn-info mt-2">
                    Kembali
                </a>
                <button id="btn-terima-semua-logbook" class="btn btn-success mt-2">Terima Semua Logbook</button>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Modal Terima Semua Logbook -->
    <div class="modal fade" id="modal-terima-semua-logbook" tabindex="-1" role="dialog"
        aria-labelledby="modal-terima-semua-logbook-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-terima-semua-logbook-label">Konfirmasi Terima Semua Logbook</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menerima semua logbook yang belum diterima?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="form-terima-semua-logbook" method="POST"
                        action="{{ route("dosen.bimbingan.terima-semua-logbook") }}">
                        @csrf
                        <input type="hidden" name="peran_dosbing" value="{{ $peranDosbing }}">
                        <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->id }}">
                        <button type="submit" class="btn btn-success">Terima Semua</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script src="{{ asset('/custom/js/logbook/logbook.js') }}"></script>
@endpush