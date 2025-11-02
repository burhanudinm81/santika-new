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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />
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
                    <h1 class="m-0">Daftar Dosen Pembimbing Mahasiswa</h1>
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
                            <form action="{{ route('panitia.surat.daftar-dosen-pembimbing-mahasiswa.preview') }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="dosen">Pilih Dosen Pembimbing<span class="required"></span></label>
                                    <select name="dosen" id="dosen" class="form-control" name="dosen" required>
                                        <option value="">-- Pilih Dosen Pembimbing --</option>
                                        @foreach($daftarDosen as $dosen)
                                            <option value="{{ $dosen->id }}" {{ old('dosen') == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dosen')
                                        <small class="error-message">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="btn-container">
                                    <a href="{{ url('/') }}" class="btn btn-secondary text-decoration-none"
                                        style="text-decoration:none !important;">Kembali</a>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#dosen").select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: '-- Pilih Dosen --',
                allowClear: true
            });
        });
    </script>
@endsection