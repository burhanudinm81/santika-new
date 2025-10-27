@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Permohonan Judul</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                <div class="card card-primary card-outline mb-2">
                    <!--begin::Body-->
                    <nav class="nav">
                        <a class="nav-link" href="#Permohonan-Judul-D3TT">D3 Teknik Telekomunikasi</a>
                        <a class="nav-link" href="#Permohonan-Judul-D4JTD">D4 Jaringan Telekomunikasi Digital</a>
                    </nav>
                    <div class="card-body" id="Permohonan-Judul-D3TT">
                        <div class="mb-2 d-flex justify-content-between">
                            <label class="form-label"> D3 Teknik Telekomunikasi</label>
                            <div class="input-group input-group-sm float-right" style="width: 150px">
                                <input type="text" id="search-permohonan-judul-d4" name="table_search"
                                    class="form-control float-right" placeholder="Search" />

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Nama Mahasiswa 1</th>
                                        <th scope="col" class="text-center">Nama Mahasiswa 2</th>
                                        <th scope="col" class="text-center">Judul Proposal</th>
                                        <th scope="col" class="text-center">Jenis Judul</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($groupedPermohonanD3) > 0)
                                        @foreach ($groupedPermohonanD3 as $proposalId => $permohonan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                {{-- <td>{{ $proposalId }}</td> --}}
                                                <td>{{ $permohonan[0]->mahasiswa->nama }}</td>
                                                <td>{{ $permohonan[1]->mahasiswa->nama ?? '-' }}</td>
                                                <td>{{ $permohonan->first()->proposal->judul }}</td>
                                                <td>{{ $permohonan->first()->proposal->jenisJudul->jenis }}</td>
                                                <td>
                                                    <span
                                                        class="badge
                                                        @if ($permohonan->first()->status_proposal_mahasiswa_id == 1) badge-success
                                                        @elseif($permohonan->first()->status_proposal_mahasiswa_id == 2)
                                                        badge-danger
                                                        @elseif($permohonan->first()->status_proposal_mahasiswa_id == 3)
                                                        badge-warning @endif">
                                                        {{ $permohonan->first()->statusProposalMahasiswa->status }}
                                                    </span>

                                                </td>
                                                <td>
                                                    <a href="{{ route('dosen.permohonan-judul-detail', $permohonan->first()->proposal_id) }}"
                                                        class="btn btn-primary">Buka</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center bg-info">Belum ada permohonan judul</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <p id="kuota-dosen-d3"><b>Sisa Kuota: </b>{{ $kuotaPembimbing->kuota_pembimbing_1_D3 }}</p>
                        <p>{{ $groupedPermohonanD3->links('pagination::bootstrap-4', ['pageName' => 'd3Page']) }}</p>
                    </div>

                    <div class="card-body" id="Permohonan-Judul-D4JTD">
                        <div class="mb-2 d-flex justify-content-between">
                            <label class="form-label"> D4 Jaringan Telekomunikasi Digital</label>
                            <div class="input-group input-group-sm float-right" style="width: 150px">
                                <input type="text" id="search-permohonan-judul-d4" name="table_search"
                                    class="form-control float-right" placeholder="Search" />

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Nama Mahasiswa</th>
                                        <th scope="col" class="text-center" style="width: 350px">Judul Proposal</th>
                                        <th scope="col" class="text-center">Jenis Judul</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($listPermohonanD4) > 0)
                                        @foreach ($listPermohonanD4 as $permohonan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                {{-- <td>{{ $proposalId }}</td> --}}
                                                <td>{{ $permohonan->mahasiswa->nama }}</td>
                                                <td style="width: 350px">{{ $permohonan->proposal->judul }}</td>
                                                <td class="text-center">{{ $permohonan->proposal->jenisJudul->jenis }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge
                                                        @if ($permohonan->status_proposal_mahasiswa_id == 1) badge-success
                                                        @elseif($permohonan->status_proposal_mahasiswa_id == 2)
                                                        badge-danger
                                                        @elseif($permohonan->status_proposal_mahasiswa_id == 3)
                                                        badge-warning @endif">
                                                        {{ $permohonan->statusProposalMahasiswa->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('dosen.permohonan-judul-detail', $permohonan->proposal_id) }}"
                                                        class="btn btn-primary">Buka</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center bg-info">Belum ada permohonan judul</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <p id="kuota-dosen-d4"><b>Sisa Kuota: </b>{{ $kuotaPembimbing->kuota_pembimbing_1_D4 }}</p>
                        <p>{{ $listPermohonanD4->links('pagination::bootstrap-4', ['pageName' => 'd4Page']) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <script src="{{ url('/custom/js/pengajuan-judul.js') }}"></script>
@endsection
