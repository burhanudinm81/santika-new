<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src={{ url('/adminlte/dist/img/AdminLTELogo.png') }} class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">S A N T I K A</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (is_null(auth('dosen')->user()->foto_profil))
                    <img src={{ url('/images/blank-profile-128x128.png') }} class="img-circle elevation-2" alt="User Image"
                        id="user-image">
                @else
                    <img src={{ asset('/storage/' . auth('dosen')->user()->foto_profil) }} class="img-circle elevation-2"
                        alt="User Image" id="user-image" width="30px" height="30px">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('dosen.profile') }}" id="profile-link" class="d-block">
                    {{ auth('dosen')->user()->nama }}
                </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item" id="dashboard-item">
                    <!-- route("dosen.dashboard") -->
                    <a href="/" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                @if (session('is_panitia'))
                    <li class="nav-item">
                        <a href="{{ route('panitia.home') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>Akun Panitia</p>
                        </a>
                    </li>
                @endif


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Rekomendasi Judul</p>
                    </a>
                </li>

                <li class="nav-item" id="permohonan-judul-item">
                    <a href="{{ route('dosen.permohonan-judul') }}" class="nav-link">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Permohonan Judul</p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>Seminar Proposal
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dosen.seminar-proposal.beranda-jadwal') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal</p>
                            </a>
                        </li>
                    </ul>

                <li class="nav-item">
                    <a href="{{ route('dosen.bimbingan.daftar-bimbingan') }}" class="nav-link">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Bimbingan</p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Sidang Tugas Akhir
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dosen.seminar-hasil.beranda-jadwal') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal Sidang</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
        </nav>
    </div>
</aside>