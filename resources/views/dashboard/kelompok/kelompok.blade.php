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
    <script src="{{asset('/assets/js/vendor/ui/moment/moment.min.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/pickers/daterangepicker.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/pickers/datepicker.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/picker_date.js')}}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="row">

        <div class="mb-2">
            <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                <li class="nav-item"><a href="#" class="nav-link active"> <i class="ph-squares-four"></i> &nbsp; Kelompok</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Artefak</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Manajemen</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Tugas</a></li>
                <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}/orang" class="nav-link"> <i class="ph-users"></i> &nbsp; Orang</a></li>
            </ul>
        </div>

        <div class="col-xl-7">

            <div class="p-2 card">
                <div class="d-lg-flex">
                    <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                        <li class="nav-item">
                            <a href="#topik-proyek" class="nav-link active" data-bs-toggle="tab">
                                <i class="ph-user-circle me-2"></i>
                                Topik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#edit-topik" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-pencil me-2"></i>
                                Edit
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content flex-lg-fill">
                        <div class="tab-pane fade show active" id="topik-proyek">
                            <div class="px-2">
                                <small class="text-muted ">Topik : </small>
                            </div>
                            @if ($kelompok->topik == NULL)
                                <small class="p-2">Kelompok ini belum memiliki topik</small>
                            @else
                            <h5 class="fw-semibold p-2">{{$kelompok->topik}}</h5>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="edit-topik">
                           <form action="/kelompok/topik" method="post">
                            @csrf
                            <input type="hidden" value="{{$kelompok->id}}" name="kelompok">
                            <input type="text" class="form-control" name="topik" value="{{old('topik',$kelompok->topik)}}" placeholder="Masukkan topik disini" required>
                            <div class="p-1">
                                <button class="btn btn-sm btn-primary w-100">Kirim</button>
                            </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-2 card">
                <div class="d-lg-flex">
                    <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                        <li class="nav-item">
                            <a href="#pembimbing" class="nav-link active" data-bs-toggle="tab">
                                <i class="ph-user-circle me-2"></i>
                                Pembimbing
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#penguji" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-user-circle me-2"></i>
                                Penguji
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#edit-dosen" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-pencil me-2"></i>
                                Edit
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content flex-lg-fill">
                        <div class="tab-pane fade show active" id="pembimbing">
                           <div class="d-flex p-2 mt-2">
                            <small class="text-muted ">Pembimbing : </small>
                            <div class="ms-auto">
                               <small class="" data-bs-popup="tooltip" title="hapus"> <a class="text-muted" href=""><i class="ph-trash"></i></a></small>
                            </div>
                           </div>
                            
                                @if ($kelompok->pembimbing == NULL)
                                    <small class="text-muted text-center px-2">Belum ada dosen pembimbing </small>
                                @else
                                    <h6 class="fw-semibold px-2">
                                        {{$kelompok->dosen->user->nama}}
                                    </h6>
                                @endif
                               

                           
                        </div>
                        
                        <div class="tab-pane fade active" id="penguji">
                            <div class="mt-1">
                                <div class="d-flex px-2">
                                    <small class="text-muted ">Penguji 1 : </small>
                                    <div class="ms-auto">
                                    <small class="" data-bs-popup="tooltip" title="hapus"> <a class="text-muted" href=""><i class="ph-trash"></i></a></small>
                                    </div>
                                </div>
                                @if ($kelompok->pembimbing == NULL)
                                    <small class="text-muted text-center px-2">Belum ada dosen penguji</small>
                                @else
                                    <h6 class="fw-semibold p-2">
                                        {{$kelompok->dosen->user->nama}}
                                    </h6>
                                @endif
                               
                            </div>
                            <div>
                                <div class="d-flex px-2">
                                    <small class="text-muted ">Penguji 2 : </small>
                                    <div class="ms-auto">
                                    <small class="" data-bs-popup="tooltip" title="hapus"> <a class="text-muted" href=""><i class="ph-trash"></i></a></small>
                                    </div>
                                </div>
                                @if ($kelompok->pembimbing == NULL)
                                    <small class="text-muted text-center px-2">Belum ada dosen penguji</small>
                                @else
                                    <h6 class="fw-semibold px-2">
                                        {{$kelompok->dosen->user->nama}}
                                    </h6>
                                @endif
                               
                            </div>
                        </div>

                        <div class="tab-pane fade" id="edit-dosen">
                           <form action="/kelompok/dosen" method="post">
                            @csrf
                            <input class="d-none" type="text" name="kelompok" value="{{$kelompok->id}}">
                            <div class="py-1">
                                <select data-placeholder="Pilih Dosen" name="dosen" class="form-control select" required>
                                    <option></option>
                                    <optgroup label="Daftar Dosen">
                                        @foreach($dosen as $d)
                                            @if($d->nidn != $kelompok->pembimbing)
                                                <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="py-1">
                            <select data-placeholder="Pilih Kategori" name="reference" class="form-control select" required>
                                <option></option>
                                <optgroup label="Daftar Kategori">
                                    <option value="pembimbing">Pembimbing</option>
                                    @foreach($reference as $r)
                                        <option value="{{$r->id}}">{{$r->value}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            </div>
                            <div class="p-1">
                                <button class="btn btn-sm btn-primary w-100">Kirim</button>
                            </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-xl-5">

            <!-- Sales stats -->
            <div class="card">
                <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                    <h5 class="py-sm-2 my-sm-1">Bimbingan</h5><br>
                    <div class="mt-2 mt-sm-0 ms-sm-auto">
                        <div class="d-flex mt-3">
                            <small class="text-muted">Total : </small>
                            <h1>{{$kelompok->bimbingan->count()}}</h1> / <h6 class="text-muted">8</h6>
                        </div>
                    </div>
                </div>
             
                <div class="card-body pb-0">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-tabs-underline nav-justified">
                        <li class="nav-item">
                            <a href="#list-bimbingan" class="nav-link active" data-bs-toggle="tab">
                                Daftar 
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#tambah-bimbingan" class="nav-link" data-bs-toggle="tab">
                                Request
                            </a>
                        </li>
                    </ul>
                    <!-- /tabs -->


                    <!-- Tabs content -->
                    <div class="tab-content card-body">
                        <div class="tab-pane active fade show" id="list-bimbingan">
                            <div class="">
                                <table class="table text-nowrap">
                                    <tbody>
                                        @if($kelompok->bimbingan->count() > 0)
                                        @foreach($kelompok->bimbingan as $kb)
                                        <tr>
                                            <td class="text-center">
                                                <h6 class="mb-0">{{Carbon\Carbon::parse($kb->waktu)->format('d')}}</h6>
                                                <div class="fs-sm text-muted lh-1 text-uppercase">{{Carbon\Carbon::parse($kb->waktu)->format('M')}}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <small><a href="#" class="text-body fw-semibold letter-icon-title">{{Str::limit($kb->description,20)}}</a></small>
                                                        <div class="d-flex align-items-center text-muted fs-sm">
                                                            <span class="
                                                            @if($kb->status == 'waiting')
                                                                bg-info
                                                            @elseif($kb->status == 'approved')
                                                                bg-success
                                                            @elseif($kb->status == 'rejected')
                                                                bg-danger
                                                            @elseif($kb->status == 'reschedule')
                                                                bg-warning
                                                            @endif
                                                             rounded-pill p-1 me-2"></span>
                                                            {{$kb->status}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                                        <i class="ph-list"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a href="/bimbingan/status/{{$status = 'approved'}}/{{$kb->id}}" class="dropdown-item">
                                                            <i class="ph-checks text-success me-2"></i>
                                                            Approve
                                                        </a>
                                                        <a href="/bimbingan/status/{{$status = 'rejected'}}/{{$kb->id}}" class="dropdown-item">
                                                            <i class="ph-x text-danger me-2"></i>
                                                            Rejected
                                                        </a>
                                                        <a href="/bimbingan/status/{{$status = 'reschedule'}}/{{$kb->id}}" class="dropdown-item">
                                                            <i class="ph-calendar-x text-info me-2"></i>
                                                            Reschedule
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                            <p class="text-muted text-center">Belum ada bimbingan tersedia</p> 
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane active fade" id="tambah-bimbingan">
                            <form action="/bimbingan" method="post">
                                @csrf
                                <input type="text" name="kelompok_id" value="{{$kelompok->id}}" class="d-none">
                                <div class="p-1">
                                    <label for="">Deskripsi</label>
                                    <textarea class="form-control" name="description" type="text" placeholder="Deskripsi bimbingan" required>{{old('deskripsi')}}</textarea>
                                </div>
                                <div class="p-1">
                                    <label for="">Waktu</label>
                                    <input class="form-control" value="{{old('deskripsi')}}" name="waktu" type="datetime-local" placeholder="waktu bimbingan" required>
                                </div>
                                <div class="p-1">
                                    <label for="">Ruangan</label>
                                    <select class="form-control" name="ruangan_id" placeholder="waktu bimbingan" required>
                                        @foreach($ruangan as $r)
                                            <option value="{{$r->id}}">Gedung Vokasi</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <button type="sumbit" class="btn btn-primary btn-sm w-100">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /tabs content -->

                   
                </div>

                <div class="chart mb-2" id="app_sales"></div>
                <div class="chart" id="monthly-sales-stats"></div>
            </div>
            <!-- /sales stats -->
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