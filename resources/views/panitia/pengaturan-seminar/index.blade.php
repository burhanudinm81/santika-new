@extends('panitia.home')

@section('content-panitia')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Pengaturan Seminar</h1>
                </div>
            </div>
        </div>
    </div>

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

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="text-left w-100">Periode Aktif</span>
                            <div class="d-flex justify-content-end align-items-center w-100">
                                <button id="btn-ubah-periode-aktif" class="btn btn-sm btn-primary ml-auto">Ubah</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <strong>{{ $periodeAktif->tahun ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="text-left w-100">Tahap Seminar Proposal Aktif</span>
                            <div class="d-flex justify-content-end align-items-center w-100">
                                <button id="btn-ubah-tahap-sempro" class="btn btn-sm btn-primary">Ubah</button>
                                @if (!is_null($tahapAktifSempro))
                                    <button id="btn-nonaktifkan-tahap-sempro"
                                        class="btn btn-sm btn-danger ml-2">Nonaktifkan</button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <strong>{{ $tahapAktifSempro->tahap ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="text-left w-100">Tahap Sidang Tugas Akhir Aktif</span>
                            <div class="d-flex justify-content-end align-items-center w-100">
                                <button id="btn-ubah-tahap-sidang-ta" class="btn btn-sm btn-primary">Ubah</button>
                                @if (!is_null($tahapAktifSidangTA))
                                    <button id="btn-nonaktifkan-tahap-sidang-ta"
                                        class="btn btn-sm btn-danger ml-2">Nonaktifkan</button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <strong>{{ $tahapAktifSidangTA->tahap ?? '-' }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="text-left w-100">Daftar Periode</span>
                            <div class="d-flex justify-content-end align-items-center w-100">
                                <button id="btn-tambah-periode" class="btn btn-sm btn-success ml-auto">Tambah</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-left w-100">Jumlah Periode: <strong>{{ $daftarPeriode->count() ?? '-' }}</strong>
                            </p>
                            <ul class="list-group">
                                @forelse($daftarPeriode as $periode)
                                    <li class="list-group-item bg-primary mb-1">
                                        <span>Periode {{ $periode->tahun }}</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">Belum ada periode</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="text-left w-100">Daftar Tahap</span>
                            <div class="d-flex justify-content-end align-items-center w-100">
                                <a href="#" id="btn-tambah-tahap" class="btn btn-sm btn-success ml-auto">Tambah</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-left w-100">Jumlah Tahap: <strong>{{ $daftarTahap->count() ?? '-' }}</strong></p>
                            <ul class="list-group">
                                @forelse($daftarTahap as $tahap)
                                    <li
                                        class="list-group-item bg-primary mb-1 d-flex justify-content-between align-items-center">
                                        <span>Tahap {{ $tahap->tahap }}</span>
                                        <button href="#" class="text-light btn-hapus-tahap" title="Hapus Tahap"
                                            data-tahap-id="{{ $tahap->id }}">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">Belum ada tahap</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <div id="modal-ubah-periode-aktif" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route("panitia.kelola-periode-tahap.ganti-periode-aktif") }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Periode Aktif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="periode">Pilih Periode</label>
                            <select name="periode_id" id="periode" class="form-control">
                                <option value="">-- Pilih Periode --</option> @foreach ($daftarPeriode as $periode) <option
                                    value="{{ $periode->id }}">Periode {{ $periode->tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Ubah Periode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-ubah-tahap-sempro-aktif" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route("panitia.kelola-periode-tahap.ubah-tahap-sempro-aktif") }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Tahap Seminar Proposal Aktif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tahap">Pilih Tahap</label>
                            <select name="tahap_id" id="tahap" class="form-control">
                                <option value="">-- Pilih Tahap --</option> @foreach ($daftarTahap as $tahap) <option
                                    value="{{ $tahap->id }}">Tahap {{ $tahap->tahap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Ubah Tahap</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-ubah-tahap-sidang-ta-aktif" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route("panitia.kelola-periode-tahap.ubah-tahap-sidang-ta-aktif") }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Tahap Sidang Tugas Akhir Aktif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tahap">Pilih Tahap</label>
                            <select name="tahap_id" id="tahap" class="form-control">
                                <option value="">-- Pilih Tahap --</option> @foreach ($daftarTahap as $tahap) <option
                                    value="{{ $tahap->id }}">Tahap {{ $tahap->tahap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Ubah Tahap</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-tambah-tahap" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('panitia.kelola-periode-tahap.tambah-tahap') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class=" modal-title">Tambah Tahap Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tahap">Nama Tahap</label>
                            <input type="text" class="form-control" id="tahap" name="tahap"
                                placeholder="4 | 4.1 | Khusus | Khusus 1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-success" style="width: 75px">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-tambah-periode" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('panitia.kelola-periode-tahap.tambah-periode') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Periode Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tahap">Nama Periode</label>
                            <input type="text" class="form-control" id="periode" name="periode" placeholder="2026/2027"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-hapus-tahap" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('panitia.kelola-periode-tahap.hapus-tahap') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Tahap</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="input-hapus-tahap" name="tahap_id" required>
                        <p>Apakah anda yakin ingin menghapus tahap ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-tutup-pendaftaran-sempro" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title">Tutup Pendaftaran Seminar Proposal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menutup pendaftaran Seminar Proposal?</p>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tidak</button>
                    <a href="{{ route('panitia.kelola-periode-tahap.nonaktifkan-tahap-sempro') }}" class="btn btn-danger"
                        style="width: 75px">Ya</a>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-tutup-pendaftaran-sidang-ta" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title">Tutup Pendaftaran Sidang Tugas Akhir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menutup pendaftaran Sidang TA?</p>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tidak</button>
                    <a href="{{ route('panitia.kelola-periode-tahap.nonaktifkan-tahap-sidang-ta') }}" class="btn btn-danger"
                        style="width: 75px">Ya</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-panitia')
    <script src="{{ url("/custom/js/seminar/pengaturan-seminar.js") }}"></script>
@endsection