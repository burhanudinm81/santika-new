<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href={{ route("admin-prodi.home") }} class="brand-link">
    <img src={{ url("/adminlte/dist/img/AdminLTELogo.png") }} alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">S A N T I K A</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if (is_null(auth()->user()->foto_profil))
          <img src={{ url("/images/blank-profile-128x128.png") }} class="img-circle elevation-2" alt="User Image" id="user-image">
        @else
          <img src={{ asset("/storage/" . auth()->user()->foto_profil) }} class="img-circle elevation-2" alt="User Image" id="user-image" width="30px" height="30px">
        @endif
      </div>
      <div class="info">
        <a href="#" id="profile-link" class="d-block">{{ auth()->user()->nama }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li id="dashboard-item" class="nav-item nav-ajax">
          <a href="{{ route("admin-prodi.dashboard") }}" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-solid fa-user-graduate"></i>
            <p>
              Data Mahasiswa
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li id="mahasiswa-D4-item" class="nav-item nav-ajax">
              <a href="{{ route("admin-prodi.mahasiswa.d4.page") }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Mahasiswa D4 JTD</p>
              </a>
            </li>
            <li id="mahasiswa-D3-item" class="nav-item nav-ajax">
              <a href="{{ route("admin-prodi.mahasiswa.d3.page") }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Mahasiswa D3 TT</p>
              </a>
            </li>
          </ul>

        <li id="data-dosen-item" class="nav-item nav-ajax">
          <a href="{{ route("admin-prodi.dosen.page") }}" class="nav-link">
            <i class="nav-icon fas fa-solid fa-user"></i>
            <p>
              Data Dosen
            </p>
          </a>
        </li>

        <li id="panitia-tugas-akhir-item" class="nav-item nav-ajax">
          <a href="{{ route("admin-prodi.panitia-tugas-akhir") }}" class="nav-link">
            <i class="nav-icon fas fa-solid fa-user-check"></i>
            <p>
              Panitia Tugas Akhir
            </p>
          </a>
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