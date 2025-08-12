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
                                    @if ($roleDosen == 'Dosen Penguji Sidang TA 1' || $roleDosen == 'Dosen Penguji Sidang TA 2')
                                        @include('dosen.penilaian.semhas.byPenguji.penilaian-byPenguji', [
                                            'mainProposal' => $mainProposal,
                                            'nilaiAkhirMahasiswa1' => $nilaiAkhirMahasiswa1,
                                            'nilaiAkhirMahasiswa2' => $nilaiAkhirMahasiswa2,
                                        ])
                                    @elseif ($roleDosen == 'Dosen Pembimbing 1' || $roleDosen == 'Dosen Pembimbing 2')
                                        @include('dosen.penilaian.semhas.byDospem.penilaian-byDospem', [
                                            'mainProposal' => $mainProposal,
                                            'nilaiAkhirMahasiswa1' => $nilaiAkhirMahasiswa1,
                                            'nilaiAkhirMahasiswa2' => $nilaiAkhirMahasiswa2,
                                        ])
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
    <script src="{{ asset('/custom-assets/js/penilaian-semhas-penguji.js') }}"></script>
    <script src="{{ asset('/custom-assets/js/penilaian-semhas.js') }}"></script>
@endsection
