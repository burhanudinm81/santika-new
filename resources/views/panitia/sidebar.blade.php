<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ url("/adminlte/dist/img/AdminLTELogo.png") }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">S A N T I K A</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (is_null(auth("dosen")->user()->foto_profil))
                    <img src={{ url("/images/blank-profile-128x128.png") }} class="img-circle elevation-2" alt="User Image"
                        id="user-image">
                @else
                    <img src={{ asset("/storage/" . auth("dosen")->user()->foto_profil) }} class="img-circle elevation-2"
                        alt="User Image" id="user-image" width="30px" height="30px">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block" id="profile-link">{{ auth("dosen")->user()->nama }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item nav-ajax">
                    <a href="/panitia/dashboard" class="nav-link" id="dashboard-item">
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
                    <a href="/panitia/kuota-dosen" class="nav-link" id="kuota-dosen-item">
                        <i class="nav-icon fas fa-solid fa-users"></i>
                        <p>
                            Kuota Dosen
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-user-plus"></i>
                        <p>
                            Ploting Pembimbing
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
                        <li class="nav-item nav-ajax">
                            <a href="{{ route("panitia.seminar-proposal.list")  }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sempro4.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sempro6.php" class="nav-link">
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
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ta4.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jadwal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="ta6.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rekap Nilai</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route("logout") }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>