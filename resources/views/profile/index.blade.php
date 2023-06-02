@extends('main')

@push('select_js')
<script src="{{asset('../../../assets/js/jquery/jquery.min.js')}}"></script>
<script src="{{asset('../../../assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{asset('../../../assets/demo/pages/form_layouts.js')}}"></script>
@endpush

@section('content')
<!-- Cover area -->
<div class="profile-cover">
    <div class="profile-cover-img" style="background-image: url(../../../img/profile_bg.jpg)"></div>
    <div
        class="d-flex align-items-center text-center text-lg-start flex-column flex-lg-row position-absolute start-0 end-0 bottom-0 mx-3 mb-3">
        <div class="me-lg-3 mb-2 mb-lg-0">
            <a href="#">
                <img src="../../../assets/images/demo/users/face11.jpg" class="img-thumbnail rounded-circle shadow"
                    width="100" height="100" alt="">
            </a>
        </div>

        <div class="profile-cover-text text-white">
            <h1 class="mb-0">{{$user->nama}}</h1>
            <div class="d-flex">                     
                @foreach($user->getRoleNames() as $role)
                    <span class="d-block bg-indigo px-2 rounded-pill me-1 shadow">{{$role}}</span>
                @endforeach
            </div>
        </div>

        <div class="ms-lg-auto mt-2 mt-lg-0">
            <div class="d-inline-flex">
                <a href="#" class="btn btn-light border-transparent shadow">
                    <i class="ph-image me-2"></i>
                    Cover image
                </a>
            </div>
        </div>
    </div>
</div>
<!-- /cover area -->


<!-- Profile navigation -->
<div class="navbar navbar-expand-lg border-bottom py-2">
    <div class="container-fluid">
        <ul class="nav navbar-nav flex-row flex-fill">
            <li class="nav-item me-1">
                <a href="#activity" class="navbar-nav-link navbar-nav-link-icon active rounded" data-bs-toggle="tab">
                    <div class="d-flex align-items-center mx-lg-1">
                        <i class="ph-activity"></i>
                        <span class="d-none d-lg-inline-block ms-2">Aktifitas</span>
                    </div>
                </a>
            </li>
            <li class="nav-item me-1">
                <a href="#schedule" class="navbar-nav-link navbar-nav-link-icon rounded" data-bs-toggle="tab">
                    <div class="d-flex align-items-center mx-lg-1">
                        <i class="ph-calendar"></i>
                        <span class="d-none d-lg-inline-block ms-2">
                            Schedule
                            <span class="badge bg-success rounded-pill ms-auto ms-lg-2">32</span>
                        </span>
                    </div>
                </a>
            </li>
            <li class="nav-item me-1">
                <a href="#settings" class="navbar-nav-link navbar-nav-link-icon rounded" data-bs-toggle="tab">
                    <div class="d-flex align-items-center mx-lg-1">
                        <i class="ph-gear"></i>
                        <span class="d-none d-lg-inline-block ms-2">Settings</span>
                    </div>
                </a>
            </li>

            <li class="nav-item d-lg-none ms-auto">
                <a href="#profile_nav" class="navbar-nav-link navbar-nav-link-icon collapsed rounded"
                    data-bs-toggle="collapse">
                    <i class="ph-caret-down collapsible-indicator"></i>
                </a>
            </li>
        </ul>

        <div class="navbar-collapse collapse" id="profile_nav">
            <ul class="navbar-nav ms-lg-auto mt-2 mt-lg-0">
                <li class="nav-item ms-lg-1">
                    <a href="#" class="navbar-nav-link rounded">
                        <i class="ph-note me-2"></i>
                        Notes
                    </a>
                </li>
                <li class="nav-item ms-lg-1">
                    <a href="#" class="navbar-nav-link rounded">
                        <i class="ph-users me-2"></i>
                        Friends
                    </a>
                </li>
                <li class="nav-item ms-lg-1">
                    <a href="#" class="navbar-nav-link rounded">
                        <i class="ph-image me-2"></i>
                        Photos
                    </a>
                </li>
                <li class="nav-item dropdown ms-lg-1">
                    <a href="#" class="navbar-nav-link rounded dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="ph-gear"></i>
                        <span class="d-lg-none ms-2">More</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item">
                            <i class="ph-image me-2"></i>
                            Update cover
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="ph-clipboard-text me-2"></i>
                            Update info
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="ph-rows me-2"></i>
                            Manage sections
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="ph-activity me-2"></i>
                            Activity log
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="ph-gear me-2"></i>
                            Profile settings
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /profile navigation -->

