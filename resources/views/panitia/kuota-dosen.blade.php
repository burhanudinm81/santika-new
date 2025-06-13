<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7">
                <h1 class="m-0">Kuota Dosen</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- Tabel Kuota Dosen D3 Teknik Telekomunikasi -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header px-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    <h5>Kuota Dosen D3 Teknik Telekomunikasi</h5>
                                </div>
                                <div class="col-sm">
                                    <div class="input-group input-group-sm float-right" style="width: 150px">
                                        <input type="text" id="search-dosen-d3" name="table_search"
                                            class="form-control float-right" placeholder="Search" />

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 320px">
                        <table class="table table-head-fixed text-nowrap" id="tabel-kuota-dosen-d3">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">No</th>
                                    <th class="text-center align-middle">Nama</th>
                                    <th class="text-center align-middle">Dosen Pembimbing 1</th>
                                    <th class="text-center align-middle">Edit</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Tabel Kuota Dosen D4 Jaringan Telekomunikasi Digital-->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header px-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    <h5>Kuota Dosen D4 Jaringan Telekomunikasi Digital</h5>
                                </div>
                                <div class="col-sm">
                                    <div class="input-group input-group-sm float-right" style="width: 150px">
                                        <input type="text" id="search-dosen-d4" name="table_search"
                                            class="form-control float-right" placeholder="Search" />

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 320px">
                        <table class="table table-head-fixed text-nowrap" id="tabel-kuota-dosen-d4">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">No</th>
                                    <th class="text-center align-middle">Nama</th>
                                    <th class="text-center align-middle">Dosen Pembimbing 1</th>
                                    <th class="text-center align-middle">Edit</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script src="{{ url("/custom/js/edit-kuota-dosen.js") }}"></script>