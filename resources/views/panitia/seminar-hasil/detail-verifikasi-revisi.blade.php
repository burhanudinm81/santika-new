@extends('panitia.home')

@section('content-panitia')
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
                    <form action="{{ route('panitia.seminar-hasil.update-verifikasi-revisi') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- input hidden --}}
                        {{-- <input type="hidden" name="penguji_1_id" value="{{ $mainProposalInfo->dosenPengujiSempro1->id }}">
                        <input type="hidden" name="penguji_2_id" value="{{ $mainProposalInfo->dosenPengujiSempro2->id }}">
                        <input type="hidden" name="proposal_id" value="{{ $mainProposalInfo->id }}"> --}}

                        <input type="hidden" name="proposal_id" value="{{ $proposalInfo->id }}">

                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputFile">Lembar Revisi Dosen Penguji 1 .pdf</label>
                                @if ($revisi1 != null && $revisi1->file_lembar_revisi_dosen)
                                    <iframe src="{{ $revisi1->getPathLembarRevisiSemhas() }}" frameborder="2" width="88%"
                                        height="700px" scrolling="yes"></iframe>
                                @else
                                    <span class="text-gray-500 italic">Belum ada file</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Lembar Revisi Dosen Penguji 2 .pdf</label>
                                @if ($revisi2 != null && $revisi2->file_lembar_revisi_dosen)
                                    <iframe src="{{ $revisi2->getPathLembarRevisiSemhas() }}" frameborder="2" width="88%"
                                        height="700px" scrolling="yes"></iframe>
                                @else
                                    <span class="text-gray-500 italic">Belum ada file</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Proposal Telah di Revisi .pdf</label>
                                @if ($revisi1 != null && $revisi1->file_proposal_revisi)
                                    <iframe src="{{ $revisi1->getPathRevisiProposalSemhas() }}" frameborder="2" width="88%"
                                        height="700px" scrolling="yes"></iframe>
                                @else
                                    <span class="text-gray-500 italic">Belum ada file</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status Revisi</label>
                                <div class="input-group">
                                    {{-- input dropdown select --}}
                                    <select class="custom-select" id="status_revisi" name="status_revisi"
                                        aria-label="Example select with button addon">
                                        <option value="pending" @if ($revisi1->status == 'pending') selected @endif>Pending
                                        </option>
                                        <option value="diterima" @if ($revisi1->status == 'diterima') selected @endif>Diterima
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        <!--end::Footer-->
                    </form>
                    <!--end::Form-->
                </div>

            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
