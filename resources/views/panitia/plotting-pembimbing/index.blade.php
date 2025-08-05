@extends('panitia.home')

@section('content-panitia')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Ploting Dosen Pembimbing</h1>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5>D3 Teknik Telekomunikasi</h5>
                                    </div>
                                    <div class="col-sm">
                                        <div class="input-group input-group-sm float-right" style="width: 150px">
                                            <input type="text" id="search-dosen-d3" name="table_search"
                                                class="form-control float-right" placeholder="Search" />

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 320px">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">No</th>
                                        <th class="text-center align-middle">NIM 1</th>
                                        <th class="text-center align-middle">Nama Mhs 1</th>
                                        <th class="text-center align-middle">NIM 2</th>
                                        <th class="text-center align-middle">Nama Mhs 2</th>
                                        <th class="text-center align-middle">Dosen Pembimbing 1</th>
                                        <th class="text-center align-middle">Dosen Pembimbing 2</th>
                                        <th class="text-center align-middle">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (is_null($listProposalD3))
                                        <tr>
                                            <td colspan="8" class="text-center">Data Kosong.</td>
                                        </tr>
                                    @else
                                        @foreach ($listProposalD3 as $index => $proposal)
                                            <tr data-proposal-id="{{ $proposal->id }}" data-dosbing1-id="{{ $proposal->dosenPembimbing1->id ?? "" }}" data-dosbing2-id="{{ $proposal->dosenPembimbing2->id ?? "" }}">
                                                <td class="text-center align-middle">{{ $index + 1 }}</td>
                                                <td class="text-center align-middle">{{ $proposal->proposalMahasiswas[0]->mahasiswa->nim ?? "-" }}</td>
                                                <td class="text-center align-middle">{{ $proposal->proposalMahasiswas[0]->mahasiswa->nama ?? "-" }}</td>
                                                <td class="text-center align-middle">{{ $proposal->proposalMahasiswas[1]->mahasiswa->nim ?? "-" }}</td>
                                                <td class="text-center align-middle">{{ $proposal->proposalMahasiswas[1]->mahasiswa->nama ?? "-" }}</td>
                                                <td class="text-center align-middle">{{ $proposal->dosenPembimbing1->nama ?? "-" }}</td>
                                                <td class="text-center align-middle">{{ $proposal->dosenPembimbing2->nama ?? "-" }}</td>
                                                <td class="text-center align-middle">
                                                    <button class="btn btn-warning btn-sm" data-prodi-id="{{ $proposal->prodi_id }}" onclick="editItem(this)">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5>D4 Jaringan Telekomunikasi Telekomunikasi</h5>
                                    </div>
                                    <div class="col-sm">
                                        <div class="input-group input-group-sm float-right" style="width: 150px">
                                            <input type="text" id="search-dosen-d4" name="table_search"
                                                class="form-control float-right" placeholder="Search" />

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0" style="height: 320px">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">No</th>
                                        <th class="text-center align-middle">NIM</th>
                                        <th class="text-center align-middle">Nama</th>
                                        <th class="text-center align-middle">Dosen Pembimbing 1</th>
                                        <th class="text-center align-middle">Dosen Pembimbing 2</th>
                                        <th class="text-center align-middle">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if (is_null($listProposalD4))
                                        <tr>
                                            <td colspan="6" class="text-center">Data Kosong.</td>
                                        </tr>
                                    @else
                                        @foreach ($listProposalD4 as $index => $proposal)
                                            <tr data-proposal-id="{{ $proposal->id }}" data-dosbing1-id="{{ $proposal->dosenPembimbing1->id ?? "" }}" data-dosbing2-id="{{ $proposal->dosenPembimbing2->id ?? "" }}">
                                                <td class="text-center align-middle" >{{ $index + 1 }}</td>
                                                <td class="text-center align-middle">{{ $proposal->proposalMahasiswas[0]->mahasiswa->nim ?? "-" }}</td>
                                                <td class="text-center align-middle">{{ $proposal->proposalMahasiswas[0]->mahasiswa->nama ?? "-" }}</td>
                                                <td class="text-center align-middle">{{ $proposal->dosenPembimbing1->nama ?? "-" }}</td>
                                                <td class="text-center align-middle" >{{ $proposal->dosenPembimbing2->nama ?? "-" }}</td>
                                                <td class="text-center align-middle">
                                                    <button class="btn btn-warning btn-sm" data-prodi-id="{{ $proposal->prodi_id }}" onclick="editItem(this)">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="editModalD3" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Dosen Pembimbing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-pembimbing-form-d3" action="{{ route('panitia.plotting-pembimbing.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="prodi_id" value="1">
                        <input type="hidden" name="proposal_id">
                        <div class="form-group">
                            <label for="namaMahasiswa">Nama Mahasiswa 1</label>
                            <input type="text" class="form-control" id="nama-mahasiswa-1" readonly>
                        </div>
                        <div class="form-group">
                            <label for="namaMahasiswa">Nama Mahasiswa 2</label>
                            <input type="text" class="form-control" id="nama-mahasiswa-2" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dosen-pembimbing-1">Dosen Pembimbing 1</label>
                            <select class="form-control" id="dosen-pembimbing-1" name="dosen_pembimbing_1_id">
                                @foreach ($listDosen as $dosen)
                                    <option value="{{ $dosen->id }}">
                                        {{ $dosen->nama }} - Sisa Kuota: {{ $dosen->kuotaDosen->kuota_pembimbing_1_D3 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dosen-pembimbing-2">Dosen Pembimbing 2</label>
                            <select class="form-control" id="dosen-pembimbing-2" name="dosen_pembimbing_2_id">
                                @foreach ($listDosen as $dosen)
                                    <option value="{{ $dosen->id }}">
                                        {{ $dosen->nama }} - Sisa Kuota: {{ $dosen->kuotaDosen->kuota_pembimbing_2_D3 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-changes">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModalD4" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Dosen Pembimbing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-pembimbing-form-d4" action="{{ route('panitia.plotting-pembimbing.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="prodi_id" value="2">
                        <input type="hidden" name="proposal_id">
                        <!-- Menambahkan Nama Mahasiswa yang Read-Only -->
                        <div class="form-group">
                            <label for="namaMahasiswa">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="nama-mahasiswa" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dosen-pembimbing-1">Dosen Pembimbing 1</label>
                            <select class="form-control" id="dosen-pembimbing-1" name="dosen_pembimbing_1_id">
                                @foreach ($listDosen as $dosen)
                                    <option value="{{ $dosen->id }}">
                                        {{ $dosen->nama }} - Sisa Kuota: {{ $dosen->kuotaDosen->kuota_pembimbing_1_D4 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dosen-pembimbing-2">Dosen Pembimbing 2</label>
                            <select class="form-control" id="dosen-pembimbing-2" name="dosen_pembimbing_2_id">
                                @foreach ($listDosen as $dosen)
                                    <option value="{{ $dosen->id }}">
                                        {{ $dosen->nama }} - Sisa Kuota: {{ $dosen->kuotaDosen->kuota_pembimbing_2_D4 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-changes">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-panitia')
    <script src="{{ url("/custom/js/plotting-pembimbing/plotting-pembimbing.js") }}"></script>
@endsection