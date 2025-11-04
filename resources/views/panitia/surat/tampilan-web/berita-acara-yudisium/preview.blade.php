@extends("panitia.home")

@section('page-style')
    <style>
        .iframe-container {
            width: 100%;
            height: 650px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            background-color: white;
            overflow: hidden;
        }

        .iframe-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease-in-out;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .iframe-container {
                height: 500px;
            }

            .action-bar {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content-panitia')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Preview Berita Acara Yudisium</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Berita Acara Yudisium</h3>
                        </div>
                        <div class="card-body">
                            <div class="iframe-container">
                                <iframe src="{{ route('panitia.surat.berita-acara-yudisium.surat.preview', [
        'nomor_surat' => $data['nomor_surat'],
        'tahap' => $data['tahap']->id,
        'periode' => $data['periode']->id,
        'semester' => $data['semester'],
        'nama_penandatangan' => $data['nama_penandatangan'],
        'nip_penandatangan' => $data['nip_penandatangan'],
        'tanggal_tanda_tangan' => $data['tanggal_tanda_tangan']
    ]) }}" frameborder="0">
                                </iframe>
                            </div>

                            <div class="action-bar">
                                <a href="{{ route('panitia.surat.berita-acara-yudisium.surat.download', [
        'nomor_surat' => $data['nomor_surat'],
        'tahap' => $data['tahap']->id,
        'semester' => $data['semester'],
        'nama_penandatangan' => $data['nama_penandatangan'],
        'nip_penandatangan' => $data['nip_penandatangan'],
        'tanggal_tanda_tangan' => $data['tanggal_tanda_tangan']
    ]) }}" class="btn btn-primary">
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lampiran Berita Acara Yudisium</h3>
                        </div>
                        <div class="card-body">
                            <div class="iframe-container">
                                <iframe src="{{ route('panitia.surat.berita-acara-yudisium.lampiran.preview', [
        'tanggal_yudisium' => $data['tanggal_yudisium'],
        'tahap' => $data['tahap']->id,
        'nama_penandatangan' => $data['nama_penandatangan'],
        'nip_penandatangan' => $data['nip_penandatangan'],
        'tanggal_tanda_tangan' => $data['tanggal_tanda_tangan']
    ]) }}" frameborder="0">
                                </iframe>
                            </div>

                            <div class="action-bar">
                                <a href="{{ route('panitia.surat.berita-acara-yudisium.lampiran.download', [
        'nomor_surat' => $data['nomor_surat'],
        'tahap' => $data['tahap']->id,
        'periode' => $data['periode']->id,
        'semester' => $data['semester'],
        'nama_penandatangan' => $data['nama_penandatangan'],
        'nip_penandatangan' => $data['nip_penandatangan'],
        'tanggal_tanda_tangan' => $data['tanggal_tanda_tangan']
    ]) }}" class="btn btn-primary">
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <a href="{{ route('panitia.surat.berita-acara-yudisium.create') }}" class="btn btn-info">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts-panitia')
    <script>
        // Refresh iframe otomatis sekali setelah load (jika ingin auto sync data)
        setTimeout(function () {
            const iframe = document.querySelector('iframe');
            if (iframe) iframe.src = iframe.src;
        }, 1500);
    </script>
@endsection