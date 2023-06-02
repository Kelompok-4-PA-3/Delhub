<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg border-0" style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">

    <style>
        .nav-link{
            color:  #4c6ef8;
            font-weight: bold;
            /* border : 0.5px solid black; */
            margin-bottom: 10px;
            border-radius: 10px; 
            margin-right: 10px;
            margin-left: 10px;
        }

        .nav-item-main{
            box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;
        }

        .nav-submenu{
            box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;
        }
    </style>
    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center ">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>
                {{-- {{Auth::user()->dosen}} --}}
                <div>
                    <button type="button"
                        class="btn btn-flat-indigo btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="btn btn-flat-indigo btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
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
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Navigasi</div>
                    <i class="ph-dots-three text-dark sidebar-resize-show"></i>
                </li>

                <li class="nav-item">
                    <a href="/home" class="nav-link nav-item-main">
                        <i class="ph-squares-four"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                @role('mahasiswa')
                    <li class="nav-item-header pt-0">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">PROYEK SAYA</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    @foreach (Auth::user()->mahasiswa->kelompok_mahasiswa->take(3) as $km)
                        @if ($km->kelompok->krs->config->active)    
                            <li class="nav-item nav-item-main">
                                <a href="/kelompok/{{$km->kelompok->id}}" class="nav-link">
                                    <i class="ph-stack-simple text-warning"></i>
                                    <span>
                                        <small class="text-primary"> {{$km->kelompok->nama_kelompok}}</small><br>
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endrole

                @role('dosen')
                @if (Auth::user()->dosen->krs->count() > 0 || Auth::user()->dosen->krs2->count() > 0)
                    @php
                        if (Auth::user()->dosen->krs->count() > 0) {
                            $mykrs = Auth::user()->dosen->krs->first()->id;
                        }else{
                            $mykrs = Auth::user()->dosen->krs2->first()->id;
                        }
                    @endphp
                    <li class="nav-item">
                        <a href="/koordinator/myproject" class="nav-link  nav-item-main">
                            <i class="ph-list-dashes"></i>
                            <span>
                               Koordinator
                            </span>
                        </a>
                    </li>
                @endif
                {{-- {{Auth::user()->dosen->pembimbing_penguji}} --}}
                {{-- {{Auth::user()->dosen->pembimbing_1}}
                {{Auth::user()->dosen->pembimbing_2}} --}}
                @if (Auth::user()->dosen->all_role_kelompok->count() > 0 )
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">PEKERJAAN SAYA</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                        @foreach (Auth::user()->dosen->all_role_kelompok->take(3) as $role)
                            @if (strtolower($role->role_group->nama) != 'koordinator')
                                <li class="nav-item" nav-item-main>
                                    <a href="/kelompok/{{$role->kelompok->id}}" class="nav-link">
                                        <i class="ph-chalkboard-simple text-warning"></i>
                                        <span>
                                            <small class="text-indigo">{{$role->kelompok->nama_kelompok}}</small><br>
                                            <div>
                                                <small class="text-muted"> <i> {{$role->role_group->nama}}</i></small>
                                            </div>
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach 
                    <li class="nav-item-header">
                        <div class="fs-sm lh-sm opacity-50 sidebar-resize-hide ml-2"><i><a href="/dashboard" class="text-light ">Pekerjaan lainnya ...</a></i></div>
                    </li>
                @endif

                @endrole
                @can('history bimbingan')
                <li class="nav-item nav-item-main">
                    <a href="/request" class="nav-link">
                        <i class="ph-list-dashes"></i>
                        <span>
                            History Bimbingan
                        </span>
                    </a>
                </li>
                @endcan
                @role('admin')
                <li class="nav-item nav-item-submenu ">
                    <a href="#" class="nav-link nav-submenu">
                    	<i class="ph-layout"></i>
                    	<span>Data Master</span>
                    </a>
				<ul class="nav-group-sub collapse">
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">PENGGUNA</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

               

                <li class="nav-item d-down-item">
                    <a href="/jadwal" class="nav-link">
                        <i class="ph-heart"></i>
                        <span>
                            Jadwal
                        </span>
                    </a>
                </li>
                <li class="nav-item d-down-item">
                    <a href="/mhsInterest" class="nav-link">
                        <i class="ph-heart"></i>
                        <span>
                            Kelola Antusias Mahasiswa
                        </span>
                    </a>
                </li>
               
                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Akademik</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                @can('manajemen krs')
                <li class="nav-item d-down-item">
                    <a href="/krs" class="nav-link">
                        <i class="ph-squares-four"></i>
                        <span>
                            Manajemen KRS
                        </span>
                    </a>
                </li>
                @endcan
                @can('manajemen kategori mata kuliah')
                <li class="nav-item d-down-item">
                    <a href="/kategori" class="nav-link">
                        <i class="ph-squares-four"></i>
                        <span>
                            Manajemen Kategori Mata Kuliah
                        </span>
                    </a>
                </li>
                @endcan
                @can('manajemen poin regulasi')
                <li class="nav-item d-down-item">
                    <a href="/poin_regulasi" class="nav-link">
                        <i class="ph-squares-four"></i>
                        <span>
                            Manajemen Poin Regulasi
                        </span>
                    </a>
                </li>
                @endcan
                @can('manajemen kategori proyek')
                <li class="nav-item d-down-item">
                    <a href="/kategori_proyek" class="nav-link">
                        <i class="ph-squares-four"></i>
                        <span>
                            Manajemen Kategori Proyek
                        </span>
                    </a>
                </li>
                @endcan
               
                @can('manajemen konfigurasi')
                <li class="nav-item d-down-item">
                    <a href="/config" class="nav-link">
                        <i class="ph-list-dashes"></i>
                        <span>
                           Konfigurasi
                        </span>
                    </a>
                </li>
                @endcan

                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">civitas dan Program pendidikan</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                @can('manajemen dosen')
                <li class="nav-item d-down-item">
                    <a href="/dosen" class="nav-link">
                        <i class="ph-chalkboard-teacher"></i>
                        <span>
                            Manajemen Dosen
                        </span>
                    </a>
                </li>
                @endcan
                @can('manajemen mahasiswa')
                <li class="nav-item d-down-item">
                    <a href="/mahasiswa" class="nav-link">
                        <i class="ph-student"></i>
                        <span>
                            Manajemen Mahasiswa
                        </span>
                    </a>
                </li>
                @endcan
                @can('manajemen fakultas')
                <li class="nav-item d-down-item">
                    <a href="/fakultas" class="nav-link">
                        <i class="ph-circles-four"></i>
                        <span>
                            Manajemen Fakultas
                        </span>
                    </a>
                </li>
                @endcan
                @can('manajemen program studi')
                <li class="nav-item d-down-item">
                    <a href="/prodi" class="nav-link">
                        <i class="ph-circles-four"></i>
                        <span>
                            Manajemen Program Studi
                        </span>
                    </a>
                </li>
                @endcan

                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">PENGGUNA</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                @can('manajemen pengguna')
                <li class="nav-item d-down-item">
                <a href="/users" class="nav-link">
                    <i class="ph-users"></i>
                    <span>
                        Manajemen Pengguna
                    </span>
                </a>
                </li>
                @endcan
                @can('manajemen role')
                <li class="nav-item d-down-item">
                    <a href="/roles" class="nav-link">
                        <i class="ph-user-list"></i>
                        <span>
                            Manajemen Role
                        </span>
                    </a>
                </li>
                @endcan
                @can('manajemen permission')
                <li class="nav-item d-down-item">
                    <a href="/permission" class="nav-link">
                        <i class="ph-lock-key"></i>
                        <span>
                            Manajemen Permissions
                        </span>
                    </a>
                </li>
                @endcan

                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Lainnya</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                @can('manajemen ruangan')
                <li class="nav-item d-down-item">
                    <a href="/ruangan" class="nav-link">
                        <i class="ph-bank"></i>
                        <span>
                            Manajemen Ruangan
                        </span>
                    </a>
                </li>
                @endcan
                @can('kelola antusias mahasiswa')
                <li class="nav-item d-down-item">
                    <a href="/interest" class="nav-link">
                        <i class="ph-heart"></i>
                        <span>
                            Kelola Antusias
                        </span>
                    </a>
                </li>
                @endcan
                @endrole

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
