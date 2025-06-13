<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profil</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-15">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @isset(auth()->user()->foto_profil)
                            <img class="profile-user-img img-circle" data-toggle="tooltip" data-placement="right"
                                title="Klik untuk mengubah foto profil"
                                src="{{ asset("/storage/" . auth()->user()->foto_profil) }}" alt="User profile picture" width="100px" height="100px" />
                        @else
                            <img class="profile-user-img img-circle"
                                src="{{url("/images/blank-profile-64x64.png")}}" alt="User profile picture"
                                data-toggle="tooltip" data-placement="right" title="Klik untuk mengubah foto profil" width="100px" height="100px"/>
                        @endisset
                    </div>

                    <h3 class="profile-username text-center">{{ auth()->user()->nama }}</h3>

                    <ul class="list-group list-group-unbordered mb-3">
                        <form action="{{ route("master-admin.profile.edit-email") }}" method="post"
                            id="edit-email-form">
                            @csrf
                            <div class="mb-3">
                                <label for="email-input" class="form-label">Email address</label>
                                @if (!is_null(auth()->user()->email))
                                    <input type="email" class="form-control" id="email-input" name="email"
                                        placeholder="name@student.polinema.ac.id" value="{{ auth()->user()->email }}"
                                        maxlength="255" required>
                                @else
                                    <input type="email" class="form-control" id="email-input" name="email"
                                        placeholder="name@student.polinema.ac.id" maxlength="255" required>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-block btn-success btn-block"
                                id="save-email-btn"><b>Simpan
                                    Email</b></button>
                            <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                data-target="#modal-ubah-password">
                                <b>Ubah Password</b>
                            </button>
                        </form>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script src={{ url("/custom/js/profile/edit-email.js") }}></script>
<script src={{ url("/custom/js/profile/edit-profile-image.js") }}></script>
<script>
    $("document").ready(function () {
        $(".profile-user-img").tooltip();

        $(".profile-user-img").click(function () {
            $("#modal-ubah-foto-profil").modal();
        });
    });
</script>