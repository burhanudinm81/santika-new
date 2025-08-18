@extends('mahasiswa.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Revisi Seminar Proposal</h1>
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
                <div class="card card-primary card-outline mb-4">
                    @if (is_null($mainProposalInfo))
                        <div class="card-body">
                            <p>Anda Belum Pernah Mengikuti Seminar Proposal</p>
                        </div>
                    @else
                        <!--begin::Form-->
                        <form action="{{ route('mahasiswa.seminar-proposal.revisi-store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            {{-- input hidden --}}
                            <input type="hidden" name="penguji_1_id" value="{{ $mainProposalInfo->dosenPengujiSempro1->id }}">
                            <input type="hidden" name="penguji_2_id" value="{{ $mainProposalInfo->dosenPengujiSempro2->id }}">
                            <input type="hidden" name="proposal_id" value="{{ $mainProposalInfo->id }}">

                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFile">Lembar Revisi Dosen Penguji 1 .pdf</label>
                                    <div class="input-group">
                                        <div class="custom-file mb-2">
                                            <input type="file" class="custom-file-input" name="lembar_revisi_penguji_1"
                                                id="exampleInputFile" required>
                                            <label class="custom-file-label" for="exampleInputFile">
                                                @if (!is_null($namaLembarRevisi1))
                                                    {{ $namaLembarRevisi1 }}
                                                @else
                                                    Choose file
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @if (!is_null($revisiPenguji1))
                                        <iframe src="{{ $revisiPenguji1->getPathLembarRevisiSemproForMhs() }}" frameborder="2"
                                            width="100%" height="700px" scrolling="yes"></iframe>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Lembar Revisi Dosen Penguji 2 .pdf</label>
                                    <div class="input-group">
                                        <div class="custom-file mb-2">
                                            <input type="file" class="custom-file-input" name="lembar_revisi_penguji_2"
                                                id="exampleInputFile" required>
                                            <label class="custom-file-label" for="exampleInputFile">
                                                @if (!is_null($namaLembarRevisi2))
                                                    {{ $namaLembarRevisi2 }}
                                                @else
                                                    Choose file
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @if (!is_null($revisiPenguji2))
                                        <iframe src="{{ $revisiPenguji2->getPathLembarRevisiSemproForMhs() }}" frameborder="2"
                                            width="100%" height="700px" scrolling="yes"></iframe>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Proposal Telah di Revisi .pdf</label>
                                    <div class="input-group mb-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="proposal_revisi"
                                                id="exampleInputFile" required>
                                            <label class="custom-file-label" for="exampleInputFile">
                                                @if (!is_null($namaProposal))
                                                    {{ $namaProposal }}
                                                @else
                                                    Choose file
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    @if (!is_null($revisiPenguji1))
                                        <iframe src="{{ $revisiPenguji1->getPathRevisiProposalSemproForMhs() }}" frameborder="2"
                                            width="100%" height="700px" scrolling="yes"></iframe>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Status Revisi</label>
                                    <input type="text" @if ($statusRevisi == "Diterima") class="form-control bg-success" @else
                                    class="form-control bg-warning" @endif name="proposal_revisi" id="exampleInputFile"
                                        value="{{ $statusRevisi }}" readonly>
                                </div>
                            </div>
                            <!--end::Body-->
                            <!--begin::Footer-->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                            <!--end::Footer-->
                        </form>
                        <!--end::Form-->
                    @endif
                </div>

            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection