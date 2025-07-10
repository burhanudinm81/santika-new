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
                                    placeholder="Pilih Dosen Pembimbing 1">
                                <datalist id="datalistOptions">
                                    <option value="AHMAD WILDA YULIANTO, S.T., M.T.">
                                    <option value="AMALIA EKA RAKHMANIA, S.T, M.T., M.Sc.">
                                    <option value="DIANTHY MARYA, S.T, M.T.">
                                    <option value="Dr. Ir. AZAM MUZAKHIM IMAMMUDDIN, M.T.">
                                    <option value="Dr. MOCHAMMAD JUNUS, S.T., M.T. ">
                                    <option value="Drs. YOYOK HERU PRASETYO ISNOMO, M.T ">
                                    <option value="Dr. FARIDA ARINIE SOELISTIANTO, S.T., M.T.">
                                    <option value="HADIWIYATNO, S.T., M.T.">
                                    <option value="HENDRO DARMONO, B.ENG., M.T.">
                                    <option value="Ir. ABDUL RASYID, M.T.">
                                    <option value="Ir. HUDIONO, M.T.">
                                    <option value="Ir. MARTONO DWI ATMADJA, M.MT.">
                                    <option value="Ir. MOH. ABDULLAH ANSHORI, M.MT.">
                                    <option value="Ir. NUGROHO SUHARTO, M.T.">
                                    <option value="Ir. WALUYO, M.T.">
                                    <option value="KOESMARIJANTO, S.T., M.T.">
                                    <option value="LIS DIANA MUSTAFA, S.T., M.T.">
                                    <option value="M. NANAK ZAKARIA, S.T., M.T.">
                                    <option value="MILA KUSUMAWARDANI, S.T., M.T.">
                                    <option value="MUHAMMAD SYIRAJUDDIN S., S.T., M.T">
                                    <option value="NURUL HIDAYATI, S.T., M.T.">
                                    <option value="Prof. Dr. MOECHAMMAD SAROSA, DIPL.ING.,M.T.">
                                    <option value="PUTRI ELFA MAS'UDIA, S.T., M.CS.">
                                    <option value="RACHMAD SAPTONO, S.T., M.T.">
                                    <option value="RIEKE ADRIATI WIJAYANTI, S.T., M.T.">
                                    <option value="Ir. SRI WAHYUNI DALI, S.T., M.T.">
                                    <option value="RIZKY ARDIANSYAH, S.KOM., M.T.">
                                    <option value="ADZIKIRANI, S.S.T., M.Tr.T.">
                                    <option value="ISA MAHFUDI, S.S.T., M.Tr.T">
                                    <option value="GALIH PUTRA RIATMA, S.ST., M.T.">
                                    <option value="ATIK NOVIANTI, S.ST., M.T.">
                                    <option value="GINANJAR SUWASONO ADI, S.ST., M.Sc.">
                                    <option value="DODIT SUPRIANTO, S.KOM., M.T.">
                                    <option value="CHANDRASENA SETIADI, S.T., M.Tr.T.">
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="exampleDataList" class="form-label">Dosen Pembimbing 2</label>
                                <input class="form-control" list="datalistOptions" id="exampleDataList"
                                    placeholder="Pilih Dosen Pembimbing 2">
                                <datalist id="datalistOptions">
                                    <option value="AHMAD WILDA YULIANTO, S.T., M.T.">
                                    <option value="AMALIA EKA RAKHMANIA, S.T, M.T., M.Sc.">
                                    <option value="DIANTHY MARYA, S.T, M.T.">
                                    <option value="Dr. Ir. AZAM MUZAKHIM IMAMMUDDIN, M.T.">
                                    <option value="Dr. MOCHAMMAD JUNUS, S.T., M.T. ">
                                    <option value="Drs. YOYOK HERU PRASETYO ISNOMO, M.T ">
                                    <option value="Dr. FARIDA ARINIE SOELISTIANTO, S.T., M.T.">
                                    <option value="HADIWIYATNO, S.T., M.T.">
                                    <option value="HENDRO DARMONO, B.ENG., M.T.">
                                    <option value="Ir. ABDUL RASYID, M.T.">
                                    <option value="Ir. HUDIONO, M.T.">
                                    <option value="Ir. MARTONO DWI ATMADJA, M.MT.">
                                    <option value="Ir. MOH. ABDULLAH ANSHORI, M.MT.">
                                    <option value="Ir. NUGROHO SUHARTO, M.T.">
                                    <option value="Ir. WALUYO, M.T.">
                                    <option value="KOESMARIJANTO, S.T., M.T.">
                                    <option value="LIS DIANA MUSTAFA, S.T., M.T.">
                                    <option value="M. NANAK ZAKARIA, S.T., M.T.">
                                    <option value="MILA KUSUMAWARDANI, S.T., M.T.">
                                    <option value="MUHAMMAD SYIRAJUDDIN S., S.T., M.T">
                                    <option value="NURUL HIDAYATI, S.T., M.T.">
                                    <option value="Prof. Dr. MOECHAMMAD SAROSA, DIPL.ING.,M.T.">
                                    <option value="PUTRI ELFA MAS'UDIA, S.T., M.CS.">
                                    <option value="RACHMAD SAPTONO, S.T., M.T.">
                                    <option value="RIEKE ADRIATI WIJAYANTI, S.T., M.T.">
                                    <option value="Ir. SRI WAHYUNI DALI, S.T., M.T.">
                                    <option value="RIZKY ARDIANSYAH, S.KOM., M.T.">
                                    <option value="ADZIKIRANI, S.S.T., M.Tr.T.">
                                    <option value="ISA MAHFUDI, S.S.T., M.Tr.T">
                                    <option value="GALIH PUTRA RIATMA, S.ST., M.T.">
                                    <option value="ATIK NOVIANTI, S.ST., M.T.">
                                    <option value="GINANJAR SUWASONO ADI, S.ST., M.Sc.">
                                    <option value="DODIT SUPRIANTO, S.KOM., M.T.">
                                    <option value="CHANDRASENA SETIADI, S.T., M.Tr.T.">
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="NamaMahasiswa" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="NamaMahasiswa"
                                    aria-describedby="NamaMahasiswa" />
                            </div>
                            <div class="mb-3">
                                <label for="JudulProposal" class="form-label">Judul Proposal</label>
                                <input type="text" class="form-control" id="JudulProposal"
                                    aria-describedby="JudulProposal" />
                            </div>
                            <div class="mb-3">
                                <label for="exampleDataList" class="form-label">Bidang Keahlihan</label>
                                <input class="form-control" list="datalistkeahlihanOptions" id="exampleDataList"
                                    placeholder="Pilih Bidang Keahlihan">
                                <datalist id="datalistkeahlihanOptions">
                                    <option value="WSN, IOT, Teknologi Pintar">
                                    <option value="Protokol, Media dan Teori Komunikasi">
                                    <option value="Management dan Keamanan Jaringan">
                                </datalist>
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
