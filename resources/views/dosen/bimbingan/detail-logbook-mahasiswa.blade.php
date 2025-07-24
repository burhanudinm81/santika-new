@extends('dosen.home')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Logbook</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-15">
                <div class="card card-primary card-outline mb-2">
                    <!--begin::Form-->
                    <form>
                        <!--begin::Body-->
                        <div class="card-body">
                            <p class="h4">Logbook 1</p>
                            <hr>
                            <strong></i>Nama Mahasiswa 1</strong>
                            <p class="text-muted">
                                Dwiki Raditya Krisdyanto
                            </p>
                            <strong></i>Nama Mahasiswa 2</strong>
                            <p class="text-muted">
                                Adam Varon
                            </p>
                            <strong></i>Jenis Kegiatan</strong>
                            <p class="text-muted">
                                Eksperimen
                            </p>
                            <strong></i>Nama Kegiatan</strong>
                            <p class="text-muted">
                                Doing something
                            </p>
                            <strong></i>Tanggal/Waktu</strong>
                            <p class="text-muted">
                                22-03-2025/ 10.25
                            </p>
                            <strong></i>Hasil Kegiatan</strong>
                            <p class="text-muted">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet vitae saepe facilis
                                aspernatur
                                culpa doloremque expedita dignissimos! Natus animi repudiandae nam commodi? Ullam
                                consequatur
                                molestiae illo delectus, praesentium nulla quaerat.
                            </p>

                            <div class="mb-3">
                                <label for="CatatanPenguji1" class="form-label">Catatan Khusus dari Dosen</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="10"></textarea>
                            </div>
                            <strong></i>Status Logbook</strong>
                            <br>

                            <div class="d-grid gap-2">
                                <button class="btn btn-block btn-primary" type="button">Terima</button>
                                <button class="btn btn-block btn-danger" type="button">Tolak</button>
                            </div>
                        </div>
                        <!--end::Body-->
                    </form>
                    <!--end::Form-->

                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
