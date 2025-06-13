<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pendaftaran Seminar Proposal</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-15">
            @if (is_null($pesertaTugasAkhir))
                <p class="alert alert-danger">Anda Belum Mempunyai Pengajuan Judul Yang Sudah Disetujui</p>
            @else
                <div class="card card-primary card-outline mb-4">
                    <!--begin::Form-->
                    <form id="form-daftar-sempro" action="{{ route("mahasiswa.seminar-proposal.daftar") }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_peserta_tugas_akhir" value="{{ $pesertaTugasAkhir->id }}" readonly />
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="exampleDataList" class="form-label">Dosen Pembimbing 1</label>
                                <input class="form-control" id="exampleDataList" name="dosen_pembimbing_1"
                                    value="{{ $pesertaTugasAkhir->dosenPembimbing1->nama }}" readonly>
                            </div>
                            @if (auth("mahasiswa")->user()->prodi == App\Enum\Prodi::D3TT)
                                <div class="mb-3">
                                    <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa 1</label>
                                    <input type="text" class="form-control" id="NamaMahasiswa" name="mahasiswa_1"
                                        aria-describedby="NamaMahasiswa" value="{{ $pesertaTugasAkhir->mahasiswa1->nama }}"
                                        readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa 2</label>
                                    <input type="text" class="form-control" id="NamaMahasiswa" name="mahasiswa_2"
                                        aria-describedby="NamaMahasiswa" value="{{ $pesertaTugasAkhir->mahasiswa2->nama }}"
                                        readonly />
                                </div>
                            @elseif (auth("mahasiswa")->user()->prodi == App\Enum\Prodi::D4JTD)
                                <div class="mb-3">
                                    <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="NamaMahasiswa" name="mahasiswa_1"
                                        aria-describedby="NamaMahasiswa" value="{{ $pesertaTugasAkhir->mahasiswa1->nama }}"
                                        readonly />
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="JudulProposal" class="form-label">Judul Proposal</label>
                                <input type="text" class="form-control" id="JudulProposal" aria-describedby="JudulProposal"
                                    name="judul_proposal" value="{{ $pesertaTugasAkhir->pengajuanJudul->judul }}"
                                    readonly />
                                <input type="hidden" name="id_pengajuan_judul"
                                    value="{{ $pesertaTugasAkhir->pengajuanJudul->id }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="exampleDataList" class="form-label">Bidang Keahlihan</label>
                                <input type="text" class="form-control" id="exampleDataList" name="bidang"
                                    value="{{ $pesertaTugasAkhir->pengajuanJudul->bidang }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">File Proposal .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="proposal"
                                            accept="application/pdf" required>
                                        <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Lembar Konsultasi .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile"
                                            name="lembar_konsultasi" accept="application/pdf" required>
                                        <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Lembar Kerjasama Mitra .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile"
                                            name="lembar_kerja_sama_mitra" accept="application/pdf" required>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Bukti Cek Plagiasi (.jpg, .jpeg, .png)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile"
                                            name="bukti_cek_plagiasi" accept="image/jpeg,image/jpg,image/png" required>
                                        <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                        <!--end::Footer-->
                    </form>
                    <!--end::Form-->
                </div>
            @endif


        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{{ url("/custom/js/animate-custom-file-input.js") }}"></script>
<script src="{{ url("/custom/js/seminar-proposal/pendaftaran.js") }}"></script>