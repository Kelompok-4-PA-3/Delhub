<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>

                <div>
                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
               <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">MATA KULIAH</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                <li class="nav-item">
                    <a href="/home" class="nav-link">
                        <i class="ph-squares-four"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link">
								<i class="ph-layout"></i>
								<span>Data Master</span>
							</a>
							<ul class="nav-group-sub collapse">
                <li class="nav-item">
                    <a href="/kategori" class="nav-link">
                        <i class="ph-squares-four"></i>
                        <span>
                            Manajemen Kategori Mata Kuliah
                        </span>
                    </a>
                </li>
                              </li>
                <li class="nav-item">
                    <a href="/krs" class="nav-link">
                        <i class="ph-squares-four"></i>
                        <span>
                            Manajemen KRS
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kategori" class="nav-link">
                        <i class="ph-squares-four"></i>
                        <span>
                            Manajemen Kategori Mata Kuliah
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dosen" class="nav-link">
                        <i class="ph-chalkboard-teacher"></i>
                        <span>
                            Manajemen Dosen
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/mahasiswa" class="nav-link">
                        <i class="ph-student"></i>
                        <span>
                            Manajemen Mahasiswa
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/ruangan" class="nav-link">
                        <i class="ph-bank"></i>
                        <span>
                            Manajemen Ruangan
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/prodi" class="nav-link">
                        <i class="ph-circles-four"></i>
                        <span>
                            Manajemen Program Studi
                        </span>
                    </a>
                </li>
                @endrole
                @role('admin')
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">     PENGGUNA</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                <li class="nav-item">
                    <a href="/users" class="nav-link">
                        <i class="ph-users"></i>
                        <span>
                            Manajemen Pengguna
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/roles" class="nav-link">
                        <i class="ph-user-list"></i>
                        <span>
                            Manajemen Role
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/permission" class="nav-link">
                        <i class="ph-lock-key"></i>
                        <span>
                            Manajemen Permissions
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/prodi" class="nav-link">
                        <i class="ph-circles-four"></i>
                        <span>
                            Manajemen Program Studi
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/fakultas" class="nav-link">
                        <i class="ph-circles-four"></i>
                        <span>
                            Manajemen Fakultas
                        </span>
                    </a>
                </li>
			</ul>




                <li class="nav-item">
                    <a href="/interest" class="nav-link">
                        <i class="ph-heart"></i>
                        <span>
                            Kelola Antusias
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/mhsInterest" class="nav-link">
                        <i class="ph-heart"></i>
                        <span>
                            Kelola Antusias Mahasiswa
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/request" class="nav-link">
                        <i class="ph-list-dashes"></i>
                        <span>
                            History Bimbingan
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
