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

	<style>
		.datatable-header {
			display: none;
		}

		.datatable-footer{
			display: none;
		}
	</style>

    <div class="row">
        <div class="col-xl-7">

            <!-- Traffic sources -->
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Daftar Kelompok</h5>
                    <div class="ms-auto">
                        <label class="form-check form-switch form-check-reverse">
                            <input type="checkbox" class="form-check-input" checked>
                            <span class="form-check-label">Live update</span>
                        </label>
                    </div>
                </div>

                <div class="card-body pb-0">
                    <div class="project-list">
						@if($kelompok->count() > 0)
						@foreach($kelompok as $k)
                        <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-info bg-opacity-10 text-info lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-users-four"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="/kelompok/{{$k->id}}">{{$k->nama_kelompok}}</a>
                                    </div>
									@if ($k->topik != NULL)
										<span class="text-muted" data-bs-popup="tooltip" title="{{$k->topik}}">{{ Str::limit ($k->topik, 30) }}</span>
									@else
										<small class="text-nowrap text-warning"><i class="ph-warning-circle"></i> Belum ada topik </small>
									@endif
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                        </div>
						@endforeach
						@else
							<p class="text-muted text-center">Belum ada kelompok</p>
						@endif
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

@if(Auth::user()->dosen()->count() > 0)
@if($krs->dosen_mk == Auth::user()->dosen->nidn)
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
												<input type="text" value="{{$krs->kategori->nama_singkat}}" name="krs_name" class="d-none">
												<input type="text" value="{{$krs->id}}" name="krs_id" class="d-none">
                                            </div>
											<div class="d-flex mt-2">
												<button type="submit" class="badge ms-auto bg-primary border border-0">Buat</button>
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
								<a href="/krs/{{$krs->id}}/regulasi" class="nav-link">
									<i class="ph-list-checks me-2"></i>
									Regulasi
								</a>
							</li>
							<li class="nav-item">
								<a href="/krs/{{$krs->id}}/poin_penilaian" class="nav-link">
									<i class="ph-list-checks me-2"></i>
									Poin Penilaian
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
						<!-- Sidebar tabs -->
						<ul class="nav nav-tabs nav-tabs-highlight nav-justified px-3">
							<li class="nav-item">
								<a href="#dafta-user" class="nav-link active" data-bs-toggle="tab">
									<i class="ph-users"></i>
								</a>
							</li>

							<li class="nav-item">
								<a href="#tambah-user" class="nav-link" data-bs-toggle="tab">
									<i class="ph-user-plus"></i>
								</a>
							</li>
						</ul>
						<!-- /sidebar tabs -->
						<div class="sidebar-section-body">
							<div class="sidebar-content tab-content">
								<div class="tab-pane fade active show" id="dafta-user">
									<table class="table datatable-mahasiswa">
										<thead>
											<tr>
												<th><small>Dafrar Mahasiswa</small></th>
											</tr>
											<tr>
												<th>Dafrar Mahasiswa</th>
											</tr>
										</thead>
										<tbody>

											@foreach($krs->krs_user as $k)
											<tr>
												<td>
													<div class="d-flex mb-3">
														<a href="#" class="me-3">
															<img src="../../../assets/images/demo/users/face1.jpg" width="36" height="36" class="rounded-pill" alt="">
														</a>
														<div class="flex-fill">
															<a href="#" class="fw-semibold">{{$k->mahasiswa->user->nama}}</a>
															<div class="fs-sm opacity-50">{{$k->mahasiswa->nim}}</div>
														</div>
														<div class="ms-3 align-self-center">
															<div>
																<div class="btn-group">
																	<a href="#" class="text-muted" data-bs-toggle="dropdown"><i class="ph-gear-six"></i></a>
									
																	<div class="dropdown-menu">
																		<a href="#" class="dropdown-item text-danger">Hapus</a>
																		<a href="#" class="dropdown-item">Another action</a>
																	</div>
																</div>
															</div>
	
														</div>
													</div>
												 </td>
											</tr>
											@endforeach
											{{-- @else
												<div class="text-center">
													<small class="text-danger ">belum ada mahasiswa di proyek ini</small>
												</div>
											@endif --}}
											
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade active" id="tambah-user">
									<form action="/users/krs/add" method="post"> 
										@csrf
										<input class="d-none" type="text" name="krs_id" value="{{$krs->id}}">
										<select data-placeholder="Pilih mahasiswa" multiple="multiple" id="permission_select_edit" name="mahasiswa[]" class="form-control select" required
											@if ($mahasiswa->count() <= 0) disabled @endif>
											<option></option>
											<optgroup label="Daftar Mahasiswa">
												@foreach ($mahasiswa as $m)
													@if(!in_array($m->user_id, $krs->krs_user->pluck('user_id')->toArray()))
														<option value="{{ $m->user->id }}">{{$m->user->nama}}</option>
													@endif
												@endforeach
											</optgroup>
										</select>
										@if($mahasiswa->count() < 0)
											<small class="text-danger">Tidak ada data mahasiswa ditemukan</small>
										@endif
										<div class="py-2">
											<button type="submit" class="btn btn-sm btn-primary w-100">Submit</button>
										</div>
									</form>
								</div>
							</div>

						</div>
					</div>
				</div>
				<!-- /online users -->

			</div>
			<!-- /sidebar content -->

		</div>
		<!-- /right sidebar -->
@endsection
@endif
@endif