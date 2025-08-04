<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src={{ url('/adminlte/dist/img/AdminLTELogo.png') }} alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">S A N T I K A</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (is_null(auth('mahasiswa')->user()->foto_profil))
                    <img src={{ url('/images/blank-profile-128x128.png') }} class="img-circle elevation-2" alt="User Image"
                        id="user-image">
                @else
                    <img src={{ asset('/storage/' . auth('mahasiswa')->user()->foto_profil) }}
                        class="img-circle elevation-2" alt="User Image" id="user-image" width="30px" height="30px">
                @endif
            </div>
            <a href="{{ route('mahasiswa.profile') }}" id="profile-link" class="info">
                <span class="d-block">{{ auth('mahasiswa')->user()->nama }}</span>
            </a>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li id="dashboard-item" class="nav-item">
                    <!-- route("mahasiswa.home") -->
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copyright"></i>
                        <p>
                            Cek Plagiasi
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-paper-plane"></i>
                        <p>
                            Pengajuan Judul
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li id="judul-mandiri-item" class="nav-item">
                            <a href="{{ route('mahasiswa.pengajuan-judul') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Judul Mandiri</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Judul Rekomendasi</p>
                            </a>
                        </li>
                        <li class="nav-item" id="riwayat-pengajuan-item">
                            <a href="{{ route('mahasiswa.pengajuan-judul-riwayat') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Riwayat Pengajuan</p>
                            </a>
                        </li>
                    </ul>

                <li class="nav-item menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Informasi Dosen
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item" id="profil-dosen-item">
                            <a href="/mahasiswa/informasi-dosen/daftar-dosen" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profil Dosen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.informasi-dosen.daftar-dosen-pembimbing') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dosen Pembimbing</p>
                            </a>
                        </li>
                    </ul>

                <li class="nav-item menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            Seminar Proposal
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item" id="pendaftaran-sempro-item">
                            <!-- route("mahasiswa.seminar-proposal.form-daftar") -->
                            <a href="{{ route('mahasiswa.seminar-proposal.pendaftaran') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pendaftaran Sempro</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.seminar-proposal.jadwal') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal Sempro</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.seminar-proposal.hasil-sempro') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengumuman Sempro</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.seminar-proposal.revisi') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Revisi Sempro</p>
                            </a>
                        </li>
                        <li class="nav-item" id="riwayat-pendaftaran-item">
                            <!-- route("mahasiswa.seminar-proposal.riwayat") -->
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Riwayat Pendaftaran</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Logbook Bimbingan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.logbook.beranda', 1) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dosen Pembimbing 1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.logbook.beranda', 2) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dosen Pembimbing 2</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item menu-close">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Sidang Laporan Akhir
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.seminar-hasil.daftar-semhas') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pendaftaran Sidang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa.seminar-hasil.jadwal') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal Sidang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengumuman Sidang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Revisi Sidang</p>
                            </a>
                        </li>
                    </ul>
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
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
