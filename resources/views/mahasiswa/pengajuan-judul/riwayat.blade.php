@extends('mahasiswa.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riwayat Pengajuan Judul</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{-- @if (count($riwayatPengajuanJudul) === 0)
                    <div class="alert alert-danger text-center" role="alert">
                        Anda Belum Pernah Mengajukan Judul Proposal !
                    </div>
                @else --}}
                    <div class="card">
                        <!-- ... (bagian header tetap sama) ... -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Bidang Keahlihan</th>
                                        <th>Dosen Pembimbing 1</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($currentRiwayatPengajuan) > 0)
                                        @foreach ($currentRiwayatPengajuan as $riwayat)
                                            <tr class="row-clickable">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $riwayat->proposal->judul }}</td>
                                                <td>{{ $riwayat->proposal->bidangMinat->bidang_minat }}</td>
                                                <td>{{ $riwayat->dosen->nama }}</td>
                                                <td class="d-flex align-items-center">
                                                    <span style="font-size: 14px"
                                                        class="badge
                                                    @if ($riwayat->status_proposal_mahasiswa_id == 3) badge-warning
                                                    @elseif($riwayat->status_proposal_mahasiswa_id == 2)
                                                        badge-danger
                                                    @elseif($riwayat->status_proposal_mahasiswa_id == 1)
                                                        badge-success @endif
                                                    ">
                                                        {{ $riwayat->statusProposalMahasiswa->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <span class="badge badge-secondary">anda belum melakukan pengajuan</span>
                                            </td>
                                        </tr>
                                    @endif
                                    <!-- baris lainnya dengan pola yang sama -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->

    <script src="{{ url('/custom/js/pengajuan-judul.js') }}"></script>
    <script src="{{ url('/custom/js/open-detail-page.js') }}"></script>
@endsection
