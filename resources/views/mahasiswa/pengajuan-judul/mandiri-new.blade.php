@extends('mahasiswa.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pengajuan Judul Mandiri</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    {{-- floating notification --}}
    @if (session('success'))
        <div>
            {{-- modal popup success --}}
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
                <strong class="text-success">Berhasil Dibuat!</strong> Judul berhasil diajukan
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">

                <div class="card card-primary card-outline mb-4">
                    <!--begin::Form-->
                    <form id="form-pengajuan-judul" method="POST" action="{{ route('mahasiswa.pengajuan-judul-store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <!--begin::Body-->
                        <div class="card-body">
                                {{-- Status Pengajuan Judul --}}
                                @if($existedProposalPengajuan)
                                    <div class="mb-3">
                                        <div>
                                            <label class="form-label text-md">Status Pengajuan Judul</label>
                                        </div>
                                        <div style="
                                            @if($existedProposalPengajuan->status_proposal_mahasiswa_id == 3)
                                                background-color: #ffee70;
                                            @elseif($existedProposalPengajuan->status_proposal_mahasiswa_id == 2)
                                                background-color: salmon;
                                            @elseif($existedProposalPengajuan->status_proposal_mahasiswa_id == 1)
                                                background-color: lightgreen;
                                            @endif"
                                            class="alert text-md font-weight-bolder" role="alert">
                                            Pengajuan {{ $existedProposalPengajuan->statusProposalMahasiswa->status }} Dosen YBS
                                        </div>
                                    </div>
                                @endif

                            {{-- Input Mahasiswa --}}
                            @if (auth('mahasiswa')->user()->prodi_id == 1)
                                {{-- Mahasiswa 1 --}}
                                <div class="mb-3">
                                    <label for="nama-mahasiswa-1" class="form-label">Nama Mahasiswa 1</label>
                                    <input type="text" class="form-control" id="nama-mahasiswa-1"
                                        aria-describedby="Nama Mahasiswa 1" value="{{ auth('mahasiswa')->user()->nama }}"
                                        readonly />
                                    {{-- error message laravel --}}
                                    @if ($errors->has('mahasiswa_1_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mahasiswa_1_id') }}</strong>
                                        </span>
                                    @endif

                                    <input type="hidden" name="mahasiswa_1_id" value="{{ auth('mahasiswa')->user()->id }}">
                                </div>
                                <div class="mb-3">
                                    <label for="nim-mahasiswa-1" class="form-label">NIM Mahasiswa 1</label>
                                    <input type="text" class="form-control" id="nim-mahasiswa-1" name=""
                                        aria-describedby="NIM Mahasiswa 1" value="{{ auth('mahasiswa')->user()->nim }}"
                                        readonly />
                                    <input type="hidden" name="prodi_id" value="{{ auth('mahasiswa')->user()->prodi_id }}">
                                    <input type="hidden" name="periode_id"
                                        value="{{ auth('mahasiswa')->user()->periode_id }}">
                                </div>
                                {{-- Mahasiswa 2 --}}
                                <div class="mb-3">
                                    <div>
                                        <label for="nama-mahasiswa-2" class="form-label">Nama Mahasiswa 2</label>
                                    </div>
                                    <div>
                                        <div class="position-relative">
                                            <input type="text" id="custom-select-mahasiswa2" class="form-control"
                                                autocomplete="off" placeholder="Ketik nama mahasiswa 2 ..."
                                                @if($currentProposal) disabled @endif
                                                value="@if ($currentMahasiswa2) {{ $currentMahasiswa2->mahasiswa->nama }}@else{{ '' }} @endif" />
                                            <ul id="dropdown-mahasiswa2"
                                                class="list-group border border-2 shadow shadow-md position-absolute w-100 d-none"
                                                style="z-index: 1000; max-height: 200px; overflow-y: auto;"></ul>
                                        </div>
                                        <input type="hidden" name="mahasiswa_2_id" id="mahasiswa_2_id">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nim-mahasiswa-2" class="form-label">NIM Mahasiswa 2</label>
                                    <input type="text" id="nim-mahasiswa-2" class="form-control" name=""
                                        value="@if ($currentMahasiswa2) {{ $currentMahasiswa2->mahasiswa->nim }} @else{{ '' }} @endif" readonly />
                                </div>
                            @elseif(auth('mahasiswa')->user()->prodi_id == 2)
                                <div class="mb-3">
                                    <label for="nama-mahasiswa-1" class="form-label">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="nama-mahasiswa-1" name="nama_mahasiswa_1"
                                        aria-describedby="Nama Mahasiswa 1" value="{{ auth('mahasiswa')->user()->nama }}"
                                        readonly />
                                </div>

                                <div class="mb-3">
                                    <label for="nim-mahasiswa-1" class="form-label">NIM</label>
                                    <input type="text" class="form-control disabled" id="nim-mahasiswa-1"
                                        name="nim_mahasiswa_1" aria-describedby="NIM Mahasiswa 1"
                                        value="{{ auth('mahasiswa')->user()->NIM }}" readonly />
                                </div>
                            @endif

                            {{-- Input Judul --}}
                            <div class="mb-3">
                                <label for="jenis-judul" class="form-label">Jenis Judul</label>
                                <select class="custom-select" id="jenis-judul" name="jenis_judul_id" @if ($currentProposal) disabled @endif required>
                                    @foreach ($jenisJudul as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ $currentProposal && $currentProposal->jenis_judul_id == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Input Bidang Minat --}}
                            <div class="mb-3">
                                <label for="bidang-keahlian" class="form-label">Bidang</label>
                                <select class="custom-select" id="bidang" name="bidang_minat_id" @if ($currentProposal) disabled @endif required>
                                    @foreach ($bidangMinat as $bidang)
                                        <option value="{{ $bidang->id }}"
                                            {{ $currentProposal && $currentProposal->bidang_minat_id == $bidang->id ? 'selected' : '' }}>
                                            {{ $bidang->bidang_minat }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('bidang_minat_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bidang_minat_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{-- Input Calon Dosen Pembimbing --}}
                            <div class="mb-3">
                                <div>
                                    <label for="calon-dosen-pembimbing" class="form-label">Calon Dosen
                                        Pembimbing</label>
                                </div>
                                <div>
                                    <div class="position-relative">
                                        <input type="text" id="custom-select-calonDosen" class="form-control"
                                            autocomplete="off" placeholder="Cari dosen..."
                                            @if($currentProposal) disabled @endif
                                            value="@if ($existedProposalPengajuan) {{ $existedProposalPengajuan->dosen->nama }}@else{{ '' }} @endif" />
                                        <ul id="dropdown-calonDosen"
                                            class="list-group border border-2 shadow shadow-md position-absolute w-100 d-none"
                                            style="z-index: 1000; max-height: 200px; overflow-y: auto;"></ul>
                                        @if ($errors->has('calon_dosen_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('calon_dosen_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <input type="hidden" name="calon_dosen_id" id="calon_dosen_id">
                                </div>
                            </div>

                            {{-- Input Topik/Tema Proposal  --}}
                            <div class="mb-3">
                                <label for="topik" class="form-label">Topik/Tema Proposal</label>
                                <input type="text" class="form-control" id="topik" name="topik"
                                    @if ($currentProposal) disabled @endif
                                    value="@if ($currentProposal) {{ $currentProposal->topik }}@else{{ '' }} @endif"
                                    aria-describedby="Topik/Tema Proposal" required />
                                @if ($errors->has('topik'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('topik') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{-- Input Judul Proposal --}}
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Proposal</label>
                                <input type="text" class="form-control" id="judul" name="judul"
                                    @if ($currentProposal) disabled @endif
                                    value="@if ($currentProposal) {{ $currentProposal->judul }}@else{{ '' }} @endif"
                                    aria-describedby="JudulProposal" required />
                            </div>

                            {{-- Input Tujuan Proposal --}}
                            <div class="mb-3">
                                <label for="tujuan" class="form-label">Tujuan Proposal</label>
                                <textarea class="form-control" id="tujuan" name="tujuan" rows="3" @if ($currentProposal) disabled @endif  required>
                                    @if ($currentProposal) {{ $currentProposal->tujuan }}@else{{ '' }} @endif
                                </textarea>
                            </div>

                            {{-- Input Latar Belakang --}}
                            <div class="mb-3">
                                <label for="latar-belakang" class="form-label">Latar Belakang</label>
                                <textarea class="form-control" id="latar-belakang" name="latar_belakang" @if ($currentProposal) disabled @endif rows="3" required>
                                     @if ($currentProposal) {{ $currentProposal->latar_belakang }}@else{{ '' }} @endif
                                </textarea>
                            </div>

                            {{-- Input Blok Diagram Sistem --}}
                            <div class="form-group">
                                <label for="blok-diagram">Blok Diagram Sistem</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="blok-diagram"
                                            @if ($currentProposal) disabled @endif
                                            name="blok_diagram" required>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">
                                    Tipe file JPG, JPEG, PNG. Ukuran file maksimal 2 MB
                                </small>
                            </div>
                            <!--end::Body-->

                            <!--begin::Footer-->
                            <div class="container-fluid">
                                <button type="submit" @if($currentProposal) disabled @endif class="btn btn-primary w-100">Ajukan</button>
                            </div>
                            <!--end::Footer-->
                    </form>
                    <!--end::Form-->
                </div>

            </div><!-- /.container-fluid -->
        </div>
    </div>

    {{-- @if ($menungguDikonfirmasi)
    <script>
        $("#modal-popup-error .modal-body").text(
            "Anda Tidak Bisa Mengajukan Judul Karena Anda Memiliki Judul Yang Belum Dikonfirmasi!");
        $("#modal-popup-error").modal();

        $("#modal-popup-error").on("hidden.bs.modal", function() {
            $(".content-wrapper").load("/mahasiswa/pengajuan-judul/riwayat");
        })
    </script>
@endif --}}
@endsection
