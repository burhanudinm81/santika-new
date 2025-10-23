@extends('dosen.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jadwal Seminar Proposal Tahap {{ $tahap->tahap ?? '-' }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                <div class="my-2" style="width: 300px; margin-right: 300px">
                    <div class="input-group">
                        <select class="custom-select" id="periode" aria-label="Periode">
                            <option disabled>Pilih Periode</option>
                            @foreach ($listPeriode as $periode)
                                @if ($periode->id == $periodeId)
                                    <option value="{{ $periode->id }}" selected>{{ $periode->tahun }}</option>
                                @else
                                    <option value="{{ $periode->id }}">{{ $periode->tahun }}</option>
                                @endif
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
                                            <th scope="col" class="text-center">Moderator</th>
                                            <th scope="col" class="text-center">Dosen Penguji 1</th>
                                            <th scope="col" class="text-center">Dosen Penguji 2</th>
                                            <th scope="col" class="text-center">Aksi</th>
                                            <th scope="col" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($jadwalSeminarProposalD3->isEmpty())
                                            <tr>
                                                <td colspan="11" class="text-center">Tidak ada jadwal seminar proposal
                                                    yang tersedia</td>
                                            </tr>
                                        @else
                                            @foreach ($jadwalSeminarProposalD3 as $idx => $jadwal)
                                                <tr>
                                                    <th scope="row">{{ $idx + 1 }}</th>
                                                    <td>{{ $jadwal->ruang ?? '-' }}</td>
                                                    <td>{{ $jadwal->tanggal->isoFormat('dddd, D MMMM YYYY') ?? '-' }}</td>
                                                    <td>
                                                        Sesi {{ $jadwal->sesi ?? '-' }},
                                                        {{ $jadwal->waktu_mulai->isoFormat('HH:mm') ?? '-' }}-{{ $jadwal->waktu_selesai->isoFormat('HH:mm') ?? '-' }}
                                                    </td>
                                                    <td>{{ $jadwal->proposal->proposalMahasiswas[0]->mahasiswa->nama ?? '-' }}
                                                    </td>
                                                    <td>{{ $jadwal->proposal->proposalMahasiswas[1]->mahasiswa->nama ?? '-' }}
                                                    </td>
                                                    <td>{{ $jadwal->proposal->judul ?? '-' }}</td>
                                                    <td>{{ $jadwal->proposal->dosenPembimbing1->nama ?? '-' }}</td>
                                                    <td>{{ $jadwal->proposal->dosenPengujiSempro1->nama ?? '-' }}</td>
                                                    <td>{{ $jadwal->proposal->dosenPengujiSempro2->nama ?? '-' }}</td>
                                                    @if (auth('dosen')->id() != $jadwal->proposal->dosen_pembimbing_1_id)
                                                        <td><a href="{{ route('dosen.penilaian-sempro', ['proposal_id' => $jadwal->proposal_id]) }}"
                                                                class="btn btn-primary" style="width: 150px">Status Kelulusan</a></td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                                    <td>
                                                        @if ($jadwal->belumDinilai)
                                                            <span class="badge badge-warning">Belum Dinilai</span>
                                                        @else
                                                            <span class="badge badge-success">Sudah Dinilai</span>
                                                        @endif
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
                                            <th scope="col" class="text-center">Moderator</th>
                                            <th scope="col" class="text-center">Dosen Penguji 1</th>
                                            <th scope="col" class="text-center">Dosen Penguji 2</th>
                                            <th scope="col" class="text-center">Aksi</th>
                                            <th scope="col" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($jadwalSeminarProposalD4->isEmpty())
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada jadwal seminar proposal
                                                    yang tersedia</td>
                                            </tr>
                                        @else
                                            @foreach ($jadwalSeminarProposalD4 as $idx => $jadwal)
                                                <tr>
                                                    <th scope="row">{{ $idx + 1 }}</th>
                                                    <td>{{ $jadwal->ruang ?? '-' }}</td>
                                                    <td>{{ $jadwal->tanggal->isoFormat('dddd, D MMMM YYYY') ?? '-' }}</td>
                                                    <td>
                                                        Sesi {{ $jadwal->sesi ?? '-' }},
                                                        {{ $jadwal->waktu_mulai->isoFormat('HH:mm') ?? '-' }}-{{ $jadwal->waktu_selesai->isoFormat('HH:mm') ?? '-' }}
                                                    </td>
                                                    <td>{{ $jadwal->proposal->proposalMahasiswas[0]->mahasiswa->nama ?? '-' }}
                                                    </td>
                                                    <td>{{ $jadwal->proposal->judul ?? '-' }}</td>
                                                    <td>{{ $jadwal->proposal->dosenPembimbing1->nama ?? '-' }}</td>
                                                    <td>{{ $jadwal->proposal->dosenPengujiSempro1->nama ?? '-' }}</td>
                                                    <td>{{ $jadwal->proposal->dosenPengujiSempro2->nama ?? '-' }}</td>
                                                    @if (auth('dosen')->id() != $jadwal->proposal->dosen_pembimbing_1_id)
                                                        <td><a href="{{ route('dosen.penilaian-sempro', ['proposal_id' => $jadwal->proposal_id]) }}"
                                                                class="btn btn-primary" style="width: 150px">Status
                                                                Kelulusan</a></td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                                    <td>
                                                        @if ($jadwal->belumDinilai)
                                                            <span class="badge badge-warning">Belum Dinilai</span>
                                                        @else
                                                            <span class="badge badge-success">Sudah Dinilai</span>
                                                        @endif
                                                        @if ($jadwal->belumCekRevisi)
                                                             <span class="badge badge-warning">Revisi Belum Dicek</span>
                                                        @endif
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
            <a href="{{ route('dosen.seminar-proposal.beranda-jadwal') }}" class="btn btn-info my-2">
                Kembali
            </a>
        </div>
    </div>
@endsection

@push('page-scripts')
    <script src="{{ asset('/custom/js/seminar-proposal/dosen/filter-jadwal-based-on-periode.js') }}"></script>
@endpush
