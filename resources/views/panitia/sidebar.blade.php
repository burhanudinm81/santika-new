<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{ url('/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">S A N T I K A</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (is_null(auth('dosen')->user()->foto_profil))
                    <img src={{ url('/images/blank-profile-128x128.png') }} class="img-circle elevation-2"
                        alt="User Image" id="user-image">
                @else
                    <img src={{ asset('/storage/' . auth('dosen')->user()->foto_profil) }}
                        class="img-circle elevation-2" alt="User Image" id="user-image" width="30px" height="30px">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block" id="profile-link">{{ auth('dosen')->user()->nama }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/panitia/home" class="nav-link" id="dashboard-item">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/dosen/home" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>
                            Akun Dosen
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('panitia.kuota-dosen.page') }}" class="nav-link" id="kuota-dosen-item">
                        <i class="nav-icon fas fa-solid fa-users"></i>
                        <p>
                            Kuota Dosen
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('panitia.plotting-pembimbing.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-user-plus"></i>
                        <p>
                            Ploting Pembimbing
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('panitia.kelola-periode-tahap.pengaturan-seminar') }}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-cog"></i>
                        <p>
                            Pengaturan Seminar
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-folder-open"></i>
                        <p>
                            Seminar Proposal
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('panitia.seminar-proposal.pendaftaran') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jadwal-sempro.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('panitia.seminar-proposal.tahap-rekap-nilai') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rekap Nilai</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-folder"></i>
                        <p>
                            Sidang Tugas Akhir
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('panitia.seminar-hasil.pendaftaran') }}"  class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('panitia.jadwal-sidang-akhir.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('panitia.seminar-hasil.tahap-rekap-nilai') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rekap Nilai</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-envelope-open-text"></i>
                        <p>
                            Cetak Surat
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#"  class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Undangan Sempro</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat Tugas Sempro</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hasil Sempro</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Dosen Pembimbing Mahasiswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Undangan Ujian Akhir</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surat Tugas Ujian Akhir</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Berita Acara Yudisium</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
        </nav>
    </div>
</aside>
