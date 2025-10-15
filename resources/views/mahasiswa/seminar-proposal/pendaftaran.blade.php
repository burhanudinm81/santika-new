@extends('mahasiswa.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pendaftaran Seminar Proposal</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
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

                @if ($isPendingProposal)
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading"><strong>Maaf, anda belum bisa mendaftar Seminar Proposal</strong></h4>
                        <p>Anda memiliki proposal yang masih belum dikonfirmasi dosen YBS</p>
                    </div>
                @elseif($isPendingPendaftaran != 0)
                    <div class="alert
                                            @if ($isPendingPendaftaran == 1) alert-success
                                            @elseif($isPendingPendaftaran == 3)
                                            alert-warning @endif
                                        " role="alert">
                        <h4 class="alert-heading">
                            <strong>
                                @if ($isPendingPendaftaran == 1)
                                    Pendaftaran Sempro Dikonfirmasi
                                @elseif($isPendingPendaftaran == 3)
                                    Pendaftaran Sempro belum dicek panitia
                                @endif
                            </strong>
                        </h4>
                        <p>
                            @if ($isPendingPendaftaran == 1)
                                Pendaftaran seminar proposal Anda dikonfirmasi panitia, silahkan mengecek informasi jadwal secara
                                berkala
                            @elseif($isPendingPendaftaran == 3)
                                Pendaftaran seminar proposal anda belum dicek panitia
                            @endif
                        </p>
                    </div>
                @elseif ($isPendaftaranClose)
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading"><strong>Maaf, anda belum bisa mendaftar Seminar Proposal</strong></h4>
                        <p>Pendaftaran Seminar Proposal Belum Dibuka</p>
                    </div>
                @else
                    <div class="card card-primary card-outline mb-4">
                        <!--begin::Form-->
                        <form action="{{ route('mahasiswa.seminar-proposal.pendaftaran-store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            {{-- Hidden Input --}}
                            <input type="hidden" name="proposal_id" value="{{ $acceptedProposalMahasiswa1->proposal->id }}" />
                            <input type="hidden" name="status_pendaftaran_seminar_proposal_id" value="3" />
                            {{-- End Hidden Input --}}

                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="exampleDataList" class="form-label">Dosen Pembimbing 1</label>
                                    <input class="form-control" id="exampleDataList" name="dosen_pembimbing_1"
                                        value="{{ $acceptedProposalMahasiswa1->dosen->nama }}" readonly>
                                </div>
                                @if ($acceptedProposalMahasiswa2 != null)
                                    <div class="mb-3">
                                        <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa 1</label>
                                        <input type="text" class="form-control" id="NamaMahasiswa" name="mahasiswa_1"
                                            aria-describedby="NamaMahasiswa"
                                            value="{{ $acceptedProposalMahasiswa1->mahasiswa->nama }}" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa 2</label>
                                        <input type="text" class="form-control" id="NamaMahasiswa" name="mahasiswa_2"
                                            aria-describedby="NamaMahasiswa"
                                            value="{{ $acceptedProposalMahasiswa2->mahasiswa->nama }}" readonly />
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa</label>
                                        <input type="text" class="form-control" id="NamaMahasiswa" name="mahasiswa_1"
                                            aria-describedby="NamaMahasiswa"
                                            value="{{ $acceptedProposalMahasiswa1->mahasiswa->nama }}" readonly />
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label for="JudulProposal" class="form-label">Judul Proposal</label>
                                    <input type="text" class="form-control" id="JudulProposal" aria-describedby="JudulProposal"
                                        name="judul_proposal" value="{{ $acceptedProposalMahasiswa1->proposal->judul }}"
                                        readonly />
                                    <input type="hidden" name="id_pengajuan_judul" value="" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleDataList" class="form-label">Bidang Keahlihan</label>
                                    <input type="text" class="form-control" id="exampleDataList" name="bidang"
                                        value="{{ $acceptedProposalMahasiswa1->proposal->bidangMinat->bidang_minat }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">File Proposal .pdf</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                name="file_proposal" required>
                                            <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Lembar Konsultasi .pdf</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                name="lembar_konsultasi" required>
                                            <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                                        </div>
                                    </div>
                                </div>
                                @if ($acceptedProposalMahasiswa1->jenis_judul_id == 2)
                                    <div class="form-group">
                                        <label for="exampleInputFile">Lembar Kerjasama Mitra .pdf</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile"
                                                    name="lembar_kerja_sama_mitra">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="exampleInputFile">Bukti Cek Plagiasi (.jpg, .jpeg, .png)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                name="bukti_cek_plagiasi" required>
                                            <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                            <!--begin::Footer-->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                            <!--end::Footer-->
                        </form>
                        <!--end::Form-->
                    </div>
                @endif


            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="{{ url('/custom/js/animate-custom-file-input.js') }}"></script>
    <script src="{{ url('/custom/js/seminar-proposal/pendaftaran.js') }}"></script>
@endsection