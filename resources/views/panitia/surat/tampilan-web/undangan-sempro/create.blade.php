@extends("panitia.home")

@section('page-style')
    <style>
        .required {
            color: #dc3545;
        }

        .btn-container {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin-top: 25px;
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

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .manual-input {
            margin-top: 10px;
            display: none;
        }

        .manual-input .form-control {
            width: 50%;
            margin-bottom: 8px;
        }

        .manual-input small {
            color: #666;
            font-size: 12px;
            display: block;
            margin-top: 4px;
        }

        @media (max-width: 768px) {
            .manual-input .form-control {
                width: 100%;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

@section("content-panitia")
    @if ($errors->any())
        <div>
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
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7">
                    <h1 class="m-0">Input Data Undangan Seminar Proposal</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('panitia.surat.undangan-sempro.preview') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="nomor_surat">Nomor Surat <span class="required"></span></label>
                                    <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                                        placeholder="" value="{{ old('nomor_surat') }}" required>
                                    @error('nomor_surat')
                                        <small class="error-message">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tahap">Tahap <span class="required"></span></label>
                                    <select name="tahap" id="tahap" class="form-control" name="tahap" required>
                                        <option value="">-- Pilih Tahap --</option>
                                        @foreach($daftarTahap as $tahap)
                                            <option value="{{ $tahap->id }}" {{ old('tahap') == $tahap->id ? 'selected' : '' }}>
                                                {{ $tahap->tahap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tahap')
                                        <small class="error-message">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tempat">Tempat <span class="required"></span></label>
                                    <input type="text" class="form-control" id="tempat" name="tempat" placeholder="Opsional"
                                        value="{{ old('tempat') }}">
                                    @error('tempat')
                                        <small class="error-message">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="penandatangan">Penandatangan <span class="required"></span></label>
                                    <select class="form-control" id="penandatangan" name="penandatangan"
                                        onchange="toggleManualInput()" required>
                                        <option value="">-- Pilih Penandatangan --</option>
                                        <option value="Ir. Mohammad Noor Hidayat, S.T., M.Sc., Ph.D.|197409252001121003">Ir.
                                            Mohammad Noor Hidayat, S.T., M.Sc., Ph.D. (197409252001121003)</option>
                                        <option value="manual">+ Tambah</option>
                                    </select>

                                    <div class="manual-input" id="manualInput">
                                        <input type="text" class="form-control" id="nama_manual" name="nama_manual"
                                            placeholder="Masukkan nama lengkap dengan gelar">
                                        <input type="text" class="form-control" id="nip_manual" name="nip_manual"
                                            placeholder="Masukkan NIP">
                                    </div>

                                    @error('penandatangan')
                                        <small class="error-message">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="btn-container">
                                    <button type="submit" class="btn btn-primary">
                                        Preview
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts-panitia")
    <script>
        function toggleManualInput() {
            const select = document.getElementById('penandatangan');
            const manualInput = document.getElementById('manualInput');
            const namaManual = document.getElementById('nama_manual');
            const nipManual = document.getElementById('nip_manual');

            if (select.value === 'manual') {
                manualInput.style.display = 'block';
                namaManual.required = true;
                nipManual.required = true;
            } else {
                manualInput.style.display = 'none';
                namaManual.required = false;
                nipManual.required = false;
                namaManual.value = '';
                nipManual.value = '';
            }
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function (e) {
            const nomorSurat = document.getElementById('nomor_surat').value.trim();
            const select = document.getElementById('penandatangan');
            const namaManual = document.getElementById('nama_manual');
            const nipManual = document.getElementById('nip_manual');

            if (!nomorSurat) {
                e.preventDefault();
                alert('Nomor surat wajib diisi!');
                return false;
            }

            if (select.value === 'manual') {
                if (!namaManual.value.trim() || !nipManual.value.trim()) {
                    e.preventDefault();
                    alert('Mohon lengkapi nama dan NIP penandatangan');
                    return false;
                }
            } else if (select.value === '') {
                e.preventDefault();
                alert('Mohon pilih penandatangan');
                return false;
            }
        });
    </script>
@endsection