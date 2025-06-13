<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pengajuan Judul Mandiri</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-15">

            <div class="card card-primary card-outline mb-4">
                <!--begin::Form-->
                <form action="{{ route("mahasiswa.pengajuan-judul.store") }}" method="post" id="form-pengajuan-judul">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        @if (auth("mahasiswa")->user()->prodi == App\Enum\Prodi::D3TT)
                            <div class="mb-3">
                                <label for="nama-mahasiswa-1" class="form-label">Nama Mahasiswa 1</label>
                                <input type="text" class="form-control" id="nama-mahasiswa-1" name="nama_mahasiswa_1"
                                    aria-describedby="Nama Mahasiswa 1" value="{{ auth("mahasiswa")->user()->nama }}"
                                    readonly />
                            </div>

                            <div class="mb-3">
                                <label for="nim-mahasiswa-1" class="form-label">NIM Mahasiswa 1</label>
                                <input type="text" class="form-control" id="nim-mahasiswa-1" name="nim_mahasiswa_1"
                                    aria-describedby="NIM Mahasiswa 1" value="{{ auth("mahasiswa")->user()->NIM }}"
                                    readonly />
                            </div>

                            <div class="mb-3">
                                <label for="nama-mahasiswa-2" class="form-label">Nama Mahasiswa 2</label>
                                <input type="text" class="form-control" id="nama-mahasiswa-2" name="nama_mahasiswa_2"
                                    aria-describedby="Nama Mahasiswa 2" />
                            </div>

                            <div class="mb-3">
                                <label for="nim-mahasiswa-2" class="form-label">NIM Mahasiswa 2</label>
                                <input type="text" class="form-control" id="nim-mahasiswa-2" name="nim_mahasiswa_2"
                                    aria-describedby="NIM Mahasiswa 2" />
                            </div>

                        @elseif(auth("mahasiswa")->user()->prodi == App\Enum\Prodi::D4JTD)
                            <div class="mb-3">
                                <label for="nama-mahasiswa-1" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama-mahasiswa-1" name="nama_mahasiswa_1"
                                    aria-describedby="Nama Mahasiswa 1" value="{{ auth("mahasiswa")->user()->nama }}"
                                    readonly />
                            </div>

                            <div class="mb-3">
                                <label for="nim-mahasiswa-1" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim-mahasiswa-1" name="nim_mahasiswa_1"
                                    aria-describedby="NIM Mahasiswa 1" value="{{ auth("mahasiswa")->user()->NIM }}"
                                    readonly />
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="jenis-judul" class="form-label">Jenis Judul</label>
                            <select class="custom-select" id="jenis-judul" name="jenis_judul" required>
                                <option value="-">-</option>
                                <option value="{{ App\Enum\JenisJudul::MANDIRI }}">
                                    {{ App\Enum\JenisJudul::MANDIRI  }}
                                </option>
                                <option value="{{ App\Enum\JenisJudul::MITRA }}">{{ App\Enum\JenisJudul::MITRA  }}
                                </option>
                                <option value="{{ App\Enum\JenisJudul::REKOMENDASI }}">
                                    {{ App\Enum\JenisJudul::REKOMENDASI  }}
                                </option>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="bidang-keahlian" class="form-label">Bidang</label>
                            <select class="custom-select" id="bidang" name="bidang" required>
                                <option value="-">-</option>
                                <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}">
                                    {{ App\Enum\BidangMinat::BIDANG_MINAT_1  }}
                                </option>
                                <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}">
                                    {{ App\Enum\BidangMinat::BIDANG_MINAT_2  }}
                                </option>
                                <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}">
                                    {{ App\Enum\BidangMinat::BIDANG_MINAT_3  }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="calon-dosen-pembimbing-1" class="form-label">Calon Dosen Pembimbing
                                1</label>
                            <select class="custom-select" id="calon-dosen-pembimbing-1" name="calon_dosen_pembimbing_1"
                                required>
                                <option value="-">-</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="topik" class="form-label">Topik/Tema Proposal</label>
                            <input type="text" class="form-control" id="topik" name="topik"
                                aria-describedby="Topik/Tema Proposal" required />
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Proposal</label>
                            <input type="text" class="form-control" id="judul" name="judul"
                                aria-describedby="JudulProposal" required />
                        </div>
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan Proposal</label>
                            <textarea class="form-control" id="tujuan" name="tujuan" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="latar-belakang" class="form-label">Latar Belakang</label>
                            <textarea class="form-control" id="latar-belakang" name="latar_belakang" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="blok-diagram">Blok Diagram Sistem</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="blok-diagram" name="blok_diagram"
                                        required>
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                Tipe file JPG, JPEG, PNG. Ukuran file maksimal 2 MB
                            </small>
                        </div>

                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Ajukan</button>
                        </div>
                        <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>

        </div><!-- /.container-fluid -->
    </div>
</div>

@if ($menungguDikonfirmasi)
    <script>
        $("#modal-popup-error .modal-body").text("Anda Tidak Bisa Mengajukan Judul Karena Anda Memiliki Judul Yang Belum Dikonfirmasi!");
        $("#modal-popup-error").modal();

        $("#modal-popup-error").on("hidden.bs.modal", function(){
            $(".content-wrapper").load("/mahasiswa/pengajuan-judul/riwayat");
        })
    </script>
@endif

<script src="{{ url("/custom/js/animate-custom-file-input.js") }}"></script>
<script src="{{ url("/custom/js/pengajuan-judul.js") }}"></script>