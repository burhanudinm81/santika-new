@extends('admin-prodi.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold">Panitia Tugas Akhir</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                <div class="card card-default">
                    <form action="{{ route("admin-prodi.panitia-tugas-akhir.tambah", ["prodi" => $prodi->id]) }}"
                        method="post" id="form-tambah-panitia" enctype="application/x-www-form-urlencoded"
                        class="form-panitia">
                        @csrf
                        <div class="card-body">
                            <h4>Tambah Panitia TA {{ $prodi->prodi }}</h4>

                            {{-- Loop untuk membuat dropdown secara dinamis --}}
                            @foreach ($jabatanPanitia as $jabatan)
                                <div class="mb-3">
                                    <label class="form-label">{{ $jabatan->jabatan }}</label>
                                    <select class="custom-select" name="panitia_dosen[{{ $jabatan->id }}]" required>
                                        <option value="">-- Pilih Dosen --</option>
                                        @foreach ($dosen as $dsn)
                                            <option value="{{ $dsn->id }}">{{ $dsn->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <a href="/admin-prodi/panitia-tugas-akhir" class="btn btn-secondary" id="batal">Batal</a>
                            <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('page-scripts')
    <script src={{ url("/custom/js/kelola-panitia-ta/ubah-panitia.js") }}></script>
@endpush