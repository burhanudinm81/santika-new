@extends('panitia.home')

@section('content-panitia')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Nilai Akhir</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content my-5">
        <div class="container-fluid">
            @if (session('success'))
                @include('notifications.success-alert', ['message' => session('success')])
            @endif

            <form action="{{ route('panitia.seminar-hasil.update-nilai', $nilaiAkhir->id) }}" method="POST">
                <div class="row">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pembimbing 1 - {{ $proposalInfo->dosenPembimbing1->nama }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Kriteria Penilaian</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">1.</td>
                                            <td class="align-middle">Sikap</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_sikap_pemb1" value="{{ $nilaiAkhir->nilai_sikap_pemb1 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">2.</td>
                                            <td class="align-middle">Kemampuan</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_kemampuan_pemb1"
                                                    value="{{ $nilaiAkhir->nilai_kemampuan_pemb1 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">3.</td>
                                            <td class="align-middle">Hasil Karya</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_hasilKarya_pemb1"
                                                    value="{{ $nilaiAkhir->nilai_hasilKarya_pemb1 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">4.</td>
                                            <td class="align-middle">Laporan</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_laporan_pemb1"
                                                    value="{{ $nilaiAkhir->nilai_laporan_pemb1 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">Rata-Rata</td>
                                            <td class="align-middle">
                                                <span id="avg_pemb1">{{ round($nilaiAkhir->avg_nilai_dospem1, 2) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pembimbing 2 - {{ $proposalInfo->dosenPembimbing2->nama }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Kriteria Penilaian</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">1.</td>
                                            <td class="align-middle">Sikap</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_sikap_pemb2" value="{{ $nilaiAkhir->nilai_sikap_pemb2 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">2.</td>
                                            <td class="align-middle">Kemampuan</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_kemampuan_pemb2"
                                                    value="{{ $nilaiAkhir->nilai_kemampuan_pemb2 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">3.</td>
                                            <td class="align-middle">Hasil Karya</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_hasilKarya_pemb2"
                                                    value="{{ $nilaiAkhir->nilai_hasilKarya_pemb2 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">4.</td>
                                            <td class="align-middle">Laporan</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_laporan_pemb2"
                                                    value="{{ $nilaiAkhir->nilai_laporan_pemb2 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">Rata-Rata</td>
                                            <td class="align-middle">
                                                <span id="avg_pemb2">{{ round($nilaiAkhir->avg_nilai_dospem2, 2) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Penguji 1 - {{ $proposalInfo->dosenPengujiSidangTA1->nama }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Kriteria Penilaian</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">1.</td>
                                            <td class="align-middle">Penguasaan Materi</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_penguasaan_materi1"
                                                    value="{{ $nilaiAkhir->nilai_penguasaan_materi1 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">2.</td>
                                            <td class="align-middle">Presentasi</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_presentasi1"
                                                    value="{{ $nilaiAkhir->nilai_presentasi1 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">3.</td>
                                            <td class="align-middle">Karya Tulis</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_karya_tulis1"
                                                    value="{{ $nilaiAkhir->nilai_karya_tulis1 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">Rata-Rata</td>
                                            <td class="align-middle">
                                                <span
                                                    id="avg_penguji1">{{ round($nilaiAkhir->avg_nilai_penguji1, 2) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Penguji 2 - {{ $proposalInfo->dosenPengujiSidangTA2->nama }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Kriteria Penilaian</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle">1.</td>
                                            <td class="align-middle">Penguasaan Materi</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_penguasaan_materi2"
                                                    value="{{ $nilaiAkhir->nilai_penguasaan_materi2 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">2.</td>
                                            <td class="align-middle">Presentasi</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_presentasi2"
                                                    value="{{ $nilaiAkhir->nilai_presentasi2 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle">3.</td>
                                            <td class="align-middle">Karya Tulis</td>
                                            <td class="align-middle">
                                                <input type="number" class="form-control" step="0.01"
                                                    name="nilai_karya_tulis2"
                                                    value="{{ $nilaiAkhir->nilai_karya_tulis2 }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">Rata-Rata</td>
                                            <td class="align-middle">
                                                <span
                                                    id="avg_penguji2">{{ round($nilaiAkhir->avg_nilai_penguji2, 2) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nilai Total Pembimbing</th>
                                <td><span id="avg_total_dospem">{{ round($nilaiAkhir->avg_nilai_totalDospem, 2) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nilai Total Penguji</th>
                                <td><span
                                        id="avg_total_penguji">{{ round($nilaiAkhir->avg_nilai_totalPenguji, 2) }}</span>
                                </td>
                            </tr>
                            <tr class="table-info">
                                <th>Nilai Total (60% Pembimbing + 40% Penguji)</th>
                                <td><span
                                        id="avg_total">{{ round($nilaiAkhir->avg_nilai_totalDospem * 0.6 + $nilaiAkhir->avg_nilai_totalPenguji * 0.4, 2) }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
    </div>
@endsection

@section('scripts-panitia')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function hitungRata(selector) {
                const inputs = document.querySelectorAll(selector);
                let total = 0,
                    count = 0;

                inputs.forEach(input => {
                    let val = parseFloat(input.value);
                    if (!isNaN(val)) {
                        total += val;
                        count++;
                    }
                });

                return count > 0 ? total / count : 0;
            }

            function updateRata() {
                const pemb1 = hitungRata('input[name^="nilai_"][name$="_pemb1"]');
                const pemb2 = hitungRata('input[name^="nilai_"][name$="_pemb2"]');
                const penguji1 = hitungRata('input[name^="nilai_"][name$="1"]');
                const penguji2 = hitungRata('input[name^="nilai_"][name$="2"]');

                document.querySelector('#avg_pemb1').textContent = pemb1.toFixed(2);
                document.querySelector('#avg_pemb2').textContent = pemb2.toFixed(2);
                document.querySelector('#avg_penguji1').textContent = penguji1.toFixed(2);
                document.querySelector('#avg_penguji2').textContent = penguji2.toFixed(2);

                const totalDospem = (pemb1 + pemb2) / 2;
                const totalPenguji = (penguji1 + penguji2) / 2;

                document.querySelector('#avg_total_dospem').textContent = totalDospem.toFixed(2);
                document.querySelector('#avg_total_penguji').textContent = totalPenguji.toFixed(2);

                const totalAkhir = (totalDospem * 0.6) + (totalPenguji * 0.4);
                document.querySelector('#avg_total').textContent = totalAkhir.toFixed(2);
            }

            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', updateRata);
            });

            updateRata();
        });
    </script>
@endsection
