@extends('mahasiswa.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pendaftaran Sidang Laporan Akhir</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($isPendaftaranClose)
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading"><strong>Maaf, anda belum bisa mendaftar Sidang Ujian Akhir</strong></h4>
                    <p>Pendaftaran Sidang Ujian Akhir Belum Dibuka</p>
                </div>
            @elseif ($infoProposal == null)
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading"><strong>Maaf, anda belum bisa mendaftar Sidang Ujian Akhir</strong></h4>
                    <p>Anda masih belum eligible</p>
                </div>
            @elseif($isLogbookAmountNotSatisfied)
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading"><strong>Maaf, anda belum bisa mendaftar Sidang Ujian Akhir</strong></h4>
                    <p>Jumlah Logbook anda masih belum memenuhi Persyaratan</p>
                    <p class="mb-0">Jumlah Logbook Yang Diverifikasi Dosen Pembimbing 1: {{ $countLogbookDospem1 }}/10</p>
                    <p>Jumlah Logbook Yang Diverifikasi Dosen Pembimbing 2: {{ $countLogbookDospem2 }}/10</p>
                </div>
            @else
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    @include('notifications.success-alert', ['message' => session('success')])
                @endif

                <div class="col-md-15">
                    <div class="card card-primary card-outline mb-4">
                        <form action="{{ route('mahasiswa.seminar-hasil.daftar-semhas-store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <input type="hidden" name="proposal_id" value="{{ $infoProposal->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="JudulProposal" class="form-label" style="font-size: 22px">Status Pendaftaran
                                        Seminar</label>
                                    <input type="text"
                                        class="
                                        form-control
                                         @if ($infoPendaftaranSemhas != null && $infoPendaftaranSemhas->status_daftar_semhas_id == 3) bg-warning
                                         @elseif($infoPendaftaranSemhas != null && $infoPendaftaranSemhas->status_daftar_semhas_id == 1) bg-success
                                         @else bg-info @endif
                                        "
                                        id="JudulProposal" aria-describedby="JudulProposal"
                                        value=" @if ($infoPendaftaranSemhas != null) {{ $infoPendaftaranSemhas->statusDaftarSeminar->status }}@else Anda belum mendaftar Sidang Ujian Akhir @endif"
                                        readonly />
                                </div>

                                <div class="mb-3">
                                    <label for="exampleDataList" class="form-label">Dosen Pembimbing 1</label>
                                    <input class="form-control" list="datalistOptions" id="exampleDataList"
                                        placeholder="Pilih Dosen Pembimbing 1" value="{{ $infoDospem1->nama }}" readonly>

                                </div>
                                <div class="mb-3">
                                    <label for="exampleDataList" class="form-label">Dosen Pembimbing 2</label>
                                    <input class="form-control" list="datalistOptions" id="exampleDataList"
                                        placeholder="Pilih Dosen Pembimbing 2"
                                        value="{{ $infoDospem2?->nama ?? 'Menyusul' }}" readonly>

                                </div>

                                {{-- --}}
                                @if ($infoProposal->prodi_id == 1)
                                    <div class="mb-3">
                                        <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa 1</label>
                                        <input value="{{ $infoMahasiswaAll[0]->mahasiswa->nama }}" type="text"
                                            class="form-control" id="NamaMahasiswa" aria-describedby="NamaMahasiswa"
                                            readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa 2</label>
                                        <input value="{{ $infoMahasiswaAll[1]->mahasiswa->nama }}" type="text"
                                            class="form-control" id="NamaMahasiswa" aria-describedby="NamaMahasiswa"
                                            readonly />
                                    </div>
                                @elseif ($infoProposal->prodi_id == 2)
                                    <div class="mb-3">
                                        <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa</label>
                                        <input type="text" class="form-control" id="NamaMahasiswa"
                                            aria-describedby="NamaMahasiswa"
                                            value="{{ $infoMahasiswaAll->first()->mahasiswa->nama }}" readonly />
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="JudulProposal" class="form-label">Judul Proposal</label>
                                    <input type="text" class="form-control" id="JudulProposal"
                                        aria-describedby="JudulProposal" value="{{ $infoProposal->judul }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="exampleDataList" class="form-label">Bidang Keahlihan</label>
                                    <input class="form-control" list="datalistkeahlihanOptions" id="exampleDataList"
                                        placeholder="Pilih Bidang Keahlihan"
                                        value="{{ $infoProposal->bidangMinat->bidang_minat }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Surat Rekomendasi Pembimbing .pdf</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                @if (
                                                    $infoPendaftaranSemhas != null &&
                                                        ($infoPendaftaranSemhas->status_daftar_semhas_id == 3 || $infoPendaftaranSemhas->status_daftar_semhas_id == 1)) disabled @endif name="file_rekom_dospem">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">File Proposal .pdf</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                @if (
                                                    $infoPendaftaranSemhas != null &&
                                                        ($infoPendaftaranSemhas->status_daftar_semhas_id == 3 || $infoPendaftaranSemhas->status_daftar_semhas_id == 1)) disabled @endif
                                                name="file_proposal_semhas">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Draft Jurnal .pdf</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                @if (
                                                    $infoPendaftaranSemhas != null &&
                                                        ($infoPendaftaranSemhas->status_daftar_semhas_id == 3 || $infoPendaftaranSemhas->status_daftar_semhas_id == 1)) disabled @endif
                                                name="file_draft_jurnal">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Surat IA Mitra .pdf (Judul Mitra)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                @if (
                                                    $infoPendaftaranSemhas != null &&
                                                        ($infoPendaftaranSemhas->status_daftar_semhas_id == 3 || $infoPendaftaranSemhas->status_daftar_semhas_id == 1)) disabled @endif name="file_IA_mitra">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Surat Bebas Tanggungan PKL .pdf</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                @if (
                                                    $infoPendaftaranSemhas != null &&
                                                        ($infoPendaftaranSemhas->status_daftar_semhas_id == 3 || $infoPendaftaranSemhas->status_daftar_semhas_id == 1)) disabled @endif
                                                name="file_bebas_tanggungan_pkl">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Surat Keterangan Lulus Akademik (SKLA) .pdf</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                @if (
                                                    $infoPendaftaranSemhas != null &&
                                                        ($infoPendaftaranSemhas->status_daftar_semhas_id == 3 || $infoPendaftaranSemhas->status_daftar_semhas_id == 1)) disabled @endif name="file_skla">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end::Body-->
                            <!--begin::Footer-->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"
                                    @if (
                                        $infoPendaftaranSemhas != null &&
                                            ($infoPendaftaranSemhas->status_daftar_semhas_id == 3 || $infoPendaftaranSemhas->status_daftar_semhas_id == 1)) disabled @endif>Daftar</button>
                            </div>
                            <!--end::Footer-->
                        </form>
                        <!--end::Form-->
                    </div>

                </div>
            @endif

        </div>
        <!-- /.content -->
    </div>
@endsection
