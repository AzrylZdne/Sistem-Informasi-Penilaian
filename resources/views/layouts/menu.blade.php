<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">Penilaian Web</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    @if (Auth::user()->role == 'admin')
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa fa-cogs"></i>
                <span>Data Master</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Master</h6>
                    <a class="collapse-item" href="{{ url('fakultas') }}">Data Fakultas</a>
                    <a class="collapse-item" href="{{ url('prodi') }}">Data Prodi</a>
                    <a class="collapse-item" href="{{ url('kategori') }}">Data Kategori</a>
                    <a class="collapse-item" href="{{ url('sub-kategori') }}">Data Sub Kategori </a>
                    <a class="collapse-item" href="{{ url('user-juri') }}">Data User</a>

                </div>
            </div>
        </li>
    @endif

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Penilaian</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Penilaian </h6>
                <a class="collapse-item" href="{{ url('penilaian-fakultas') }}">Penilaian Fakultas</a>
                <a class="collapse-item" href="{{ url('penilaian-prodi') }}">Penilaian Prodi</a>
            </div>
        </div>
    </li>

</ul>
