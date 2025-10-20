@extends('panitia.home')

@section('content-panitia')
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
                    <!--begin::Form-->
                    <form>
                        {{-- input hidden --}}
                        {{-- <input type="hidden" name="penguji_1_id" value="{{ $mainProposalInfo->dosenPengujiSempro1->id }}">
                        <input type="hidden" name="penguji_2_id" value="{{ $mainProposalInfo->dosenPengujiSempro2->id }}">
                        <input type="hidden" name="proposal_id" value="{{ $mainProposalInfo->id }}"> --}}

                        <input type="hidden" name="proposal_id" value="{{ $proposalInfo->id }}">

                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputFile">Lembar Revisi Dosen Penguji 1 .pdf</label>
                                <div>
                                    @if ($revisi1->file_lembar_revisi_dosen)
                                        <iframe src="{{ $revisi1->getPathLembarRevisiSempro() }}" frameborder="2"
                                            width="88%" height="700px" scrolling="yes"></iframe>
                                    @else
                                        <span class="text-gray-500 italic">Belum ada file</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Lembar Revisi Dosen Penguji 2 .pdf</label>
                                <div>
                                    @if ($revisi2->file_lembar_revisi_dosen)
                                        <iframe src="{{ $revisi2->getPathLembarRevisiSempro() }}" frameborder="2"
                                            width="88%" height="700px" scrolling="yes"></iframe>
                                    @else
                                        <span class="text-gray-500 italic">Belum ada file</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Proposal Telah di Revisi .pdf</label>
                                <div>
                                    @if ($revisi1->file_proposal_revisi)
                                        <iframe src="{{ $revisi1->getPathRevisiProposalSempro() }}" frameborder="2"
                                            width="88%" height="700px" scrolling="yes"></iframe>
                                    @else
                                        <span class="text-gray-500 italic">Belum ada file</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status Revisi Penguji 1</label>
                                <input 
                                    type="text" 
                                    id="status-revisi-penguji-1" 
                                    @if ($revisi1->status == "pending")
                                        class="form-control bg-warning"
                                        value="Pending"
                                    @elseif ($revisi1->status == "ditolak")
                                        class="form-control bg-danger"
                                        value="Ditolak"
                                    @elseif ($revisi1->status == "diterima")
                                        class="form-control bg-success"
                                        value="Diterima"
                                    @else
                                        class="form-control"
                                        value="-"
                                    @endif 
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status Revisi Penguji 2</label>
                                <input 
                                    type="text" 
                                    id="status-revisi-penguji-2" 
                                    @if ($revisi2->status == "pending")
                                        class="form-control bg-warning"
                                        value="Pending"
                                    @elseif ($revisi2->status == "ditolak")
                                        class="form-control bg-danger"
                                        value="Ditolak"
                                    @elseif ($revisi2->status == "diterima")
                                        class="form-control bg-success"
                                        value="Diterima"
                                    @else
                                        class="form-control"
                                        value="-"
                                    @endif
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status Revisi Keseluruhan</label>
                                <input 
                                    type="text" 
                                    id="status-revisi-keseluruhan" 
                                    @if (in_array('pending', [$revisi1->status, $revisi2->status]))
                                        class="form-control bg-warning"
                                        value="Pending"
                                    @elseif (in_array('ditolak', [$revisi1->status, $revisi2->status]))
                                        class="form-control bg-danger"
                                        value="Ditolak"
                                    @elseif (in_array('diterima', [$revisi1->status, $revisi2->status]))
                                        class="form-control bg-success"
                                        value="Diterima"
                                    @else
                                        class="form-control"
                                    @endif
                                    readonly>
                            </div>
                        </div>
                        <!--end::Body-->
                        <!--end::Footer-->
                    </form>
                    <!--end::Form-->
                </div>

            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection
