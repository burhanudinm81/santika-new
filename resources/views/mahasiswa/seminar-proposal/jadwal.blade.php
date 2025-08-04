@extends("mahasiswa.home")

@section("content")
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Jadwal Seminar Proposal</h1>
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
                            @if (is_null($jadwalSeminarProposal))
                                <div class="mb-3">
                                    <div class="alert alert-danger">
                                        <p>Anda belum memiliki jadwal seminar proposal!</p>
                                    </div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label for="TanggalSempro" class="form-label">Tanggal</label>
                                    <input type="text" class="form-control" id="TanggalSempro"
                                        value="{{ $jadwalSeminarProposal->tanggal->isoFormat('dddd, D MMMM YYYY') ?? '-' }}"
                                        aria-describedby="TanggalSempro" aria-label="readonly input example" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="RuanganSempro" class="form-label">Ruangan</label>
                                    <input type="text" class="form-control" id="RuanganSempro"
                                        value="{{ $jadwalSeminarProposal->ruang }}" aria-describedby="RuanganSempro"
                                        aria-label="readonly input example" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="SesiSempro" class="form-label">Sesi dan Jam</label>
                                    <input type="text" class="form-control" id="SesiSempro"
                                        value="Sesi {{ $jadwalSeminarProposal->sesi }}, {{ $jadwalSeminarProposal->waktu_mulai->isoFormat('HH:mm') }} - {{ $jadwalSeminarProposal->waktu_selesai->isoFormat('HH:mm') }}"
                                        aria-describedby="SesiSempro" aria-label="readonly input example" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="Moderator" class="form-label">Moderator</label>
                                    <input type="text" class="form-control" id="Moderator" value="{{ $jadwalSeminarProposal->proposal->dosenPembimbing1->nama ?? '-' }}"
                                        aria-describedby="Moderator" aria-label="readonly input example" readonly>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection