<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row justify-content-between mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Pendaftaran Sempro</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route("mahasiswa.seminar-proposal.riwayat") }}" class="btn btn-primary back-btn">Back</a>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline mb-4">
                    <div class="list-group-item mb-3">
                        <label class="form-label mb-1">Dosen Pembimbing 1</label>
                        <p>{{ $pendaftaranSempro->pesertaTugasAkhir->dosenPembimbing1->nama }}</p>

                        <label class="form-label mb-1">Nama Mahasiswa</label>
                        <p>{{ $pendaftaranSempro->pesertaTugasAkhir->mahasiswa1->nama }}</p>

                        <label class="form-label mb-1">Jenis Judul</label>
                        <p>{{ $pendaftaranSempro->pesertaTugasAkhir->pengajuanJudul->jenis_judul }}</p>

                        <label class="form-label mb-1">Judul Proposal</label>
                        <p>{{ $pendaftaranSempro->pesertaTugasAkhir->pengajuanJudul->judul }}</p>

                        <label class="form-label mb-1">Bidang Keahlihan</label>
                        <p>{{ $pendaftaranSempro->pesertaTugasAkhir->pengajuanJudul->bidang }}</p>

                        <label class="form-label mb-1">File Proposal</label>
                        <object
                            data="{{ "/seminar-proposal/pendaftaran/proposal/$pendaftaranSempro->id/$pendaftaranSempro->file_proposal"}}"
                            type="application/pdf" width="100%" height="600px">
                            <p>Browser anda tidak mendukung embed PDF. Anda bisa mengklik <a
                                    href="{{ "/seminar-proposal/pendaftaran/proposal/$pendaftaranSempro->id/$pendaftaranSempro->file_proposal"}}">Mengunduh
                                    File
                                    PDF</a> Sebagai gantinya</p>
                        </object>

                        <label class="form-label mb-1">Lembar Konsultasi</label>
                        <object
                            data="{{ "/seminar-proposal/pendaftaran/lembar-konsultasi/$pendaftaranSempro->id/$pendaftaranSempro->lembar_konsultasi"}}"
                            type="application/pdf" width="100%" height="600px">
                            <p>Browser anda tidak mendukung embed PDF. Anda bisa mengklik <a
                                    href="{{ "/seminar-proposal/pendaftaran/lembar-konsultasi/$pendaftaranSempro->id/$pendaftaranSempro->lembar_konsultasi"}}">Mengunduh
                                    File PDF</a> Sebagai gantinya</p>
                        </object>

                        <label class="form-label mb-1">Lembar Kerjasama Mitra</label>
                        <object
                            data="{{ "/seminar-proposal/pendaftaran/lembar-kerja-sama-mitra/$pendaftaranSempro->id/$pendaftaranSempro->lembar_kerja_sama_mitra"}}"
                            type="application/pdf" width="100%" height="600px">
                            <p>Browser anda tidak mendukung embed PDF. Anda bisa mengklik <a
                                    href="{{ "/seminar-proposal/pendaftaran/lembar-kerja-sama-mitra/$pendaftaranSempro->id/$pendaftaranSempro->lembar_kerja_sama_mitra"}}">Mengunduh
                                    File PDF</a> Sebagai gantinya</p>
                        </object>

                        <label class="form-label mb-1">Bukti Cek Plagiasi</label>
                        <img class="img-fluid"
                            src="{{ url("/seminar-proposal/pendaftaran/bukti-cek-plagiasi/$pendaftaranSempro->id/$pendaftaranSempro->bukti_cek_plagiasi")}}"
                            alt="bukti-cek-plagiasi">

                        <div class="mb-3">
                            <label for="exampleDataList" class="form-label">Status Pendaftaran Sempro</label>
                            <p class="alert alert-info">-</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
<script src="{{ url("/custom/js/back-to-previous-page.js") }}"></script>