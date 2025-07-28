@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Mahasiswa Bimbingan</h1>
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
                    <!--begin::Form-->
                    <form>
                        <!--begin::Body-->
                        <nav class="nav">
                            <a class="nav-link" href="#D3TT">D3 Teknik Telekomunikasi</a>
                            <a class="nav-link" href="#D4JTD">D4 Jaringan Telekomunikasi Digital</a>
                        </nav>
                        <div class="card-body">
                            <div class="mb-2">
                                <label id="D4JTD" class="form-label"> D3 Teknik Telekomunikasi</label>
                            </div>
                            <div class="table">
                                <table class="table table-bordered table-responsive table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Nama Mahasiswa 1</th>
                                            <th scope="col" class="text-center">Nama Mahasiswa 2</th>
                                            <th scope="col" class="text-center">Judul Penelitian</th>
                                            <th scope="col" class="text-center">Peran</th>
                                            <th scope="col" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($listBimbinganD3) > 0)
                                            @foreach ($listBimbinganD3 as $index => $kelompok)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    {{-- <td>{{ $proposalId }}</td> --}}
                                                    <td>{{ $kelompok[0]->mahasiswa->nama ?? '-' }}</td>
                                                    <td>{{ $kelompok[1]->mahasiswa->nama ?? '-' }}</td>
                                                    <td>{{ $kelompok->first()->proposal->judul }}</td>
                                                    <td>
                                                        @if ($kelompok->first()->proposal->dosen_pembimbing_1_id == auth('dosen')->user()->id)
                                                            Pembimbing 1
                                                        @elseif($kelompok->first()->proposal->dosen_pembimbing_2_id == auth('dosen')->user()->id)
                                                            Pembimbing 2
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('dosen.bimbingan.detail-bimbingan', $kelompok[0]->mahasiswa->id) }}"class="aksi-button btn btn-primary">Detail</a>
                                                        <a href="{{ route('dosen.bimbingan.logbook-mahasiswa', $kelompok[0]->mahasiswa->id) }}"
                                                            class="aksi-button btn btn-primary">Logbook</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label id="D4JTD" class="form-label"> D4 Jaringan Telekomunikasi Digital</label>
                            </div>
                            <div class="table">
                                <table class="table table-bordered table-responsive table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Nama Mahasiswa</th>
                                            <th scope="col" class="text-center">Judul Proposal</th>
                                            <th scope="col" class="text-center">Peran</th>
                                            <th scope="col" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($listBimbinganD4) > 0)
                                            @foreach ($listBimbinganD4 as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    {{-- <td>{{ $proposalId }}</td> --}}
                                                    <td>{{ $item->mahasiswa->nama }}</td>
                                                    <td>{{ $item->proposal->judul }}</td>
                                                    <td>
                                                        @if ($item->proposal->dosen_pembimbing_1_id == auth('dosen')->user()->id)
                                                            Pembimbing 1
                                                        @elseif($item->proposal->dosen_pembimbing_2_id == auth('dosen')->user()->id)
                                                            Pembimbing 2
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('dosen.bimbingan.detail-bimbingan', $item->mahasiswa->id) }}"class="aksi-button btn btn-primary">Detail</a>
                                                        <a href="{{ route('dosen.bimbingan.logbook-mahasiswa', $item->mahasiswa->id) }}"
                                                            class="aksi-button btn btn-primary">Logbook</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--end::Body-->
                    </form>
                    <!--end::Form-->
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
