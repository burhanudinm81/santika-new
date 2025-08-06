@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0">Penilaian Akhir Ujian Tugas Akhir</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row">
                <div class="col">
                    <h5 class="font-weight-bold"> {{ $roleDosen }} - {{ $currentDosenInfo->nama }}</h5>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            @if (session()->has('success'))
                @include('notifications.success-alert', ['message' => session('success')])
            @endif

            <div class="col-md-15">
                <div class="card card-primary card-outline mb-2">
                    <!--begin::Form-->
                    <form action="{{ route('dosen.penilaian-semhas.update-penilaian-akhir') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!--begin::Body-->
                        <div class="card-body">
                            <form method="POST" action="proses_penilaian_kelulusan.php">
                                <div class="form-group">
                                    <label for="status_kelulusan">Status Kelulusan:</label>
                                    <input type="text" class="form-control bg-info"
                                        value="{{ $mainProposal->statusSemhasTotal->status }}" readonly>
                                </div>

                                {{-- input hidden --}}
                                <input type="hidden" name="proposal_id" value="{{ $mainProposal->id }}">
                                <input type="hidden" name="prodi_id" value="{{ $mainProposal->prodi_id }}">
                                <input type="hidden" id="role_dosen" name="role_dosen" value="{{ $roleDosen }}">


                                <div class="row">
                                    @if ($mainProposal->prodi_id == 1)
                                        {{-- mahasiswa 1 --}}
                                        <div class="col-md-6 student-panel">
                                            {{-- input hidden mahasiswa 1 --}}
                                            <input type="hidden" name="mahasiswa1_id"
                                                value="{{ $mainProposal->proposalMahasiswas[0]->mahasiswa->id }}">

                                            <div class="form-group">
                                                <label for="nama_mahasiswa1">Nama Mahasiswa 1:</label>
                                                <input type="text" class="form-control" id="nama_mahasiswa1"
                                                    name="nama_mahasiswa1"
                                                    value="{{ $mainProposal->proposalMahasiswas[0]->mahasiswa->nama }}"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="sikap1">Sikap:</label>
                                                <input type="number" class="form-control" id="sikap1" name="sikap1"
                                                    min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="kemampuan1">Kemampuan:</label>
                                                <input type="number" class="form-control" id="kemampuan1" name="kemampuan1"
                                                    min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="hasil_karya1">Hasil Karya:</label>
                                                <input type="number" class="form-control" id="hasil_karya1"
                                                    name="hasil_karya1" min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="laporan1">Laporan:</label>
                                                <input type="number" class="form-control" id="laporan1" name="laporan1"
                                                    min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="rata_rata1">Rata-Rata:</label>
                                                <input type="text" class="form-control" id="rata_rata1" name="rata_rata1"
                                                    readonly>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger"
                                                id="countAverage1">Kalkulasi</button>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing1_1">Nilai Pembimbing 1:</label>
                                                <input type="text" class="form-control" id="nilai_mahasiswa1_pembimbing1"
                                                    value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem1 ?? ''}}"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing2_1">Nilai Pembimbing 2:</label>
                                                <input type="text" class="form-control" id="nilai_mahasiswa1_pembimbing2"
                                                   value="{{ $nilaiAkhirMahasiswa1->avg_nilai_dospem2 ?? ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing2_1">Nilai Penguji 1:</label>
                                                <input type="text" class="form-control"
                                                    id="nilai_mahasiswa1_pembimbing2"  value="{{ $nilaiAkhirMahasiswa1->avg_nilai_penguji1 ?? ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing2_1">Nilai Penguji 2:</label>
                                                <input type="text" class="form-control"
                                                    id="nilai_mahasiswa1_pembimbing2"  value="{{ $nilaiAkhirMahasiswa1->avg_nilai_penguji2 ?? ''}}" readonly>
                                            </div>
                                        </div>

                                        {{-- mahasiswa 2 --}}
                                        <div class="col-md-6 student-panel">
                                            {{-- input hidden mahasiswa 2 --}}
                                            <input type="hidden" name="mahasiswa2_id"
                                                value="{{ $mainProposal->proposalMahasiswas[1]->mahasiswa->id }}">

                                            <div class="form-group">
                                                <label for="nama_mahasiswa2">Nama Mahasiswa 2:</label>
                                                <input type="text" class="form-control" id="nama_mahasiswa2"
                                                    name="nama_mahasiswa2"
                                                    value="{{ $mainProposal->proposalMahasiswas[1]->mahasiswa->nama }}"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="sikap2">Sikap:</label>
                                                <input type="number" class="form-control" id="sikap2" name="sikap2"
                                                    min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="kemampuan2">Kemampuan:</label>
                                                <input type="number" class="form-control" id="kemampuan2"
                                                    name="kemampuan2" min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="hasil_karya2">Hasil Karya:</label>
                                                <input type="number" class="form-control" id="hasil_karya2"
                                                    name="hasil_karya2" min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="laporan2">Laporan:</label>
                                                <input type="number" class="form-control" id="laporan2"
                                                    name="laporan2" min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="rata_rata2">Rata-Rata:</label>
                                                <input type="text" class="form-control" id="rata_rata2"
                                                    name="rata_rata2" readonly>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger"
                                                id="countAverage2">Kalkulasi</button>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing1_2">Nilai Pembimbing 1:</label>
                                                <input type="text" class="form-control"
                                                    id="nilai_mahasiswa2_pembimbing1"  value="{{ $nilaiAkhirMahasiswa2->avg_nilai_dospem1 ?? ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing2_2">Nilai Pembimbing 2:</label>
                                                <input type="text" class="form-control"
                                                    id="nilai_mahasiswa2_pembimbing1" value="{{ $nilaiAkhirMahasiswa2->avg_nilai_dospem2 ?? ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing2_2">Nilai Penguii 1:</label>
                                                <input type="text" class="form-control"
                                                    id="nilai_mahasiswa2_pembimbing1" value="{{ $nilaiAkhirMahasiswa2->avg_nilai_penguji1 ?? ''}}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing2_2">Nilai Penguii 2:</label>
                                                <input type="text" class="form-control"
                                                    id="nilai_mahasiswa2_pembimbing1" value="{{ $nilaiAkhirMahasiswa2->avg_nilai_penguji2 ?? ''}}" readonly>
                                            </div>
                                        </div>
                                    @elseif($mainProposal->prodi_id == 2)
                                        {{-- mahasiswa  --}}
                                        <div class="col-md-6 student-panel">
                                            {{-- input hidden mahasiswa --}}
                                            <input type="hidden" name="mahasiswa1_id"
                                                value="{{ $mainProposal->proposalMahasiswas[0]->mahasiswa->id }}">

                                            <div class="form-group">
                                                <label for="nama_mahasiswa1">Nama Mahasiswa:</label>
                                                <input type="text" class="form-control" id="nama_mahasiswa1"
                                                    name="nama_mahasiswa1"
                                                    value="{{ $mainProposal->proposalMahasiswas[0]->mahasiswa->nama }}"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="sikap1">Sikap:</label>
                                                <input type="number" class="form-control" id="sikap1" name="sikap1"
                                                    min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="kemampuan1">Kemampuan:</label>
                                                <input type="number" class="form-control" id="kemampuan1"
                                                    name="kemampuan1" min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="hasil_karya1">Hasil Karya:</label>
                                                <input type="number" class="form-control" id="hasil_karya1"
                                                    name="hasil_karya1" min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="laporan1">Laporan:</label>
                                                <input type="number" class="form-control" id="laporan1"
                                                    name="laporan1" min="0" max="100">
                                            </div>
                                            <div class="form-group">
                                                <label for="rata_rata1">Rata-Rata:</label>
                                                <input type="text" class="form-control" id="rata_rata1"
                                                    name="rata_rata1" readonly>
                                            </div>
                                            <button type="button" class="btn btn-outline-danger" data-student="1"
                                                onclick="hitungRataRata(this)">Kalkulasi</button>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing1_1">Nilai Pembimbing 1:</label>
                                                <input type="text" class="form-control" id="nilai_pembimbing1_1"
                                                    name="nilai_pembimbing1_1" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nilai_pembimbing2_1">Nilai Pembimbing 2:</label>
                                                <input type="text" class="form-control" id="nilai_pembimbing2_1"
                                                    name="nilai_pembimbing2_1" readonly>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>

                            {{-- <script>
                                // === Cara Mengambil Elemen HTML ===
                                function getElement(selector) {
                                    return document.querySelector(selector);
                                }

                                // === Cara Mengambil Nilai Elemen HTML ===
                                function getValue(selector) {
                                    const element = getElement(selector);
                                    return element ? parseFloat(element.value) || 0 : 0;
                                }

                                // === Cara Men-trigger Event (secara langsung pada elemen) ===
                                function hitungRataRata(buttonElement) {
                                    // Mengambil nilai atribut data-student dari tombol
                                    const studentNumber = buttonElement.dataset.student;

                                    // Mengambil nilai input menggunakan fungsi getValue
                                    const sikap = getValue(`#sikap${studentNumber}`);
                                    const kemampuan = getValue(`#kemampuan${studentNumber}`);
                                    const hasilKarya = getValue(`#hasil_karya${studentNumber}`);
                                    const laporan = getValue(`#laporan${studentNumber}`);

                                    // Menghitung rata-rata
                                    const rataRata = (sikap + kemampuan + hasilKarya + laporan) / 4;

                                    // Mengambil elemen input rata-rata dan mengatur nilainya
                                    const rataRataInput = getElement(`#rata_rata${studentNumber}`);
                                    if (rataRataInput) {
                                        rataRataInput.value = rataRata.toFixed(2);
                                    }
                                }

                                function simpanPenilaian(event) {
                                    // Mencegah submit form default (untuk simulasi)
                                    event.preventDefault();
                                }
                            </script> --}}
                        </div>

                        <!--end::Body-->
                        <!--begin::Footer-->
                        <!--end::Footer-->
                    </form>
                    <!--end::Form-->

                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <script src="{{ asset('/custom-assets/js/penilaian-semhas.js') }}"></script>
@endsection