<!-- Content area -->
<div class="content">

    <!-- Inner container -->
    <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

        <!-- Left content -->
        <div class="tab-content flex-fill order-2 order-lg-1">
            <div class="tab-pane fade active show" id="activity">

                <!-- Sales stats -->
                <div class="card">
                    <div class="card-header d-sm-flex">
                        <h5 class="mb-0">Aktifitas</h5>
                        <div class="mt-2 mt-sm-0 ms-auto">
                            <span>
                                <i class="ph-clock-counter-clockwise me-1"></i>
                                Updated 2 hours ago
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        @role('dosen')
						@if (Auth::user()->dosen->all_role_kelompok->count() > 0 )
							@foreach (Auth::user()->dosen->all_role_kelompok as $role)
                                @if ($role->role_group->role_kategori->krs != NULL)
                                    @if (strtolower($role->role_group->nama) != 'koordinator' && $role->role_group->role_kategori->krs->config->active)
                                    <div class="p-1">
                                        <div class="d-flex mb-2">
                                            <a href="#" class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
                                                <i class="ph-chalkboard-teacher"></i>
                                            </a>
                                            <div>
                                                <div class="fw-semibold">
                                                    <a href="/kelompok/{{$role->kelompok->id}}">{{$role->kelompok->nama_kelompok}}</a>
                                                </div>
                                                <span class="text-muted">{{$role->role_group->nama}}</span>
                                            </div>
                                        </div>
                                        <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                                    </div>
                                    @endif
                                @endif
							@endforeach 
                        @else
                        <div class="mb-3">
                            <small class="text-muted">Anda tidak belum memiliki pekerjaan saat ini!</small>
                        </div>
						@endif
					@endrole

					@role('mahasiswa')
                    @if (Auth::user()->mahasiswa->kelompok_mahasiswa->count() > 0)
                        @foreach (Auth::user()->mahasiswa->kelompok_mahasiswa as $km)
                            @if ($km->kelompok->krs->config->active)    
                                <div class="p-1">
                                    <div class="d-flex mb-2">
                                        <a href="#" class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
                                            <i class="ph-users-three"></i>
                                        </a>
                                        <div>
                                            <div class="fw-semibold">
                                                <a href="/kelompok/{{$km->kelompok->id}}}"> {{$km->kelompok->nama_kelompok}}</a>
                                            </div>
                                            <span class="text-muted">{{$km->kelompok->krs->kategori->nama_mk}}</span>
                                        </div>
                                    </div>
                                    <div class="w-75 mx-auto mb-3" id="new-visitors"></div>	
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="mb-3">
                            <small class="text-muted">Anda tidak belum memiliki pekerjaan saat ini!</small>
                        </div>
                    @endif
					@endrole
                        {{-- <div class="chart-container">
                            <div class="chart has-fixed-height" id="tornado_negative_stack"></div>
                        </div> --}}
                    </div>
                </div>
                <!-- /sales stats -->

            </div>

            <div class="tab-pane fade" id="schedule">

                <!-- Available hours -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Available hours</h5>
                    </div>

                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart has-fixed-height" id="available_hours"></div>
                        </div>
                    </div>
                </div>
                <!-- /available hours -->


                <!-- Schedule -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">My schedule</h5>
                    </div>

                    <div class="card-body">
                        <div class="my-schedule"></div>
                    </div>
                </div>
                <!-- /schedule -->

            </div>

            <div class="tab-pane fade" id="settings">

                <!-- Profile info -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Profile information</h5>
                    </div>

                    <div class="card-body">
                        <form action="#">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" value="Victoria" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full name</label>
                                        <input type="text" value="Smith" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address line 1</label>
                                        <input type="text" value="Ring street 12" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Address line 2</label>
                                        <input type="text" value="building D, flat #67" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" value="Munich" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">State/Province</label>
                                        <input type="text" value="Bayern" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">ZIP code</label>
                                        <input type="text" value="1031" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" readonly="readonly" value="victoria@smith.com"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Your country</label>
                                        <select class="form-select">
                                            <option value="germany" selected>Germany</option>
                                            <option value="france">France</option>
                                            <option value="spain">Spain</option>
                                            <option value="netherlands">Netherlands</option>
                                            <option value="other">...</option>
                                            <option value="uk">United Kingdom</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone #</label>
                                        <input type="text" value="+99-99-9999-9999" class="form-control">
                                        <div class="form-text text-muted">+99-99-9999-9999</div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Upload profile image</label>
                                        <input type="file" class="form-control">
                                        <div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size
                                            2Mb</div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /profile info -->


                <!-- Account settings -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Account settings</h5>
                    </div>

                    <div class="card-body">
                        <form action="#">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" value="Vicky" readonly class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Current password</label>
                                        <input type="password" value="password" readonly class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">New password</label>
                                        <input type="password" placeholder="Enter new password" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Repeat password</label>
                                        <input type="password" placeholder="Repeat new password" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Profile visibility</label>

                                        <label class="form-check mb-2">
                                            <input type="radio" name="visibility" class="form-check-input" checked>
                                            <span class="form-check-label">Visible to everyone</span>
                                        </label>

                                        <label class="form-check mb-2">
                                            <input type="radio" name="visibility" class="form-check-input">
                                            <span class="form-check-label">Visible to friends only</span>
                                        </label>

                                        <label class="form-check mb-2">
                                            <input type="radio" name="visibility" class="form-check-input">
                                            <span class="form-check-label">Visible to my connections only</span>
                                        </label>

                                        <label class="form-check">
                                            <input type="radio" name="visibility" class="form-check-input">
                                            <span class="form-check-label">Visible to my colleagues only</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Notifications</label>

                                        <label class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" checked>
                                            <span class="form-check-label">Password expiration notification</span>
                                        </label>

                                        <label class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" checked>
                                            <span class="form-check-label">New message notification</span>
                                        </label>

                                        <label class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" checked>
                                            <span class="form-check-label">New task notification</span>
                                        </label>

                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input">
                                            <span class="form-check-label">New contact request notification</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /account settings -->

            </div>
        </div>
        <!-- /left content -->


        <!-- Right sidebar component -->
        <div
            class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Navigation -->
                <div class="card">
                    <div class="sidebar-section-header border-bottom">
                        <span class="fw-semibold">Navigation</span>
                    </div>

                    <ul class="nav nav-sidebar">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="ph-user me-2"></i>
                                My profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="ph-coins me-2"></i>
                                Balance
                                <span class="text-muted fs-sm fw ms-auto">$1,430</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="ph-share-network me-2"></i>
                                Connections
                                <span class="badge bg-danger rounded-pill ms-auto">29</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="ph-users-three me-2"></i>
                                Friends
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="ph-calendar me-2"></i>
                                Events
                                <span class="badge bg-teal rounded-pill ms-auto">48</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="ph-gear me-2"></i>
                                Account settings
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /navigation -->


 


             

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /right sidebar component -->

    </div>
    <!-- /inner container -->

</div>
<!-- /content area -->

<div class="card">

</div>
@endsection