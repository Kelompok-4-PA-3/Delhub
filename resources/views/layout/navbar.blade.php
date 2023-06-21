<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10" style="box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px; background-color: #4c6ef8">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>

            <button type="button" class="navbar-toggler sidebar-mobile-end-toggle rounded-pill">
                <i class="ph-arrow-right"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="/home" class="d-inline-flex align-items-center">
                <img src="{{asset('/img/logo-light.png')}}" alt="" style="width: 50px; height: 40px;">
               <div>
                <h3 class="h-16px ms-2 text-white fw-light ">Del<span class="fw-bold">Hub</span></h3>
                <small class="ms-2 text-white"><i>Fakulatas Vokasi Institut Teknologi Del</i></small>
               </div>
                {{-- <h3 class="h-16px ms-3 text-white fw-light fw-bold">Del<span class=" bg-warning px-1 text-dark">Hub</span></h3> --}}
            </a>
        </div>

        <ul class="nav flex-row">
            <li class="nav-item d-lg-none">
                <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                    data-bs-toggle="collapse">
                    <i class="ph-magnifying-glass"></i>
                </a>
            </li>
            
        </ul>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            {{-- <li class="nav-item ms-lg-2">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="offcanvas"
                    data-bs-target="#notifications">
                    <i class="ph-bell"></i>
                    <span
                        class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">2</span>
                </a>
            </li> --}}

            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2" data-bs-popup="tooltip"
                {{-- title="{{ Auth::user()->nama }}" --}}
                >
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        <img src="@if(Auth::user()->profile_photo_path == NULL || Auth::user()->profile_photo_path == '') {{asset('/img/profile_default/user-profile.jpg')}} @else {{asset('/storage/images/'.Auth::user()->profile_photo_path)}} @endif" class="w-32px h-32px rounded-pill"
                            alt="">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{ Auth::user()->nama }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="dropdown-item">
                        @foreach (Auth::user()->getRoleNames() as $item)
                            <span class="bg-warning bg-opacity-10 py-1 px-2 rounded-pill text-white"><small class="text-warning">{{$item}}</small></span>&nbsp;
                        @endforeach
                    </div>
                    <a href="/users/{{Auth::user()->id}}/profile" class="dropdown-item">
                        <i class="ph-user-circle me-2"></i>
                        My profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profile.show') }}" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                        Account settings
                    </a>
                    <a class="dropdown-item">
                        <i class="ph-sign-out me-2"></i>
                        <form action="{{ route('logout') }}" method="post" class="mt-2">
                            @csrf
                            <button class="bg-transparent border border-0" type="submit">{{ __('Log Out') }}</button>
                        </form>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
