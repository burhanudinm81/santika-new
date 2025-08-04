@extends('dosen.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jadwal Sidang Ujian Akhir Tahap {{ $tahap->tahap }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                <div class="my-2" style="width: 300px; margin-right: 300px">
                    <div class="input-group">
                        <select class="custom-select" id="periode" aria-label="Example select with button addon">
                            <option disabled>Pilih Periode</option>
                            @foreach ($listPeriode as $periode)
                                <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card card-primary card-outline mb-2">
                    <form>
                        <nav class="nav">
                            <a class="nav-link" href="#D3TT">D3 Teknik Telekomunikasi</a>
                            <a class="nav-link" href="#D4JTD">D4 Jaringan Telekomunikasi Digital</a>
                        </nav>
                        <div class="card-body">
                            <div class="mb-2">
                                <label id="D3TT" class="form-label"> D3 Teknik Telekomunikasi</label>
                            </div>
                            <div class="table">
                                <table class="table table-bordered table-responsive table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Ruang</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center">Sesi Waktu</th>
                                            <th scope="col" class="text-center">Nama Mahasiswa 1</th>
                                            <th scope="col" class="text-center">Nama Mahasiswa 2</th>
                                            <th scope="col" class="text-center">Judul Proposal</th>
                                            <th scope="col" class="text-center">Dosen Pembimbing 1</th>
                                            <th scope="col" class="text-center">Dosen Pembimbing 2</th>
                                            <th scope="col" class="text-center">Dosen Penguji 1</th>
                                            <th scope="col" class="text-center">Dosen Penguji 2</th>
                                            <th scope="col" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_null($jadwalSeminarHasilD3) || $jadwalSeminarHasilD3->isEmpty())
                                            <tr>
                                                <td colspan="12" class="text-center">Tidak ada Jadwal Sidang Ujian Akhir
                                                    yang tersedia</td>
                                            </tr>
                                        @else
                                             @foreach ($jadwalSeminarHasilD3 as $idx => $jadwal)
                                            <tr>
                                                <th scope="row">{{ $idx + 1 }}</th>
                                                <td>{{ $jadwal->ruang }}</td>
                                                <td>{{ $jadwal->tanggal->isoFormat('dddd, D MMMM YYYY') }}</td>
                                                <td>Sesi {{ $jadwal->sesi }}, {{ $jadwal->waktu_mulai->isoFormat('HH:mm') }}-{{ $jadwal->waktu_selesai->isoFormat('HH:mm') }}</td>
                                                <td>{{ $jadwal->proposal->proposalMahasiswas[0]->mahasiswa->nama }}</td>
                                                <td>{{ $jadwal->proposal->proposalMahasiswas[1]->mahasiswa->nama }}</td>
                                                <td>{{ $jadwal->proposal->judul }}</td>
                                                <td>{{ $jadwal->proposal->dosenPembimbing1->nama }}</td>
                                                <td>{{ $jadwal->proposal->dosenPembimbing2->nama }}</td>
                                                <td>{{ $jadwal->proposal->dosenPengujiSidangTA1->nama }}</td>
                                                <td>{{ $jadwal->proposal->dosenPengujiSidangTA2->nama }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-primary" style="width: 150px">Input Nilai Sementara</a>
                                                    <a href="#" class="btn btn-primary mt-1" style="width: 150px">Input Nilai Akhir</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <label id="D4JTD" class="form-label"> D4 Jaringan Telekomunikasi Digital</label>
                            <div class="table">
                                <table class="table table-bordered table-responsive table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Ruang</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center">Sesi Waktu</th>
                                            <th scope="col" class="text-center">Nama Mahasiswa</th>
                                            <th scope="col" class="text-center">Judul Proposal</th>
                                            <th scope="col" class="text-center">Dosen Pembimbing 1</th>
                                            <th scope="col" class="text-center">Dosen Pembimbing 2</th>
                                            <th scope="col" class="text-center">Dosen Penguji 1</th>
                                            <th scope="col" class="text-center">Dosen Penguji 2</th>
                                            <th scope="col" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (is_null($jadwalSeminarHasilD4) || $jadwalSeminarHasilD4->isEmpty())
                                            <tr>
                                                <td colspan="11" class="text-center">Tidak ada Jadwal Ujian Akhir
                                                    yang tersedia</td>
                                            </tr>
                                        @else
                                             @foreach ($jadwalSeminarHasilD4 as $idx => $jadwal)
                                            <tr>
                                                <th scope="row">{{ $idx + 1 }}</th>
                                                <td>{{ $jadwal->ruang }}</td>
                                                <td>{{ $jadwal->tanggal->isoFormat('dddd, D MMMM YYYY') }}</td>
                                                <td>Sesi {{ $jadwal->sesi }}, {{ $jadwal->waktu_mulai->isoFormat('HH:mm') }}-{{ $jadwal->waktu_selesai->isoFormat('HH:mm') }}</td>
                                                <td>{{ $jadwal->proposal->proposalMahasiswas[0]->mahasiswa->nama }}</td>
                                                <td>{{ $jadwal->proposal->judul }}</td>
                                                <td>{{ $jadwal->proposal->dosenPembimbing1->nama }}</td>
                                                <td>{{ $jadwal->proposal->dosenPembimbing2->nama }}</td>
                                                <td>{{ $jadwal->proposal->dosenPengujiSidangTA1->nama }}</td>
                                                <td>{{ $jadwal->proposal->dosenPengujiSidangTA2->nama }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-primary" style="width: 150px">Input Nilai Sementara</a>
                                                    <a href="#" class="btn btn-primary mt-1" style="width: 150px">Input Nilai Akhir</a>
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