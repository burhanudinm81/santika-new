@extends("mahasiswa.home")

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profil Dosen</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content" style="padding-bottom: 120px;">
    <div class="container-fluid">
        <div class="row mb-3 justify-content-end">
            <div class="col-auto">
                <form method="GET" action="{{ route('mahasiswa.informasi-dosen.daftar-dosen') }}">
                    <div class="input-group">
                        <select name="bidang_minat" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Bidang Minat</option>
                            @foreach ($bidangMinatList as $bm)
                                <option value="{{ $bm->id }}" {{ ($bidangMinatId == $bm->id) ? 'selected' : '' }}>{{ $bm->bidang_minat }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Filter Bidang Minat -->
        <div class="card card-solid border-0" style="background-color: transparent;">
            <div class="card-body pb-3">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
                    @foreach ($dosen as $dsn)
                        <div class="col d-flex align-items-stretch mb-4">
                            <div class="card bg-light d-flex flex-fill shadow-sm">
                                <div class="card-body py-2 text-center">
                                    @if (is_null($dsn->foto_profil))
                                        <img src="{{ url('/images/blank-profile-64x64.png') }}" alt="user-avatar"
                                            class="img-circle img-fluid mx-auto d-block mb-2" style="width: 64px; height: 64px;">
                                    @else
                                        <img src="{{ $dsn->foto_profil }}" alt="user-avatar"
                                            class="img-circle img-fluid mx-auto d-block mb-2" style="width: 64px; height: 64px;">
                                    @endif
                                    <h2 class="h6 mt-1 mb-1"><b>{{ \Illuminate\Support\Str::limit($dsn->nama ?? 'Nama Dosen', 20) }}</b></h2>
                                    <p class="text-muted text-sm mb-1" style="line-height: 1.2; height: 2.4em; overflow: hidden;">
                                        {{ $dsn->bidangMinats->pluck('bidang_minat')->implode(', ') ?: 'Bidang Keahlian' }}
                                    </p>
                                </div>
                                <div class="card-footer text-center py-1">
                                    <a href="{{ route('mahasiswa.informasi-dosen.profil-dosen', ['id' => $dsn->id]) }}" class="btn btn-link btn-sm text-secondary">
                                        Detail Dosen
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer d-flex justify-content-center border-0 mb-5">
                {{ $dosen->links('pagination::bootstrap-4') }}
            </div>
            <!-- /.card-footer -->
        </div>

    </div><!-- /.container-fluid -->
</div>
@endsection
<!-- /.content -->
 <script src="{{ url("/custom/js/open-detail-page.js") }}"></script>