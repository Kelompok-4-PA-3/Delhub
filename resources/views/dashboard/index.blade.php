@extends('main')
   
@section('title')
    <title>Manajemen Mahasiswa</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
    {{-- <script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script> --}}
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="row">
        <div class="col-xl-7">

            <!-- Traffic sources -->
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Dashboard</h5>
                    <div class="ms-auto">
                        <label class="form-check form-switch form-check-reverse">
                            <input type="checkbox" class="form-check-input" checked>
                            <span class="form-check-label">Live update</span>
                        </label>
                    </div>
                </div>

                <div class="card-body pb-0">
                    <div class="project-list">

						
					@if (Auth::user()->dosen->all_role_kelompok->count() > 0 )
						<div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide p-1">PEKERJAAN SAYA</div>
						@foreach (Auth::user()->dosen->all_role_kelompok as $role)
							@if (strtolower($role->role_group->nama) != 'koordinator' && $role->role_group->role_kategori->krs->config->active)
								<div class="p-1">
									<div class="d-flex mb-2">
										<a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
											<i class="ph-notepad"></i>
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
							

							{{-- <li class="nav-item">
								<a href="/kelompok/{{$role->kelompok->id}}" class="nav-link">
									<i class="ph-browsers text-warning"></i>
									<div>
									<small class="text-primary">{{$role->kelompok->nama_kelompok}}</small><br>
									<div>
										<small class="text-light"> <i> {{$role->role_group->nama}}</i></small>
									</div>
									</div>
								</a>
								
							</li> --}}
						@endforeach 
					@endif

						@foreach ($krs as $k)
							<div class="p-1">
								<div class="d-flex mb-2">
									<a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
										<i class="ph-notepad"></i>
									</a>
									<div>
										<div class="fw-semibold">
											<a href="/dashboard/{{$k->id}}">{{$k->kategori->nama_mk}}</a>
										</div>
										<span class="text-muted">{{$k->dosen->user->nama}}</span>
									</div>
								</div>
								<div class="w-75 mx-auto mb-3" id="new-visitors"></div>
							</div>
						@endforeach

                        <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-notepad"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="">PA3-D4TRPL-2020</a>
                                    </div>
                                    <span class="text-muted">Koordinator</span>
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                        </div>

                        <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-warning bg-opacity-10 text-warning lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-projector-screen-chart"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="">TA-II-D4-TRPL-20</a>
                                    </div>
                                    <span class="text-muted">Penguji - Kelompok 4</span>
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                        </div>

                        <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-users-three"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="">KP-D4TRPL-2022</a>
                                    </div>
                                    <span class="text-muted">Pembimbing - Rosa Kopeng</span>
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="total-online"></div>
                        </div>
                    </div>
                </div>

                <div class="chart position-relative" id="traffic-sources"></div>
            </div>
            <!-- /traffic sources -->

        </div>

        <div class="col-xl-5">

        </div>
    </div>

@endsection

@section('right-sidebar')
 <!-- Right sidebar -->
		<div class="sidebar sidebar-end sidebar-expand-lg sidebar-collapsed">

			<!-- Expand button -->
			<button type="button" class="btn btn-sidebar-expand sidebar-control sidebar-end-toggle h-100">
				<i class="ph-caret-left"></i>
			</button>
			<!-- /expand button -->


			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- Header -->
				<div class="sidebar-section sidebar-section-body d-flex align-items-center pb-2">
					<h5 class="mb-0">Sidebar</h5>
					<div class="ms-auto">
						<button type="button" class="btn btn-light border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-end-toggle d-none d-lg-inline-flex">
							<i class="ph-arrows-left-right"></i>
						</button>

						<button type="button" class="btn btn-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-end-toggle d-lg-none">
							<i class="ph-x"></i>
						</button>
					</div>
				</div>
				<!-- /header -->

				<!-- Sub navigation -->
				<div class="sidebar-section">
					<div class="sidebar-section-header border-bottom">
						<span class="fw-semibold">Navigation</span>
						<div class="ms-auto">
	                		<a href="#sidebar-navigation" class="text-reset" data-bs-toggle="collapse">
								<i class="ph-caret-down collapsible-indicator"></i>
	                		</a>
	                	</div>
					</div>

					<div class="collapse show" id="sidebar-navigation">
						<ul class="nav nav-sidebar mt-2" data-nav-type="accordion">
							<li class="nav-item-header opacity-50">Actions</li>
							<li class="nav-item">
                                <div class="btn-group">
                                    <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                        <i class="ph-users-three me-2"></i>
                                        Buat kelompok
                                    </a>

                                    <div class="dropdown-menu">
                                        <form action="/kelompok" class="container" method="post">
                                            @csrf
                                            <div class="d-flex">
                                                <small for="">Jumlah kelompok : </small>
                                                <input type="number" class="w-100 form-control form-control-sm" name="jumlah_kelompok" required>
												
												<div class="d-flex mt-2">
													<button type="submit" class="badge ms-auto bg-primary border border-0">Buat</button>
												</div>
                                            </div>
                                            @error('jumlah_kelompok')
                                            <div>
                                                <small class="text-danger">{{$message}}</small>
                                            </div>
                                            @enderror
                                        </form>
                                    </div>
                                </div>

							</li>
							<li class="nav-item">
								<a href="/kelompok" class="nav-link">
									<i class="ph-plus-circle me-2"></i>
									Create task
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="ph-circles-three-plus me-2"></i>
									Create project
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="ph-pencil me-2"></i>
									Edit task list
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="ph-user-plus me-2"></i>
									Assign users
									<span class="badge bg-primary rounded-pill ms-auto">94 online</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- /sub navigation -->


				<!-- Online users -->
				<div class="sidebar-section">
					<div class="sidebar-section-header border-bottom">
						<span class="fw-semibold">Mahasiswa</span>
						<div class="ms-auto">
	                		<a href="#sidebar-users" class="text-reset" data-bs-toggle="collapse">
								<i class="ph-caret-down collapsible-indicator"></i>
	                		</a>
	                	</div>
					</div>

					<div class="collapse show" id="sidebar-users">
						<div class="sidebar-section-body">
							@foreach($krs as $k)
							@if($k->krs_user->count() > 0)
							@foreach($k->krs_user as $ku)
							<div class="d-flex mb-3">
								<a href="#" class="me-3">
									<img src="../../../assets/images/demo/users/face1.jpg" width="36" height="36" class="rounded-pill" alt="">
								</a>
								<div class="flex-fill">
									<a href="#" class="fw-semibold">{{$ku->mahasiswa->user->nama}}</a>
									<div class="fs-sm opacity-50">{{$ku->mahasiswa->nim}}</div>
								</div>
								<div class="ms-3 align-self-center">
									<div class="bg-success border-success rounded-pill p-1"></div>
								</div>
							</div>
							@endforeach
							@else
								<small class="text-muted text-center">Belum ada mahasiswa di project ini</small>
							@endif
							@endforeach
						</div>
					</div>
				</div>
				<!-- /online users -->

			</div>
			<!-- /sidebar content -->

		</div>
		<!-- /right sidebar -->
@endsection