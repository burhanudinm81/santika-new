@extends('mahasiswa.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Revisi Seminar Hasil</h1>
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
                    <!--begin::Form-->
                    <form action="{{ route('mahasiswa.seminar-hasil.revisi-store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        {{-- input hidden --}}
                        <input type="hidden" name="penguji_1_id"
                            value="{{ $mainProposalInfo->dosenPengujiSidangTA1->id }}">
                        <input type="hidden" name="penguji_2_id"
                            value="{{ $mainProposalInfo->dosenPengujiSidangTA2->id }}">
                        <input type="hidden" name="pembimbing_1_id"
                            value="{{ $mainProposalInfo->dosenPembimbing1->id }}">
                        <input type="hidden" name="pembimbing_2_id"
                            value="{{ $mainProposalInfo->dosenPembimbing2->id }}">
                        <input type="hidden" name="proposal_id" value="{{ $mainProposalInfo->id }}">

                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputFile">Lembar Revisi Dosen Penguji 1 .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="lembar_revisi_penguji_1"
                                            id="exampleInputFile" required>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Lembar Revisi Dosen Penguji 2 .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="lembar_revisi_penguji_2"
                                            id="exampleInputFile" required>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Proposal Telah di Revisi .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="proposal_revisi"
                                            id="exampleInputFile" required>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status Revisi Semhas</label>
                                <input type="text" class="form-control" name="status_revisi"
                                    value="
                                        @if ($revisiPeng1 != null) {{ $revisiPeng1->status }} @endif
                                    "
                                    readonly>
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
                </div>

            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
