@extends('panitia.home')

@section('content-panitia')
    {{-- floating notification --}}
    @if (session('success'))
        <div>
            {{-- modal popup success --}}
            <div style="
                    position: fixed;
                    top: 30px;
                    left: 60%;
                    transform: translateX(-50%);
                    z-index: 1050;
                    width: 50%;
                    transition: all 0.2s ease-in-out;
                "
                class="bg-white border-bottom-0 border-right-0 border-left-0 py-4 border-success shadow shadow-md mx-auto alert alert-dismissible fade show relative"
                role="alert">
                <strong class="text-success">{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Kuota Dosen</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <!-- Tabel Kuota Dosen D3 Teknik Telekomunikasi -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header px-0">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5>Kuota Dosen D3 Teknik Telekomunikasi</h5>
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
                        <div class="card-body p-0">
                            <div class="table-responsive" style="height: 320px">
                                <table class="table table-head-fixed text-nowrap" id="tabel-kuota-dosen-d3">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle">No</th>
                                            <th class="text-center align-middle">Nama</th>
                                            <th class="text-center align-middle">Dosen Pembimbing 1</th>
                                            <th class="text-center align-middle">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kuota-d3-tbody"></tbody>
                                </table>
                            </div>
                            <button id="reset-kuota-d3" class="btn btn-success m-3">Reset Kuota</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Kuota Dosen D4 Jaringan Telekomunikasi Digital-->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header px-0">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm">
                                        <h5>Kuota Dosen D4 Jaringan Telekomunikasi Digital</h5>
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
                        <div class="card-body p-0">
                            <div class="table-responsive" style="height: 320px">
                                <table class="table table-head-fixed text-nowrap" id="tabel-kuota-dosen-d4">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle">No</th>
                                            <th class="text-center align-middle">Nama</th>
                                            <th class="text-center align-middle">Dosen Pembimbing 1</th>
                                            <th class="text-center align-middle">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kuota-d4-tbody"></tbody>
                                </table>
                            </div>
                            <button id="reset-kuota-d4" class="btn btn-success m-3">Reset Kuota</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('modals')
    <!-- Modal Edit Kuota Dosen -->
    <div class="modal fade" id="editKuotaModal" tabindex="-1" role="dialog" aria-labelledby="editKuotaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKuotaModalLabel">Edit Kuota Dosen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editKuotaForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit-kuota-id" name="kuota_id">
                        <input type="hidden" id="edit-prodi-id" name="prodi_id">
                        <div class="form-group">
                            <label>Nama Dosen</label>
                            <p id="edit-nama-dosen"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit-kuota-value">Kuota Pembimbing 1</label>
                            <input type="number" class="form-control" id="edit-kuota-value" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Reset Kuota Dosen-->
    <div id="modal-reset-kuota" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Kuota Dosen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panitia.kuota-dosen.reset') }}" id="form-reset-kuota" method="POST">
                        @csrf
                        <input type="hidden" name="prodi_id">
                        <div class="form-group">
                            <label for="jenis-kuota">Pilih Kuota Yang Ingin Direset:</label>
                            <select class="form-control" id="jenis-kuota" name="jenis_kuota">
                                <option value="1">Kuota Pembimbing 1</option>
                                <option value="2">Kuota Pembimbing 2</option>
                                <option value="3">Kuota Penguji Sempro 1</option>
                                <option value="4">Kuota Penguji Sempro 2</option>
                                <option value="5">Kuota Penguji Sidang Akhir 1</option>
                                <option value="6">Kuota Penguji Sidang Akhir 2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kuota">Kuota:</label>
                            <input type="number" class="form-control" id="kuota" name="kuota">
                        </div>
                        <div class="d-flex flex-row-reverse">
                            <button type="button" class="btn btn-secondary mx-1" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success mx-1">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-panitia')
    <script src="{{ url("/custom/js/edit-kuota-dosen.js") }}"></script>
@endsection