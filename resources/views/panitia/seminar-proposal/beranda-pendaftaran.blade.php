@extends('panitia.home')

@section('content-panitia')
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
                class="bg-white border-bottom-0 border-right-0 border-left-0 py-4 border-danger shadow shadow-md mx-auto alert alert-dismissible fade show relative"
                role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between align-items-center mt-0">
                        <div>
                            <h1 class="m-0">Pendaftaran Seminar Proposal</h1>
                        </div>
                        <div>
                            <a href="{{ route("panitia.kelola-periode-tahap.pengaturan-seminar") }}" class="btn btn-light ml-2" title="Pengaturan Seminar">
                                <i class="fas fa-cog fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title font-weight-bold">Pendaftaran Seminar Proposal Aktif</h5>
                        </div>
                        <div class=" card-body">
                            <p class="card-text">Periode: {{ $periodeAktif->tahun ?? "-" }}</p>
                            <p class="card-text">Tahap: {{ $tahapAktif->tahap ?? "-" }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="containerTahap">
                @foreach ($listTahap as $tahap)
                    <div class=" col-lg-3 col-6">
                        <!-- kotak tahap -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>Tahap {{ $tahap->tahap }}</h3>
                                @if ($tahap->jumlahBelumVerifikasi > 0)
                                    <span class="badge badge-warning">{{ $tahap->jumlahBelumVerifikasi }} belum diverifikasi</span>
                                @else
                                    <span class="badge badge-success">Semua sudah diverifikasi</span>
                                @endif
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <a href="{{ route('panitia.seminar-proposal.pendaftaran-detail', $tahap->id) }}"
                                class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('modals')
    <div id="modal-tambah-tahap" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title">Tambah Tahap Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menambah tahap baru?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <a href="{{ route('panitia.kelola-periode-tahap.tambah-tahap') }}" class="btn btn-success"
                        style="width: 75px">Ya</a>
                </div>
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

    <div id="modal-buka-pendaftaran" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('panitia.seminar-proposal.buka-pendaftaran') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class=" modal-title">Buka Pendaftaran Seminar Proposal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="periode">Pilih Periode</label>
                            <select name="periode_id" id="periode" class="form-control">
                                <option value="">-- Pilih Periode --</option> @foreach ($listPeriode as $periode) <option
                                    value="{{ $periode->id }}">Periode {{ $periode->tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahap">Pilih Tahap</label>
                            <select name="tahap_id" id="tahap" class="form-control">
                                <option value="">-- Pilih Tahap --</option>
                                @foreach ($listTahap as $tahap)
                                    <option value="{{ $tahap->id }}">Tahap {{ $tahap->tahap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Buka Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-tutup-pendaftaran" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class=" modal-title">Tutup Pendaftaran Seminar Proposal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menutup pendaftaran sempro</p>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Tidak</button>
                    <a href="{{ route('panitia.seminar-proposal.tutup-pendaftaran') }}" class="btn btn-success"
                        style="width: 75px">Ya</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-panitia')
    <script src="{{ asset('/custom/js/seminar/buka-tutup-pendaftaran.js') }}"></script>
@endsection