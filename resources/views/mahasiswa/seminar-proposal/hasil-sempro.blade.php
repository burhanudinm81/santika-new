@extends('mahasiswa.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hasil Seminar Proposal</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                <div class="card card-primary card-outline mb-4">
                    <!--begin::Form-->
                    <form>
                        @if (is_null($mainProposalInfo))
                            <div class="card-body">
                                <p>Anda Belum Pernah Mengikuti Seminar Proposal</p>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="DosenPenguji1" class="form-label">Dosen Penguji 1</label>
                                    <input type="text" class="form-control" id="DosenPenguji1" aria-describedby="DosenPenguji1"
                                        value="{{ $mainProposalInfo->dosenPengujiSempro1->nama ?? '' }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="StatusNilaiPenguji1" class="form-label">Status Nilai Dosen Penguji 1</label>
                                    <input type="text" @if ($mainProposalInfo->statusSemproPenguji1->status == "Ditolak")
                                    class="form-control bg-danger" @elseif (
                                                $mainProposalInfo->statusSemproPenguji1->status == "Diterima tanpa revisi" ||
                                                $mainProposalInfo->statusSemproPenguji1->status == "Diterima dengan revisi"
                                            )
                                        class="form-control bg-success" @else class="form-control" @endif
                                        id="StatusNilaiPenguji1" aria-describedby="StatusNilaiPenguji1"
                                        value="{{ $mainProposalInfo->statusSemproPenguji1->status ?? ''}}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="CatatanPenguji1" class="form-label">Catatan Penguji 1</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        readonly>{{ $revisiDosen1->catatan_revisi ?? '' }}</textarea>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label for="DosenPenguji2" class="form-label">Dosen Penguji 2</label>
                                    <input type="text" class="form-control" id="DosenPenguji2" aria-describedby="DosenPenguji2"
                                        value="{{ $mainProposalInfo->dosenPengujiSempro2->nama ?? '' }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="StatusNilaiPenguji2" class="form-label">Status Nilai Dosen Penguji 2</label>
                                    <input type="text" @if ($mainProposalInfo->statusSemproPenguji2->status == "Ditolak")
                                    class="form-control bg-danger" @elseif (
                                                $mainProposalInfo->statusSemproPenguji2->status == "Diterima tanpa revisi" ||
                                                $mainProposalInfo->statusSemproPenguji2->status == "Diterima dengan revisi"
                                            )
                                        class="form-control bg-success" @else class="form-control" @endif
                                        id="StatusNilaiPenguji2" aria-describedby="StatusNilaiPenguji2"
                                        value="{{ $mainProposalInfo->statusSemproPenguji2->status ?? '' }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="CatatanPenguji2" class="form-label">Catatan Penguji 2</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                        readonly>{{ $revisiDosen2->catatan_revisi ?? '' }}</textarea>
                                </div>
                            </div>
                        @endif
                    </form>
                    <!--end::Form-->
                </div>

            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection