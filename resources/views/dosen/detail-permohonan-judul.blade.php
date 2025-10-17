@extends('dosen.home')

@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Permohonan Judul</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @if (session('success'))
        @include('notifications.success-alert', ['message' => session('success')])
    @endif

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                <div class="card card-primary card-outline mb-2">
                    <!--begin::Body-->
                    <div class="card-body">
                        @if ($permohonanProposalMahasiswa->count() > 1)
                            <div class="mb-2">
                                <label for="NamaMahasiswa1" class="form-label">Nama Mahasiswa 1</label>
                                <input type="text" class="form-control" id="NamaMahasiswa1"
                                    aria-describedby="NamaMahasiswa1"
                                    value="{{ $permohonanProposalMahasiswa[0]->mahasiswa->nama }}"
                                    aria-label="readonly input example" readonly>
                            </div>

                            <div class="mb-2">
                                <label for="NamaMahasiswa2" class="form-label">Nama Mahasiswa 2</label>
                                <input type="text" class="form-control" id="NamaMahasiswa2"
                                    aria-describedby="NamaMahasiswa2"
                                    value="{{ $permohonanProposalMahasiswa[1]->mahasiswa->nama }}"
                                    aria-label="readonly input example" readonly>
                            </div>

                            <div class="mb-2">
                                <label for="NIMMahasiswa1" class="form-label">NIM Mahasiswa 1</label>
                                <input type="text" class="form-control" id="NIMMahasiswa1"
                                    value="{{ $permohonanProposalMahasiswa[0]->mahasiswa->nim }}"
                                    aria-describedby="NIMMahasiswa1" aria-label="readonly input example" readonly>
                            </div>

                            <div class="mb-2">
                                <label for="NIMMahasiswa2" class="form-label">NIM Mahasiswa 2</label>
                                <input type="text" class="form-control" id="NIMMahasiswa2"
                                    value="{{ $permohonanProposalMahasiswa[1]->mahasiswa->nim }}"
                                    aria-describedby="NIMMahasiswa2" aria-label="readonly input example" readonly>
                            </div>
                        @else
                            <div class="mb-2">
                                <label for="NamaMahasiswa1" class="form-label">Nama Mahasiswa 1</label>
                                <input type="text" class="form-control" id="NamaMahasiswa1"
                                    value="{{ $permohonanProposalMahasiswa->first()->mahasiswa->nama }}"
                                    aria-describedby="NamaMahasiswa1" aria-label="readonly input example" readonly>
                            </div>
                            <div class="mb-2">
                                <label for="NIMMahasiswa1" class="form-label">NIM Mahasiswa 1</label>
                                <input type="text" class="form-control" id="NIMMahasiswa1"
                                    value="{{ $permohonanProposalMahasiswa->first()->mahasiswa->nim }}"
                                    aria-describedby="NIMMahasiswa1" aria-label="readonly input example" readonly>
                            </div>
                        @endif


                        <div class="mb-2">
                            <label for="StatusJudul" class="form-label">Status Judul</label>
                            <input type="text"
                                class=
                                "form-control
                                @if ($permohonanProposalMahasiswa->first()->status_proposal_mahasiswa_id == 3) bg-warning
                                @elseif($permohonanProposalMahasiswa->first()->status_proposal_mahasiswa_id == 1)
                                    bg-success
                                @elseif($permohonanProposalMahasiswa->first()->status_proposal_mahasiswa_id == 2)
                                    bg-danger @endif
                                "
                                id="StatusJudul"
                                value="{{ $permohonanProposalMahasiswa->first()->statusProposalMahasiswa->status }}"
                                aria-describedby="StatusJudul" aria-label="readonly input example" readonly>
                        </div>

                        <div class="mb-2">
                            <label for="JudulProposal" class="form-label">Judul Proposal</label>
                            <textarea id="JudulProposal" class="form-control" rows="2" readonly>{{ $permohonanProposalMahasiswa->first()->proposal->judul ?? "-" }}</textarea>
                        </div>

                        <div class="mb-2">
                            <label for="Tujuan" class="form-label">Tujuan</label>
                            <textarea id="Tujuan" class="form-control" rows="4" readonly>{{ $permohonanProposalMahasiswa->first()->proposal->tujuan ?? "-" }}</textarea>
                        </div>

                        <div class="mb-2">
                            <label for="LatarBelakang" class="form-label">Latar Belakang</label>
                            <textarea id="LatarBelakang" class="form-control" rows="8" readonly>{{ $permohonanProposalMahasiswa->first()->proposal->latar_belakang ?? "-" }}</textarea>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Diagram Blok Sistem</label>
                            <div class="diagram-blok">
                                @if ($permohonanProposalMahasiswa->first()->proposal->hasBlokDiagram())
                                    <img style="width: 100px; cursor: pointer;"
                                        src="{{ $permohonanProposalMahasiswa->first()->proposal->getBlokDiagramUrlAttribute() }}"
                                        alt="Diagram Blok Sistem" data-bs-toggle="modal" data-bs-target="#diagramModal"
                                        onclick="openImageModal(this.src, this.alt)">
                                @endif
                            </div>
                        </div>

                        @if ($permohonanProposalMahasiswa->first()->status_proposal_mahasiswa_id == 3)
                            <div class="container-fluid">
                                <label>Konfirmasi</label>
                                <div class="row">
                                    <form action="{{ route('dosen.permohonan-judul-update') }}" method="POST">
                                        @csrf
                                        <input type="hidden"
                                            value="{{ $permohonanProposalMahasiswa->first()->proposal_id }}"
                                            name="proposal_id">
                                        <input type="hidden"
                                            value="{{ $permohonanProposalMahasiswa->first()->mahasiswa_id }}"
                                            name="mahasiswa_id">

                                        <div class="col">
                                            <button class="btn text-bold" type="submit" value="1"
                                                name="confirmation_status_id"
                                                style="background-color: #75eb79; width: 100%">
                                                Terima</button>
                                        </div>
                                        <div class="col">
                                            <button value="2" name="confirmation_status_id" type="submit"
                                                class="btn btn-danger text-white text-bold w-100 mt-2">
                                                Tolak</button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        @endif
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    {{-- Modal Lightbox --}}
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <span class="close-modal">&times;</span>
        <img class="modal-image" id="modalImg">
        <div class="image-caption" id="caption"></div>
    </div>

    <script src="{{ asset('/custom-assets/js/permohonan-judul.js') }}"></script>
    <script src="{{ url('/custom/js/back-to-previous-page.js') }}"></script>
    <script src="{{ url('/custom/js/pengajuan-judul.js') }}"></script>
@endsection
