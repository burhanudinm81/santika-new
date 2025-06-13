<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Profil</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content  -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-15">
            <div class="card card-primary card-outline mb-4">
                <!--begin::Form-->
                <form id="form-edit-profil-dosen" action="{{ route("dosen.profile.update") }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="email-dosen" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email-dosen" name="email"
                                aria-describedby="EmailDosen" value="{{ auth("dosen")->user()->email ?? "" }}" />
                        </div>

                        <div class="mb-3">
                            <label for="nomor-telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="nomor-telepon" name="nomor_telepon"
                                aria-describedby="NomorTelepon"
                                value="{{ auth("dosen")->user()->no_handphone ?? "" }}" />
                        </div>

                        <div class="mb-3">
                            <label for="bidang_keahlian_1">Bidang Keahlian 1</label>
                            <select name="bidang_keahlian_1" id="bidang-keahlian-1" class="custom-select">
                                <option value="{{ App\Enum\BidangMinat::EMPTY }}">{{ App\Enum\BidangMinat::EMPTY }}
                                </option>

                                @if (auth("dosen")->user()->bidang_minat_1 == App\Enum\BidangMinat::BIDANG_MINAT_1)
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}" selected>
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}
                                    </option>
                                @else
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}">
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}
                                    </option>
                                @endif

                                @if(auth("dosen")->user()->bidang_minat_1 == App\Enum\BidangMinat::BIDANG_MINAT_2)
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}" selected>
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}
                                    </option>
                                @else
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}">
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}
                                    </option>
                                @endif

                                @if(auth("dosen")->user()->bidang_minat_1 == App\Enum\BidangMinat::BIDANG_MINAT_3)
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}" selected>
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}
                                    </option>
                                @else
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}">
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bidang_keahlian_2">Bidang Keahlian 2</label>
                            <select name="bidang_keahlian_2" id="bidang-keahlian-2" class="custom-select">
                                <option value="{{ App\Enum\BidangMinat::EMPTY }}">{{ App\Enum\BidangMinat::EMPTY }}
                                </option>
                                 @if (auth("dosen")->user()->bidang_minat_1 == App\Enum\BidangMinat::BIDANG_MINAT_1)
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}" selected>
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}
                                    </option>
                                @else
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}">
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}
                                    </option>
                                @endif

                                @if(auth("dosen")->user()->bidang_minat_2 == App\Enum\BidangMinat::BIDANG_MINAT_2)
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}" selected>
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}
                                    </option>
                                @else
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}">
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}
                                    </option>
                                @endif

                                @if(auth("dosen")->user()->bidang_minat_2 == App\Enum\BidangMinat::BIDANG_MINAT_3)
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}" selected>
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}
                                    </option>
                                @else
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}">
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bidang_keahlian_3">Bidang Keahlian 3</label>
                            <select name="bidang_keahlian_3" id="bidang-keahlian-3" class="custom-select">
                                <option value="{{ App\Enum\BidangMinat::EMPTY }}">{{ App\Enum\BidangMinat::EMPTY }}
                                </option>
                                 @if (auth("dosen")->user()->bidang_minat_3 == App\Enum\BidangMinat::BIDANG_MINAT_1)
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}" selected>
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}
                                    </option>
                                @else
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}">
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_1 }}
                                    </option>
                                @endif

                                @if(auth("dosen")->user()->bidang_minat_3 == App\Enum\BidangMinat::BIDANG_MINAT_2)
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}" selected>
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}
                                    </option>
                                @else
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}">
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_2 }}
                                    </option>
                                @endif

                                @if(auth("dosen")->user()->bidang_minat_3 == App\Enum\BidangMinat::BIDANG_MINAT_3)
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}" selected>
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}
                                    </option>
                                @else
                                    <option value="{{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}">
                                        {{ App\Enum\BidangMinat::BIDANG_MINAT_3 }}
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi-profil" class="form-label">Profil (Wajib)</label>
                            <textarea class="form-control" id="deskripsi-profil" name="deskripsi_profil" rows="5"
                                required>{{ auth("dosen")->user()->deskripsi_profil ?? "" }}</textarea>
                        </div>

                        <label>Peminatan Riset (Research Interest)</label><br>
                        <div class="form-group">
                            <label for="exampleInputFile">Gambar</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="gambar-peminatan-riset"
                                        name="gambar_peminatan_riset">
                                    <label class="custom-file-label" for="gambar-peminatan-riset">Pilih File</label>
                                    <small class="form-text text-muted">Jika tidak ingin mengubah Gambar Peminatan
                                        Riset, <b>tidak perlu</b> mengunggah gambar</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi-peminatan-riset" class="form-label">Deskripsi Peminatan Riset
                                (Wajib)</label>
                            <textarea class="form-control" id="deskripsi-peminatan-riset"
                                name="deskripsi_peminatan_riset" rows="5"
                                required>{{ auth("dosen")->user()->deskripsi_peminatan_riset ?? "" }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="publikasi" class="form-label">Publikasi (Wajib)</label>
                            <textarea class="form-control" id="publikasi" name="publikasi"
                                required>{{ auth("dosen")->user()->publikasi ?? "" }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="google_scholar" class="form-label">Google Scholar (Wajib)</label>
                            <textarea class="form-control" id="google_scholar" name="google_scholar"
                                required>{{ auth("dosen")->user()->link_google_scholar ?? "" }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="penghargaan" class="form-label">Penghargaan Yang Pernah Diberikan
                                (Wajib)</label>
                            <textarea class="form-control" id="penghargaan" name="penghargaan" rows="10"
                                required>{{ auth("dosen")->user()->penghargaan ?? "" }}</textarea>
                        </div>

                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" id="btn-batal">Batal</button>
                        <button type="submit" class="btn btn-success" id="btn-simpan">Simpan</button>
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<script src="{{ url("/custom/js/profile/edit-dosen-profile.js") }}"></script>
<script src="{{ url("/custom/js/animate-custom-file-input.js") }}"></script>