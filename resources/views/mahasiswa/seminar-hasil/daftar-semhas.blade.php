@extends('mahasiswa.home')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pendaftaran Sidang Laporan Akhir</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">

                <div class="card card-primary card-outline mb-4">
                    <!--begin::Form-->
                    <form>
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="exampleDataList" class="form-label">Dosen Pembimbing 1</label>
                                <input class="form-control" list="datalistOptions" id="exampleDataList"
                                    placeholder="Pilih Dosen Pembimbing 1" value="{{ $infoDospem1->nama }}" readonly>

                            </div>
                            <div class="mb-3">
                                <label for="exampleDataList" class="form-label">Dosen Pembimbing 2</label>
                                <input class="form-control" list="datalistOptions" id="exampleDataList"
                                    placeholder="Pilih Dosen Pembimbing 2" value="{{ $infoDospem2->nama }}" readonly>

                            </div>

                            {{--  --}}
                            @if ($infoProposal->prodi_id == 1)
                                <div class="mb-3">
                                    <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa 1</label>
                                    <input value="{{ $infoMahasiswaAll[0]->mahasiswa->nama }}" type="text"
                                        class="form-control" id="NamaMahasiswa" aria-describedby="NamaMahasiswa" readonly />
                                </div>
                                <div class="mb-3">
                                    <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa 2</label>
                                    <input value="{{ $infoMahasiswaAll[1]->mahasiswa->nama }}" type="text"
                                        class="form-control" id="NamaMahasiswa" aria-describedby="NamaMahasiswa" readonly />
                                </div>
                            @elseif ($infoProposal->prodi_id == 2)
                                <div class="mb-3">
                                    <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="NamaMahasiswa"
                                        aria-describedby="NamaMahasiswa" value="{{ $infoMahasiswaAll->first()->mahasiswa->nama }}" readonly />
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="JudulProposal" class="form-label">Judul Proposal</label>
                                <input type="text" class="form-control" id="JudulProposal"
                                    aria-describedby="JudulProposal" value="{{ $infoProposal->judul }}" readonly />
                            </div>
                            <div class="mb-3">
                                <label for="exampleDataList" class="form-label">Bidang Keahlihan</label>
                                <input class="form-control" list="datalistkeahlihanOptions" id="exampleDataList"
                                    placeholder="Pilih Bidang Keahlihan" value="{{ $infoProposal->bidangMinat->bidang_minat }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Surat Rekomendasi Pembimbing .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">File Proposal .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Draft Jurnal .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Surat IA Mitra .pdf (Judul Mitra)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Surat Bebas Tanggungan PKL .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Surat Keterangan Lulus Akademik (SKLA) .pdf</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Status Pendaftaran</label>
                                <select class="form-control select2bs4" id="status" disabled="disabled"
                                    style="width: 100%">
                                    <option selected="selected">Pending</option>
                                    <option>Diterima</option>
                                    <option>Ditolak</option>
                                </select>
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

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
