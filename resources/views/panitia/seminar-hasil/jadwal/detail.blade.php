@extends('panitia.home')

@section('content-panitia')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <h1 class="m-0">Detail Jadwal Sidang Ujian Akhir Prodi {{ $prodi->prodi }}</h1>
                    <h1>Periode {{ $periode->tahun }} Tahap {{ $tahap->tahap }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-2">
                <a href="{{ route('panitia.jadwal-sidang-akhir.edit', ["periode" => $periode->id, "tahap" => $tahap->id]) }}"
                    class="btn btn-success">
                    Edit
                </a>
            </div>
            <div class="row mb-2">
                <div class="card-body table-responsive p-0">
                    <table id="tabel-proposal" class="table table-bordered table-head-fixed" style="table-layout: fixed;">
                        <thead>
                            <tr>
                                <th style="width: 50px" class="text-center">No</th>
                                <th style="width: 100px" class="text-center">Ruang</th>
                                <th style="width: 150px" class="text-center">Tanggal</th>
                                <th style="width: 50px" class="text-center">Sesi</th>
                                <th style="width: 200px" class="text-center">Waktu</th>
                                <th style="width: 300px" class="text-center">Judul</th>
                                <th style="width: 300px" class="text-center">Mahasiswa 1</th>
                                @if ($prodi->id == 1)
                                    <th style="width: 300px" class="text-center">Mahasiswa 2</th>
                                @endif
                                <th style="width: 300px" class="text-center">Dosen Pembimbing 1</th>
                                <th style="width: 300px" class="text-center">Dosen Pembimbing 2</th>
                                <th style="width: 300px" class="text-center">Dosen Penguji 1</th>
                                <th style="width: 300px" class="text-center">Dosen Penguji 2</th>
                            </tr>
                        </thead>
                        <tbody id="dosen-table-body">
                            @if(is_null($jadwalSemhas) || $jadwalSemhas->isEmpty())
                                <tr>
                                    <td colspan="12" class="text-center">Tidak ada data jadwal seminar proposal</td>
                                </tr>
                            @else
                                @php
                                    // Hitung rowspan untuk setiap sesi (tanggal, sesi, waktu)
                                    $rowspanMap = [];
                                    foreach ($jadwalSemhas as $jadwal) {
                                        $key = $jadwal->tanggal . '|' . $jadwal->sesi . '|' . $jadwal->waktu_mulai . '|' . $jadwal->waktu_selesai;
                                        if (!isset($rowspanMap[$key])) $rowspanMap[$key] = 0;
                                        $rowspanMap[$key]++;
                                    }
                                    $printed = [];
                                @endphp
                                @foreach ($jadwalSemhas as $index => $jadwal)
                                    @php
                                        $key = $jadwal->tanggal . '|' . $jadwal->sesi . '|' . $jadwal->waktu_mulai . '|' . $jadwal->waktu_selesai;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jadwal->ruang }}</td>
                                        @if (empty($printed[$key]))
                                            <td rowspan="{{ $rowspanMap[$key] }}">{{ $jadwal->tanggal->isoFormat("dddd, DD-MM-YYYY") ?? "-" }}</td>
                                            <td rowspan="{{ $rowspanMap[$key] }}">{{ $jadwal->sesi ?? "-" }}</td>
                                            <td rowspan="{{ $rowspanMap[$key] }}" class="text-center">{{ $jadwal->waktu_mulai->isoFormat("HH:mm") ?? "-" }} - {{$jadwal->waktu_selesai->isoFormat("HH:mm") ?? "-" }}</td>
                                            @php $printed[$key] = true; @endphp
                                        @endif
                                        <td>{{ $jadwal->proposal->judul }}</td>
                                        <td>{{ $jadwal->proposal->proposalMahasiswas[0]->mahasiswa->nama ?? "-" }}</td>
                                        @if ($prodi->id == 1)
                                            @if (empty($jadwal->proposal->proposalMahasiswas[1]))
                                                <td> - </td>
                                            @else
                                                <td>{{ $jadwal->proposal->proposalMahasiswas[1]->mahasiswa->nama }}</td>
                                            @endif
                                        @endif
                                        <td>{{ $jadwal->proposal->dosenPembimbing1->nama ?? "-" }}</td>
                                        <td>{{ $jadwal->proposal->dosenPembimbing2->nama ?? "-" }}</td>
                                        <td>{{ $jadwal->proposal->dosenPengujiSidangTA1->nama ?? "-" }}</td>
                                        <td>{{ $jadwal->proposal->dosenPengujiSidangTA2->nama ?? "-" }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection