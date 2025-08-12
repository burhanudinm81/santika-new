@extends("mahasiswa.home")

@section("content")
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jadwal Sidang Ujian Akhir</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                <div class="card card-primary card-outline mb-4">
                    <form>
                        <div class="card-body">
                            @if (is_null($jadwalSeminarHasil))
                                <div class="mb-3">
                                    <div class="alert alert-danger">
                                        <p>Anda belum memiliki jadwal Sidang Ujian Akhir!</p>
                                    </div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label for="TanggalSemhas" class="form-label">Tanggal</label>
                                    <input type="text" class="form-control" id="TanggalSemhas"
                                        value="{{ $jadwalSeminarHasil->tanggal->isoFormat('dddd, D MMMM YYYY') ?? '-' }}"
                                        aria-describedby="TanggalSemhas" aria-label="readonly input example" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="RuanganSemhas" class="form-label">Ruangan</label>
                                    <input type="text" class="form-control" id="RuanganSemhas"
                                        value="{{ $jadwalSeminarHasil->ruang ?? "-" }}" aria-describedby="RuanganSemhas"
                                        aria-label="readonly input example" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="SesiSemhas" class="form-label">Sesi dan Jam</label>
                                    <input type="text" class="form-control" id="SesiSemhas"
                                        value="Sesi {{ $jadwalSeminarHasil->sesi ?? "-" }}, {{ $jadwalSeminarHasil->waktu_mulai->isoFormat('HH:mm') ?? "-" }} - {{ $jadwalSeminarHasil->waktu_selesai->isoFormat('HH:mm') ?? "-" }}"
                                        aria-describedby="SesiSemhas" aria-label="readonly input example" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="DosenPembimbing1" class="form-label">Dosen Pembimbing 1</label>
                                    <input type="text" class="form-control" id="DosenPembimbing1" value="{{ $jadwalSeminarHasil->proposal->dosenPembimbing1->nama ?? "-" }}"
                                        aria-describedby="DosenPembimbing1" aria-label="readonly input example" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="DosenPembimbing2" class="form-label">Dosen Pembimbing 2</label>
                                    <input type="text" class="form-control" id="DosenPembimbing2" value="{{ $jadwalSeminarHasil->proposal->dosenPembimbing2->nama ?? "-" }}"
                                        aria-describedby="DosenPembimbing2" aria-label="readonly input example" readonly>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection