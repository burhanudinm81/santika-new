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
                        <div class="my-2 ml-2" style="width: 300px;">
                            <div class="input-group">
                                <select class="custom-select" id="periode_id" aria-label="Example select with button addon">
                                    <option disabled selected>Pilih Periode</option>
                                    @foreach ($listPeriode as $periode)
                                        <option value="{{ $periode->id }}"
                                            {{ $periodeTerpilih->id == $periode->id ? 'selected' : '' }}>
                                            {{ $periode->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label id="D4JTD" class="form-label"> D3 Teknik Telekomunikasi</label>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Nama Mahasiswa 1</th>
                                            <th scope="col" class="text-center">Nama Mahasiswa 2</th>
                                            <th scope="col" class="text-center">Judul Penelitian</th>
                                            <th scope="col" class="text-center">Peran</th>
                                            <th scope="col" class="text-center">Status Logbook</th>
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
                                                        <div class="container">
                                                            @if (is_null($kelompok->jmlBelumDiverifikasi) && is_null($kelompok->jmlDitolak) && is_null($kelompok->jmlDiterima))
                                                                <div class="row mb-1">
                                                                    <span class="badge badge-secondary">Mahasiswa Belum Mengisi Logbook</span>
                                                                </div>
                                                            @else
                                                                @if(!is_null($kelompok->jmlBelumDiverifikasi))
                                                                    <div class="row mb-1">
                                                                        <span class="badge badge-warning">{{ $kelompok->jmlBelumDiverifikasi }} Belum Diverifikasi</span>
                                                                    </div>
                                                                @endif
                                                                @if(!is_null($kelompok->jmlDitolak))
                                                                    <div class="row mb-1">
                                                                        <span class="badge badge-danger">{{ $kelompok->jmlDitolak }} Logbook Ditolak</span>
                                                                    </div>
                                                                @endif
                                                                @if(!is_null($kelompok->jmlDiterima))
                                                                    <div class="row">
                                                                        <span class="badge badge-success">{{ $kelompok->jmlDiterima }} Logbook Diterima</span>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div>
                                                                <a href="{{ route('dosen.bimbingan.detail-bimbingan', $kelompok[0]->mahasiswa->id) }}"class="aksi-button btn btn-primary mr-1">Detail</a>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('dosen.bimbingan.logbook-mahasiswa', $kelompok[0]->mahasiswa->id) }}"
                                                                    class="aksi-button btn btn-primary ml-1">Logbook</a>
                                                            </div>
                                                        </div>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Nama Mahasiswa</th>
                                            <th scope="col" class="text-center">Judul Proposal</th>
                                            <th scope="col" class="text-center">Peran</th>
                                            <th scope="col" class="text-center">Status Logbook</th>
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
                                                         <div class="container">
                                                            @if (is_null($item->jmlBelumDiverifikasi) && is_null($item->jmlDitolak) && is_null($item->jmlDiterima))
                                                                <div class="row mb-1">
                                                                    <span class="badge badge-secondary">Mahasiswa Belum Mengisi Logbook</span>
                                                                </div>
                                                            @else
                                                                @if(!is_null($item->jmlBelumDiverifikasi))
                                                                    <div class="row mb-1">
                                                                        <span class="badge badge-warning">{{ $item->jmlBelumDiverifikasi }} Belum Diverifikasi</span>
                                                                    </div>
                                                                @endif
                                                                @if(!is_null($item->jmlDitolak))
                                                                    <div class="row mb-1">
                                                                        <span class="badge badge-danger">{{ $item->jmlDitolak }} Logbook Ditolak</span>
                                                                    </div>
                                                                @endif
                                                                @if(!is_null($item->jmlDiterima))
                                                                    <div class="row">
                                                                        <span class="badge badge-success">{{ $item->jmlDiterima }} Logbook Diterima</span>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div>
                                                                <a href="{{ route('dosen.bimbingan.detail-bimbingan', $item->mahasiswa->id) }}"class="aksi-button btn btn-primary mr-1">Detail</a>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('dosen.bimbingan.logbook-mahasiswa', $item->mahasiswa->id) }}"
                                                                    class="aksi-button btn btn-primary ml-1">Logbook</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script>
        $(document).ready(function() {
            $('#periode_id').on('change', function() {
                var selectedPeriodeId = $(this).val();
                if (selectedPeriodeId) {
                    window.location.href = '/dosen/bimbingan/daftar-bimbingan/periode/' + selectedPeriodeId;
                }
            });
        });
    </script>
@endpush