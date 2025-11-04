@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">Penilaian Akhir Ujian Tugas Akhir</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row">
                <div class="col">
                    <h5 class="font-weight-bold"> {{ $roleDosen }} - {{ $currentDosenInfo->nama }}</h5>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            @if (session()->has('success'))
                @include('notifications.success-alert', ['message' => session('success')])
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline mb-2">
                        <form action="{{ route('dosen.penilaian-semhas.update-penilaian-akhir') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="status_kelulusan">Status Kelulusan:</label>
                                        <input type="text" class="form-control bg-info"
                                            value="{{ $mainProposal->statusSemhasTotal->status ?? '-' }}" readonly>
                                    </div>

                                    {{-- input hidden --}}
                                    <input type="hidden" name="proposal_id" value="{{ $mainProposal->id }}">
                                    <input type="hidden" name="prodi_id" value="{{ $mainProposal->prodi_id }}">
                                    <input type="hidden" id="role_dosen" name="role_dosen" value="{{ $roleDosen }}">

                                    <div class="row">
                                        @if ($roleDosen == 'Dosen Penguji Sidang TA 1' || $roleDosen == 'Dosen Penguji Sidang TA 2')
                                            @include('dosen.penilaian.semhas.byPenguji.penilaian-byPenguji', [
                                                'mainProposal' => $mainProposal,
                                                'nilaiAkhirMahasiswa1' => $nilaiAkhirMahasiswa1,
                                                'nilaiAkhirMahasiswa2' => $nilaiAkhirMahasiswa2 ?? null,
                                                'roleDosen' => $roleDosen,
                                            ])
                                        @elseif ($roleDosen == 'Dosen Pembimbing 1' || $roleDosen == 'Dosen Pembimbing 2')
                                            @include('dosen.penilaian.semhas.byDospem.penilaian-byDospem', [
                                                'mainProposal' => $mainProposal,
                                                'nilaiAkhirMahasiswa1' => $nilaiAkhirMahasiswa1 ?? null,
                                                'nilaiAkhirMahasiswa2' => $nilaiAkhirMahasiswa2 ?? null,
                                                'roleDosen' => $roleDosen,
                                            ])
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <a href="{{ route("dosen.seminar-hasil.jadwal", ["tahapId" => $mainProposal->tahap_id, "periodeId" => $mainProposal->periode_id]) }}"
                    class="btn btn-info mt-2">
                    Kembali
                </a>
            </div>
        </div>
    </div>
    <script src="{{ asset('/custom-assets/js/penilaian-semhas-penguji.js') }}"></script>
    <script src="{{ asset('/custom-assets/js/penilaian-semhas.js') }}"></script>
@endsection
