@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penilaian Seminar Proposal</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div>
                    {{-- modal popup error --}}
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
                        <strong class="text-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            @if (session()->has('success'))
                @include('notifications.success-alert', ['message' => session('success')])
            @endif

            <div class="col-md-15 mb-4">
                <div class="card card-primary card-outline mb-2">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">Status Kelulusan Seminar Proposal</h3>
                    </div>
                    <div class="card-body">
                        <!--begin::Form-->
                        <form action="{{ route('dosen.penilaian-sempro.update-penilaian') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- hidden input --}}
                            <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
                            <input type="hidden" name="dosen_id" value="{{ auth('dosen')->user()->id }}">

                            @if ($proposal->prodi_id == 1)
                                    <div class="mb-3">
                                        <label for="NamaMahasiswa1" class="form-label">Nama Mahasiswa 1</label>
                                        <input type="text" class="form-control" id="NamaMahasiswa1"
                                            value="{{ $listMahasiswa[0]->mahasiswa->nama }}" aria-describedby="NamaMahasiswa1"
                                            aria-label="readonly input example" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="NamaMahasiswa2" class="form-label">Nama Mahasiswa 2</label>
                                        <input type="text" class="form-control" id="NamaMahasiswa2"
                                            value="{{ $listMahasiswa[1]->mahasiswa->nama }}" aria-describedby="NamaMahasiswa2"
                                            aria-label="readonly input example" readonly>
                                    </div>
                                @elseif($proposal->prodi_id == 2)
                                    <div class="mb-3">
                                        <label for="NamaMahasiswa1" class="form-label">Nama Mahasiswa </label>
                                        <input type="text" class="form-control" id="NamaMahasiswa1"
                                            value="{{ $listMahasiswa[0]->mahasiswa->nama }}" aria-describedby="NamaMahasiswa1"
                                            aria-label="readonly input example" readonly>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="status_penilaian">Status Kelulusan:</label>
                                    <select class="form-control" id="status_penilaian_sempro" name="status_penilaian" @if (
                                        auth("dosen")->id() == $proposal->penguji_sempro_1_id &&
                                        !is_null($proposal->status_sempro_penguji_1_id)
                                    ) disabled @elseif(
            auth("dosen")->id() == $proposal->penguji_sempro_2_id &&
            !is_null($proposal->status_sempro_penguji_2_id)
        ) disabled @endif required>
                                        <option value="" disabled selected>-- Pilih Status Kelulusan --</option>
                                        @if (auth("dosen")->id() == $proposal->penguji_sempro_1_id)
                                            @foreach ($listStatusPenilaian as $status)
                                                <option @if($status->id == $proposal->status_sempro_penguji_1_id) selected @endif
                                                    value="{{ $status->id }}">
                                                    {{ $status->status }}
                                                </option>
                                            @endforeach
                                        @elseif((auth("dosen")->id() == $proposal->penguji_sempro_2_id))
                                            @foreach ($listStatusPenilaian as $status)
                                                <option @if($status->id == $proposal->status_sempro_penguji_2_id) selected @endif
                                                    value="{{ $status->id }}">
                                                    {{ $status->status }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <strong></i>Catatan Revisi</strong>
                                <textarea class="form-control mb-3" id="catatan_revisi" name="catatan_revisi" rows="6" 
                                @if (
                                    auth("dosen")->id() == $proposal->penguji_sempro_1_id &&
                                    !is_null($proposal->status_sempro_penguji_1_id)
                                ) disabled @elseif(
                                    auth("dosen")->id() == $proposal->penguji_sempro_2_id &&
                                    !is_null($proposal->status_sempro_penguji_2_id)
                                ) disabled 
                                @endif>@if($prevRevisi != null) {{ $prevRevisi->catatan_revisi }} @else {{ $proposal->catatan_revisi }} @endif</textarea>

                                {{-- Button untuk menyimpan data --}}
                                <div class="form-group w-100">
                                    <button type="submit" class="btn btn-primary" @if (
                                        auth("dosen")->id() == $proposal->penguji_sempro_1_id &&
                                        !is_null($proposal->status_sempro_penguji_1_id)
                                    ) disabled @elseif(
            auth("dosen")->id() == $proposal->penguji_sempro_2_id &&
            !is_null($proposal->status_sempro_penguji_2_id)
        ) disabled @endif>Simpan Perubahan</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-15">
                <div class="card card-primary card-outline mb-2">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">Revisi Seminar Proposal</h3>
                    </div>
                    <div class="card-body">
                        <!--begin::Form-->
                        <form action="{{ route('dosen.penilaian-sempro.update-verifikasi-revisi') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- hidden input --}}
                            <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">

                            <div class="form-group">
                                <label>Lihat Lembar Revisi:</label>
                                <div>
                                    @if ($prevRevisi != null && $prevRevisi->file_lembar_revisi_dosen != null)
                                        <iframe src="{{ $prevRevisi->getPathLembarRevisiSemproForDosen() }}" frameborder="2"
                                            width="88%" height="700px" scrolling="yes"></iframe>
                                    @else
                                        <span class="text-gray-500 italic">Belum ada file</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Lihat Proposal Hasil Revisi:</label>
                                <div>
                                    @if ($prevRevisi != null && $prevRevisi->file_proposal_revisi != null)
                                        <iframe src="{{ $prevRevisi->getPathRevisiProposalSemproForDosen() }}" frameborder="2"
                                            width="88%" height="700px" scrolling="yes"></iframe>
                                    @else
                                        <span class="text-gray-500 italic">Belum ada file</span>
                                    @endif
                                </div>
                            </div>

                                <div class="form-group">
                                    <label for="status_revisi">Status Konfirmasi Revisi</label>
                                    <select class="form-control" id="status_revisi" name="status_revisi" required>
                                        <option value="" disabled selected>---Pilih Status Konfirmasi Revisi---</option>
                                        <option value="diterima" @if ($prevRevisi->status == "diterima") selected @endif>Diterima</option>
                                        <option value="ditolak" @if ($prevRevisi->status == "ditolak") selected @endif >Ditolak</option>
                                    </select>
                                </div>

                                {{-- Button untuk menyimpan data --}}
                                <div class="form-group w-100">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <a href="{{ route("dosen.seminar-proposal.jadwal", ["tahapId" => $proposal->tahap_id, "periodeId" => $proposal->periode_id]) }}"
                class="btn btn-info mt-2">
                Kembali
            </a>
        </div>
    </div>
@endsection