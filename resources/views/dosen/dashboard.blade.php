@extends('dosen.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach ($dataChart as $chart)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header text-center fw-bold d-flex justify-content-between align-items-center">
                                <span>{{ $chart['prodi'] }}</span>
                                <span class="badge rounded-pill bg-light text-dark border">
                                    {{ $chart['totalMahasiswa'] }} Mahasiswa
                                </span>
                            </div>
                            <div class="card-body">
                                <canvas id="chartProdi_{{ $chart['slug'] }}"></canvas>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    @foreach ($dataChart as $chart)
                        let ctx_{{ $chart['slug'] }} = document.getElementById(
                            "chartProdi_{{ $chart['slug'] }}");
                        if (ctx_{{ $chart['slug'] }}) {
                            new Chart(ctx_{{ $chart['slug'] }}, {
                                type: 'pie',
                                data: {
                                    labels: ['Belum Sempro', 'Sudah Sempro', 'Belum Sidang', 'Sudah Sidang'],
                                    datasets: [{
                                        data: [
                                            {{ $chart['sempro']['belum'] }},
                                            {{ $chart['sempro']['sudah'] }},
                                            {{ $chart['sidang']['belum'] }},
                                            {{ $chart['sidang']['sudah'] }}
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.7)',
                                            'rgba(75, 192, 192, 0.7)',
                                            'rgba(255, 205, 86, 0.7)',
                                            'rgba(54, 162, 235, 0.7)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(255, 205, 86, 1)',
                                            'rgba(54, 162, 235, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                }
                            });
                        }
                    @endforeach
                });
            </script>

            @if ($notifikasi->count() > 0)
                <!-- Tabel Riwayat Pengajuan Judul -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-bell me-2"></i> Notifikasi</h5>
                            </div>
                            <div class="card-body">
                                @if ($notifikasi->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-stripped align-middle">
                                            <tbody>
                                                @foreach ($notifikasi as $index => $item)
                                                    <tr>
                                                        <td>
                                                            {!! $item->keterangan !!} <br>
                                                            <small class="text-secondary">
                                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}
                                                            </small>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted mb-0">Belum ada notifikasi.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
