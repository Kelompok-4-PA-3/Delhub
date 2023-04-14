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
	<script src="{{asset('/assets/js/vendor/tables/datatables/extensions/key_table.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_extension_key_table.js')}}"></script>
    {{-- <script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script> --}}
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')

	<style>
		.dataTables_scrollBody{
			padding-top: 30px;
			padding-bottom: 30px;
		}
		.datatable-scroll-wrap {
			overflow: auto !important;
			height: auto !important;
		}
		.dataTables_scroll {
			overflow: auto !important;
			height: auto !important;
		}
		.dataTables_scrollBody {
			overflow: auto !important;
			height: auto !important;
		}
	</style>

    <div class="row">
        <div class="mb-2">
            <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}" class="nav-link {{ (request()->is('/kelompok/{id}')) ? 'active' : '' }}"> <i class="ph-squares-four"></i> &nbsp; Kelompok</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Artefak</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Manajemen</a></li>
                <li class="nav-item"><a href="#" class="nav-link {{ (request()->is('/kelompok/orang')) ? 'active' : '' }}"> <i class="ph-folders"></i> &nbsp; Tugas</a></li>
                <li class="nav-item"><a href="/kelompok" class="nav-link  active"> <i class="ph-users"></i> &nbsp; Orang</a></li>
            </ul>
        </div>
		
		
		<div class="nav-tabs-responsive card">
			<ul class="nav nav-tabs nav-tabs-underline flex-nowrap mt-2">
				<li class="nav-item">
					<a href="#daftar-anggota" class="nav-link active" data-bs-toggle="tab">
						<i class="ph-list me-2"></i>
						Anggota
					</a>
				</li>
				@if(Auth::user()->dosen()->count() > 0)
					@if($kelompok->krs->dosen_mk == Auth::user()->dosen->nidn)
						<li class="nav-item">
							<a href="#tambah-anggota" class="nav-link" data-bs-toggle="tab">
								<i class="ph-users-three me-2"></i>
								Tambah Anggota
							</a>
						</li>
					@endif
				@endif
			</ul>
		</div>

		<div class="tab-content">
			<div class="tab-pane fade show active" id="daftar-anggota">
				<div class="card">
					<table class="table datatable-people">
						<thead class="">
							<tr class="">
								{{-- <th></th>
								<th></th>
								<th></th> --}}
							</tr>
						</thead>
						<tbody>
							@foreach ($anggota as $a)
								<tr>
									<td><div class="container"><input type="checkbox" class="form-check-input"></div></td>
									<td>
										<div class="d-flex">
											<div class="px-2">
												<img src="../../../assets/images/demo/users/face11.jpg" class="w-32px h-32px rounded-pill" alt="">
											</div>
										<div>
											<a class="fw-semibold" href="">{{$a->mahasiswa->user->nama}}</a><br>
											<small class="text-muted">{{$a->mahasiswa->nim}}</small>
										</div>
										</div>
									</td>
									<td class="text-center">	
										<div class="d-inline-flex">
											<div class="px-4">
												<small class="text-muted">{{ucfirst($a->reference->value)}}</small>
											</div>
											<small>
												<form action="/kelompok/people/delete" method="post">
													@csrf
													<input type="hidden" name="mahasiswa" value="{{$a->nim}}">
													<input type="hidden" name="kelompok" value="{{$a->kelompok_id}}">
													<button class="text-danger bg-transparent border-0" type="submit"><i class="ph-trash"></i></button>
												</form>
											</small>
										</div>
									</td>
							   	</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@if(Auth::user()->dosen()->count() > 0)
					@if($kelompok->krs->dosen_mk  == Auth::user()->dosen->nidn)
						<div class="tab-pane fade show" id="tambah-anggota">
							<div class="card p-3">
								<div class="p-3">
									<form action="/kelompok/people/add" method="post">
										@csrf
										<p>Tambah Anggota Kelompok</p>
										<input type="hidden" name="kelompok" value="{{$kelompok->id}}">
										<div class="py-2">
											<select data-placeholder="Pilih mahasiswa" name="mahasiswa" multiple="multiple" class="form-control select" required>
												<option></option>
												<optgroup label="Daftar mahasiswa">
													@foreach($mahasiswa as $km)
														@if(!in_array($km->mahasiswa->nim, $anggota->pluck('nim')->toArray()))
														<option value="{{$km->mahasiswa->nim}}">
															<div>
																{{$km->mahasiswa->user->nama}} - {{$km->mahasiswa->nim}} (<small>Design, Coding</small>)<br>
															</div>
														</option>
														@endif
													@endforeach
												</optgroup>
											</select>
										</div>
										<div class="py-2">
											<select data-placeholder="Pilih Kategori" name="role" class="form-control select" required>
												@foreach ($role_kelompok as $rk)
													<option value="{{$rk->id}}" selected>{{ucfirst($rk->value)}}</option>
												@endforeach
											</select>
										</div>
										<div>
											<button type="submit" class="btn btn-sm btn-primary w-100">Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					@endif
				@endif
		</div>

    </div>

	{{-- @if (session()->has('success'))
	<div class="border rounded p-2 p-lg-4 mb-4">
		<div class="toast bg-success text-white border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true" style="margin: auto;">
			<div class="toast-header bg-black bg-opacity-10 text-white">
				<div class="fw-semibold me-auto">Berhasil !!</div>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body">
				{{session('success')}}
			</div>
		</div>
	</div>
	@endif --}}
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
						</div>
					</div>
				</div>
				<!-- /online users -->

			</div>
			<!-- /sidebar content -->

		</div>
		<!-- /right sidebar -->

@endsection

{{-- @if (session()->has('success'))
<div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
	<div class="toast-header bg-light text-success">
	  <i class="ph-circle-wavy-check"></i>
	  <strong class="me-auto">&nbsp;Berhasil</strong>
	  <button type="button" class="btn-close text-white" data-bs-dismiss="toast" aria-label="Close"></button>
	</div>
	<div class="toast-body d-flex">
	  <h5>&#128522;</h5>&nbsp;<small class="text-muted">{{session('success')}}</small>
	</div>
  </div>
</div>
@endif --}}

@push('remove-scroll')
<script>
	const elements = document.getElementsByClassName("dataTables_scrollBody");
	console.log(elements.length);
</script>
@endpush