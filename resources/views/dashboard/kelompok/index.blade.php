@extends('main')
   
@section('title')
    <title>Manajemen Anggota</title>
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

@section('breadscrumb')
	@role('dosen')
		<a href="/koordinator/myproject" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
		<a href="/koordinator/proyeksaya/{{$kelompok->krs->id}}" class="breadcrumb-item py-2"> {{$kelompok->krs->kategori->nama_singkat}}</a>
	@endrole
	@role('mahasiswa')
		<a href="/home" class="breadcrumb-item py-2"> Home</a>
	@endrole
	<span class="breadcrumb-item active py-2">{{$kelompok->nama_kelompok}}</span>
@endsection

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
                <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}" class="nav-link"> <i class="ph-squares-four"></i> &nbsp; Kelompok</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Artefak</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Manajemen</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Tugas</a></li>
                <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}/orang" class="nav-link active"> <i class="ph-users"></i> &nbsp; Orang</a></li>
                {{-- @if (Auth::user()->dosen() != NULL)
                    @if (array_intersect(Auth::user()->dosen->role_kelompok($kelompok->id)->pluck('id')->toArray(), $kelompok->role_kelompok->pluck('id')->toArray())) --}}
                
                @role('dosen')
                    <li class="nav-item">
                        <a href="" class="nav-link btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><i class="ph-notebook"></i> &nbsp; Penilaian</a>
                        <div class="dropdown-menu">
                            @foreach (Auth::user()->dosen->role_kelompok->where('kelompok_id',$kelompok->id) as $myrole)
                            @if ($myrole->role_group != NULL)
                                <div class="list-group">
                                    <div class="d-flex">
                                        <a @if($myrole->is_verified) href="/kelompok/{{$kelompok->id}}/penilaian/role/{{$myrole->id}}" @endif  class="dropdown-item"><i class="ph-notebook"></i> &nbsp;{{$myrole->role_group->nama}} &nbsp; @if(!$myrole->is_verified) <i class="ph-warning-circle text-warning" style="cursor:pointer;" data-bs-popup="tooltip" title="Role anda belum diverfikasi"></i> @endif</a>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                        </div>
                    </li>
                @endrole
                
                    {{-- @endif
                @endif --}}
                {{-- {{Auth::user()->dosen->role_kelompok($kelompok->id)}} --}}
                @role('dosen')
                    @if ($kelompok->krs->dosen_mk == Auth::user()->dosen->nim || $kelompok->krs->dosen_mk_2 == Auth::user()->dosen->nim)
                        <li class="nav-item">
                            <a href="/kelompok/{{$kelompok->id}}/penilaian/koordinator" class="nav-link btn btn-primary"><i class="ph-notebook"></i> &nbsp; Hasil Penilaian</a>
                        </li>
                    @endif  
                @endrole
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
					@if($kelompok->krs->dosen_mk == Auth::user()->dosen->nidn || $kelompok->krs->dosen_mk_2 == Auth::user()->dosen->nidn)
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
							</tr>
						</thead>
						<tbody>
							@foreach ($anggota as $a)
								<tr>
									<td>
										{{-- <div class="container"><input type="checkbox" class="form-check-input"></div> --}}
									</td>
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
											@role('dosen')
											<small>
												<form action="/kelompok/people/delete" method="post">
													@csrf
													<input type="hidden" name="mahasiswa" value="{{$a->nim}}">
													<input type="hidden" name="kelompok" value="{{$a->kelompok_id}}">
													<button class="text-danger bg-transparent border-0" type="submit"><i class="ph-trash"></i></button>
												</form>
											</small>
											@endrole

										</div>
									</td>
							   	</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@if(Auth::user()->dosen()->count() > 0)
			@if($kelompok->krs->dosen_mk == Auth::user()->dosen->nidn || $kelompok->krs->dosen_mk_2 == Auth::user()->dosen->nidn)
						<div class="tab-pane fade show" id="tambah-anggota">
							<div class="card p-3">
								<div class="p-3">
									<form action="/kelompok/people/add" method="post">
										@csrf
										<p>Tambah Anggota Kelompok</p>
										<input type="hidden" name="kelompok" value="{{$kelompok->id}}">
										<div class="py-2">
											<select data-placeholder="Pilih mahasiswa" name="mahasiswa[]" multiple="multiple" class="form-control select" required>
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
@endsection

@push('remove-scroll')
<script>
	const elements = document.getElementsByClassName("dataTables_scrollBody");
	console.log(elements.length);
</script>
@endpush