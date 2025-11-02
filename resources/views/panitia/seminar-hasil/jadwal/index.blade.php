@extends('panitia.home')

@section('content-panitia')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Jadwal Sidang Ujian Akhir Prodi {{ $prodi->prodi }}</h1>
                </div>
            </div>
        </div>
    </div>
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
    @if ($errors->any())
        <div>
            {{-- modal popup error --}}
            <div style="
                                                            position: fixed;
                                                            top: 30px;
                                                            left: 60%;
                                                            transform: translateX(-50%);
                                                            z-index: 1050;
                                                            width: 50%;
                                                            transition: all 0.2s ease-in-out;
                                                        "
                class="bg-white border-bottom-0 border-right-0 border-left-0 py-4 border-danger shadow shadow-md mx-auto alert alert-dismissible fade show relative"
                role="alert">
                <strong class="text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="my-2 ml-2" style="width: 300px;">
                    <div class="input-group">
                        <select class="custom-select" id="periode_id" aria-label="Example select with button addon">
                            <option disabled selected>Pilih Periode</option>
                            @foreach ($listPeriode as $periode)
                                <option value="{{ $periode->id }}" {{ $periodeTerpilih->id == $periode->id ? 'selected' : '' }}>
                                    {{ $periode->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card-body table-responsive p-0">
                    <table id="tabel-proposal" class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahap</th>
                                <th>Periode</th>
                                <th>Jumlah Peserta</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(is_null($pasangan) || $pasangan->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data jadwal seminar proposal</td>
                                </tr>
                            @else
                                @foreach ($pasangan as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('panitia.jadwal-sidang-akhir.detail', ['tahap_id' => $item['tahap_id'], 'periode_id' => $item['periode_id']]) }}">
                                                {{ $item['tahap'] }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('panitia.jadwal-sidang-akhir.detail', ['tahap_id' => $item['tahap_id'], 'periode_id' => $item['periode_id']]) }}">
                                                {{ $item['periode'] }}
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('panitia.jadwal-sidang-akhir.detail', ['tahap_id' => $item['tahap_id'], 'periode_id' => $item['periode_id']]) }}">
                                                {{ $item['jumlah_peserta'] }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('panitia.jadwal-sidang-akhir.edit', ["periode" => $item['periode_id'], "tahap" => $item['tahap_id']]) }}"
                                                class="btn btn-success">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <a href="{{ route('panitia.jadwal-sidang-akhir.create') }}" class="btn btn-success">Generate Jadwal Otomatis</a>
                    <a href="{{ route('panitia.jadwal-sidang-akhir.create-manual') }}" class="btn btn-primary">Buat Jadwal Manual</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts-panitia')
    <script>
        $(document).ready(function () {
            $('#periode_id').on('change', function () {
                var selectedPeriodeId = $(this).val();
                if (selectedPeriodeId) {
                    window.location.href = '/panitia/jadwal-sidang-akhir/periode/' + selectedPeriodeId;
                }
            });
        });
    </script>
@endsection