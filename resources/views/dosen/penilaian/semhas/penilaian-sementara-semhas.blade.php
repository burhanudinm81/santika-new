@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Penilaian Sementara Ujian Tugas Akhir</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            @if (session()->has('success'))
                @include('notifications.success-alert', ['message' => session('success')])
            @endif

            <div class="col-md-15">
                <div class="card card-primary card-outline mb-2">
                    <!--begin::Form-->
                    <form action="{{ route('dosen.penilaian-semhas.update-penilaian-sementara') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- hidden input  --}}
                        <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
                        <input type="hidden" name="dosen_id" value="{{ auth('dosen')->user()->id }}">

                        <!--begin::Body-->
                        <div class="card-body">
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
                                        value="{{ $listMahasiswa[1]->mahasiswa->nama ?? '-' }}"
                                        aria-describedby="NamaMahasiswa2" aria-label="readonly input example" readonly>
                                </div>
                            @elseif($proposal->prodi_id == 2)
                                <div class="mb-3">
                                    <label for="NamaMahasiswa1" class="form-label"
                                        value="{{ $listMahasiswa[0]->mahasiswa->nama }}">Nama Mahasiswa </label>
                                    <input type="text" class="form-control" id="NamaMahasiswa1" value="Nama Mahasiswa 1"
                                        aria-describedby="NamaMahasiswa1" aria-label="readonly input example" readonly>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="status_penilaian">Status Kelulusan Sementara</label>
                                <select class="form-control" id="status_penilaian_sementara"
                                    name="status_penilaian_sementara" required>
                                    <option value="" disabled selected>-- Pilih Status Penilaian --</option>
                                    @foreach ($listStatusPenilaian as $status)
                                        <option value="{{ $status->id }}">{{ $status->status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <strong></i>Catatan Revisi Akhir</strong>
                            <textarea class="form-control" id="catatan_revisi_akhir" name="catatan_revisi_akhir" rows="6" required>
                                @if ($prevRevisi != null)
{{ $prevRevisi->catatan_revisi }}
@else
{{ $proposal->catatan_revisi }}
@endif
                            </textarea>

                            <div class="form-group">
                                <label>Lihat Lembar Revisi:</label>
                                <div>
                                    @if ($prevRevisi != null && $prevRevisi->file_lembar_revisi_dosen)
                                        <iframe src="{{ $prevRevisi->getPathLembarRevisiSemhasForDosen() }}"
                                            frameborder="2" width="88%" height="700px" scrolling="yes"></iframe>
                                    @else
                                        <span class="text-gray-500 italic">Belum ada file</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Lihat Proposal Hasil Revisi:</label>
                                <div>
                                    @if ($prevRevisi != null && $prevRevisi->file_proposal_revisi)
                                        <iframe src="{{ $prevRevisi->getPathLembarRevisiSemhasForDosen() }}"
                                            frameborder="2" width="88%" height="700px" scrolling="yes"></iframe>
                                    @else
                                        <span class="text-gray-500 italic">Belum ada file</span>
                                    @endif
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <label for="status_revisi">Status Konfirmasi Revisi</label>
                                <select class="form-control" id="status_revisi" name="status_revisi" required>
                                    <option value="" disabled selected>Pilih Status Konfirmasi Revisi</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div> --}}

                            {{-- Button untuk menyimpan data --}}
                            <div class="form-group w-100">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                        <!--end::Body-->
                    </form>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
