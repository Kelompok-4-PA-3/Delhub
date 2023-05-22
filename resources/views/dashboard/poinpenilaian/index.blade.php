@extends('main')

@section('title')
    <title>Manajemen Poin Regulasis</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <link href="../../../assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">

@endpush

@section('breadscrumb')
    <a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
    <span class="breadcrumb-item active py-2"> Poin Penilaian </span>
@endsection     

@section('main0nava')

@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Poin Penilaian {{$title}}</h5>
            <div class="ms-auto d-flex">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#tambah_komponen_penilaian"><i class="ph-plus-circle"></i>&nbsp; TAMBAH POIN PENILAIAN</a>
                </label>
            </div>
        </div>

        <div class="card-body pb-0">

            @if (session()->has('success'))
                <div class="alert alert-success alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-success text-white">
                        <i class="ph-check-circle"></i>
                    </span>
                    <span class="fw-semibold">Berhasil!</span> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif(session()->has('failed'))
                <div class="alert alert-danger alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-danger text-white">
                        <i class="ph-check-circle"></i>
                    </span>
                    <span class="fw-semibold">Gagal!</span> {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
           

            <!-- /individual column searching (text inputs) -->
            <table class="table datatable-users w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Poin Penilaian</th>
                        <th>Bobot</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Poin Penilaian</th>
                        <th>Bobot</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($poin_penilaian as $pp)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {!! $pp->nama_poin !!}
                            </td>
                            <td class="text-center">{{ $pp->bobot }} %</td>
                            <td class="text-center">
                               @if ($pp->is_verified)
                                    <span class="badge p-2 bg-success rounded-pill bg-opacity-10 text-success">sudah diverifikasi</span>
                             @else
                                    <span class="badge p-2 bg-danger rounded-pill bg-opacity-10 text-danger">belum diverifikasi</span>
                             @endif
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $pp->id }}">
                                        <i class="ph-pen"></i>
                                    </a>
                                    <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $pp->id }}">
                                        <i class="ph-trash"></i>
                                    </a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal_edit{{ $pp->id }}" class="text-body" data-bs-popup="tooltip" title="detail">
                                        <i class="ph-eye"></i>
                                    </a>
                                    <a href="{{route('komponen_penilaian.index', ['kr' => $krs->id, 'poinPenilaian' => $pp->id])}}" class="text-body mx-2" data-bs-popup="tooltip" title="Komponen penilaian">
                                        <i class="ph-notebook"></i>
                                    </a>
                                    @if ($pp->is_verified)
                                        <div class="status-indicator-container">
                                            <a href="" class="text-body" data-bs-popup="tooltip" title="Bobot Role" data-bs-toggle="offcanvas" data-bs-target="#tambah_role_penilaian{{$pp->id}}">
                                                <i class="ph-user-list"></i>
                                            </a>
                                            @if ($pp->role_group_penilaian->where('is_verified',false)->count() > 0 || $pp->role_group_penilaian->count() <= 0)
                                                <span class="status-indicator bg-warning" data-bs-popup="tooltip" title="Role belum diverfikasi"></span>
                                            @else
                                                <span class="status-indicator bg-success" data-bs-popup="tooltip" title="Role sudah diverfikasi"></span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>

                         <!-- tambah penilaian -->
                        <div id="tambah_role_penilaian{{$pp->id}}" class="offcanvas offcanvas-end offcanvas-size-lg  @if (session()->has("store"))  {{session('store') == $pp->id ? 'show' : ''}} @endif" tabindex="-1">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title fw-semibold">Tambah Poin Penilaian</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                            </div>
                            <div class="offcanvas-body p-2">
                              <!-- Tabs -->
                              <ul class="nav nav-tabs nav-tabs-underline nav-justified">
                                    <li class="nav-item">
                                        <a href="#list-role{{$pp->id}}" class="nav-link active" data-bs-toggle="tab">
                                            Daftar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tambah-role{{$pp->id}}" class="nav-link" data-bs-toggle="tab">
                                            Request
                                        </a>
                                    </li>
                                </ul>
                                <!-- /tabs -->

                                <div class="tab-content card-body">
                                    <div class="tab-pane active fade show" id="list-role{{$pp->id}}">
                                        <div class="d-flex mb-1">
                                            <span>Total : </span>&nbsp;
                                            <h3 class="fw-semibold text-primary">{{$pp->role_group_penilaian->sum('bobot')}} %</h3>
                                            @if ($pp->role_group_penilaian->where('is_verified',false)->count() > 0 || $pp->role_group_penilaian->count() <= 0)
                                                <div class="ms-auto">
                                                    <form action="/krs/{{$krs->id}}/poin_penilaian/store/{{$pp->id}}/role/verifikasi" method="post">
                                                        @csrf
                                                        <button class="btn btn-primary btn-sm " type="submit">Verifikasi &nbsp;<span class="px-1 bg-warning rounded-pill">{{$pp->role_group_penilaian->count()}}</span></button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="ms-auto">
                                                    <form action="/krs/{{$krs->id}}/poin_penilaian/store/{{$pp->id}}/role/verifikasi" method="post">
                                                        @csrf
                                                        <input type="hidden" name="cancel" value="1">
                                                        <button class="btn btn-warning btn-sm " type="submit">Batalkan verifikasi</button>
                                                    </form>
                                                </div>
                                            @endif
                                            
                                        </div>
                                        @if ($pp->role_group_penilaian->where('is_verified',false)->count() > 0 || $pp->role_group_penilaian->count() <= 0)
                                            <small class="fw-semibold text-warning">
                                                [ <i class="ph-warning-circle"></i> not verified ]
                                            </small>
                                        @else
                                            <small class="fw-semibold text-success">
                                                [ <i class="ph-check-circle"></i> verified ]
                                            </small>
                                        @endif
                                        <div class="list-group">
                                          
                                        @foreach ($pp->role_group_penilaian as $prp)
                                            {{-- @if ($prp->role_group_penilaian) --}}
                                                <div class="list-group-item d-flex">
                                                    <div>
                                                        {{-- @if ($prp->role_group_penilaian)
                                                            @if ($prp->role_group_penilaian->nama) --}}
                                                                <h5 class="fw-light">{{$prp->role_group->nama}}</h5>
                                                            {{-- @endif
                                                        @endif --}}
                                                        Bobot : <span class="fw-semibold">{{$prp->bobot}} %</span>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $prp->id }}">
                                                            <i class="ph-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @endforeach
											{{-- <a href="#" class="list-group-item list-group-item-action">Pembimbing</a> --}}
										</div>
                                    </div>
                                    <div class="tab-pane fade show {{session()->has("poin".$pp->id) ? 'active' : ''}}" id="tambah-role{{$pp->id}}">
                                        <form action="/krs/{{$krs->id}}/poin_penilaian/store/{{$pp->id}}/role" method="post">
                                            @csrf
                                            <input type="hidden" name="krs_id" value="{{$krs->id}}">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <div class="mt-2">
                                                        <label class="form-label">Pilih role</label>
                                                        <select data-placeholder="Pilih dosen" name="role_group_id" class="form-control select" required>
                                                            <option></option>
                                                            <optgroup label="Daftar Dosen">
                                                                @foreach($role_krs as $rl)
                                                                    <option value="{{$rl->id}}"
                                                                        {{ in_array($rl->id, old('role_group_id', [])) ? 'selected' : '' }}
                                                                        >{{Str::limit($rl->nama,30)}}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        </select>
                                                        @error('role_group_id')
                                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mt-2">
                                                        <label class="form-label">Bobot</label>
                                                        <div class="form-control-feedback form-control-feedback-end mb-3">
                                                            <input type="number" class="form-control" value="{{old('bobot')}}" name="bobot" placeholder="Masukkan bobot penilaian anda disini..." step="0.01" min="0" max="100">
                                                            <div class="form-control-feedback-icon">
                                                                <i class="ph-percent ph-sm"></i>
                                                            </div>
                                                        </div>
                                                        @error('bobot')
                                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="border-top p-3">
                                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- tambah penilaian --}}
                        @foreach ($pp->role_group_penilaian as $prp)
                             <!-- Delete Modal -->
                             <div id="modal_hapus{{ $prp->id }}" class="modal fade" tabindex="-1">
                                <div class="modal-dialog modal-xs">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            Apakah anda yakin ingin menghapus data ini ?
                                        </div>

                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <form action="/krs/{{$krs->id}}/poin_penilaian/delete/{{$pp->id}}/role/{{$prp->id}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Ya</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Delete Modal -->
                        @endforeach

                        <!-- Delete Modal -->
                        <div id="modal_hapus{{ $pp->id }}" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-xs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Apakah anda yakin ingin menghapus data ini ?
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{route('poin-penilaian.delete', ['kr' => $krs->id, 'poinPenilaian' => $pp->id])}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Ya</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Delete Modal -->

                        <!-- Delete Modal -->
                        <div id="modal_edit{{ $pp->id }}" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="ph-warning text-warning"></i> {{$pp->nama_poin}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-4">
                                                Poin penilaian 
                                            </div>
                                            <div class="col-1">
                                                 :
                                            </div>
                                            <div class="col-6">
                                                {{$pp->nama_poin}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                Bobot 
                                            </div>
                                            <div class="col-1">
                                                :
                                           </div>
                                           <div class="col-6">
                                               {{$pp->bobot}}
                                           </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                Role Penilai 
                                            </div>
                                            <div class="col-1">
                                                :
                                            </div>
                                            <div class="col-6">
                                                @if ($pp->role_group_penilaian->count() > 0)
                                                    @foreach ($pp->role_group_penilaian as $prl)
                                                    @if ($prl->role_group != NULL)
                                                        <small>{{$prl->role_group->nama}}</small><br>
                                                    @endif
                                                    @endforeach
                                                @else 
                                                    <small>Belum diassign ke role manapun</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Delete Modal -->

                        <!-- Sticky footer -->  
                          <!-- Large panel -->
                            <div id="form-edit{{$pp->id}}" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title fw-semibold">Edit Poin Penilaian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>

                                <div class="offcanvas-body p-2">
                                    <form action="{{route('poin-penilaian.edit', ['kr' => $krs->id, 'poinPenilaian' => $pp->id])}}" method="post">
                                        {{-- /krs/{{$krs->id}}/poin_penilaian/{{$pp->id}}/edit --}}
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <div class="mt-2">
                                                    <label class="form-label">Poin Penilaian</label>
                                                    <input class="form-control" value="{{old('nama_poin',$pp->nama_poin)}}" name="nama_poin" placeholder="Masukkan poin penilaian anda disini..." required>
                                                    @error('nama_poin')
                                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mt-2">
                                                    <label class="form-label">Poin Penilaian</label>
                                                    <div class="form-control-feedback form-control-feedback-end mb-3">
                                                        <input type="number" class="form-control" value="{{old('bobot',$pp->bobot)}}" name="bobot" placeholder="Masukkan bobot penilaian anda disini..." step="0.01" min="0" max="100">
                                                        <div class="form-control-feedback-icon">
                                                            <i class="ph-percent ph-sm"></i>
                                                        </div>
                                                    </div>
                                                    @error('komponen_penilaian')
                                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                {{-- <div class="mt-2">
                                                    <label class="form-label">Pilih role</label>
                                                    <select data-placeholder="Pilih dosen" multiple="multiple" name="role_group_id[]" class="form-control select" required>
                                                        <option></option>
                                                        <optgroup label="Daftar Dosen">
                                                            @foreach($role_krs as $rl)
                                                                <option value="{{$rl->id}}"
                                                                    {{ in_array($rl->id, old('role_group_id', $pp->role_group_penilaian->pluck('role_group_id')->toArray())) ? 'selected' : '' }}
                                                                    >{{Str::limit($rl->nama,30)}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                    @error('nidn')
                                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="border-top p-3">
                                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <!-- /large panel -->
                        <!-- /sticky footer -->

                    @endforeach 
                </tbody>
            </table>
            <br>
            @if ($poin_penilaian->where('is_verified',false)->count())
                <div style="position:relative">
                    <div class="d-flex p-1">
                        <form action="/krs/{{$krs->id}}/poin_penilaian/verifikasi" class="ms-auto" method="post">
                            @csrf
                            <button class=" btn btn-sm btn-success" type="submit"><i class="ph-upload"></i>&nbsp;<i class="fw-semibold"> VERIFIKASI SELURUH POIN PENILAIAN</i> &nbsp;<span class="bg-danger px-1 fw-semibold">{{$poin_penilaian->where('is_verified',false)->count()}}</span></butt>
                        </form>
                    </div>
                </div>
            @endif
            <br>
        </div>
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>


    @if($poin_penilaian->where('is_verified', false)->count() > 0)
     <!-- Top panel -->
	<div id="panel_top" class="offcanvas offcanvas-top show" tabindex="-1">
		<div class="offcanvas-body">
            <div>
                <h3>Pemberitahuan : </h3>
            </div>
			<div class="d-lg-flex">
				<span class="flex-lg-1 me-lg-3">
                    Sepertinya terdapat poin penilaian yang belum diverifikasi atau telah dihapus, silahkan verifikasi ulang seluruh poin penilaian agar dapat digunakan pada fitur penilaian.
                    <br><i>Note : Pastikan jumlah seluruh bobot tepat 100%</i>
                </span>
				<div class="ms-lg-auto mt-3 mt-lg-auto mb-lg-auto flex-nowrap">
                     <form action="/krs/{{$krs->id}}/poin_penilaian/verifikasi" class="ms-auto" method="post">
                            @csrf
                            <button class=" btn btn-sm btn-success" type="submit"><i class="ph-upload"></i>&nbsp;<i class="fw-semibold"> VERIFIKASI </i> &nbsp;<span class="bg-danger px-1 fw-semibold">{{$poin_penilaian->where('is_verified',false)->count()}}</span></button>
					        <button type="button" class="btn btn-link ms-2" data-bs-dismiss="offcanvas">Nanti</button>
                    </form>
				</div>
			</div>
		</div>
	</div>
	<!-- /top panel -->
    @endif

    <!-- Sticky footer -->  
        <!-- Large panel -->
        <div id="tambah_komponen_penilaian" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
          <div class="offcanvas-header">
              <h5 class="offcanvas-title fw-semibold">Tambah Poin Penilaian</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
          </div>

          <div class="offcanvas-body p-2">
              <form action="{{route('poin-penilaian-store', ['kr' => $krs->id])}}" method="post">
                  {{-- /krs/{{$krs->id}}/poin_penilaian/{{$pp->id}}/edit --}}
                  @csrf
                  <div class="modal-body">
                      <div class="mb-3">
                          <div class="mt-2">
                              <label class="form-label">Poin Penilaian</label>
                              <input class="form-control" value="{{old('nama_poin')}}" name="nama_poin" placeholder="Masukkan poin penilaian anda disini..." required>
                              @error('nama_poin')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                              @enderror
                          </div>
                          <div class="mt-2">
                              <label class="form-label">Bobot Penilaian</label>
                              <div class="form-control-feedback form-control-feedback-end mb-3">
                                    <input type="number" class="form-control" value="{{old('bobot')}}" name="bobot" placeholder="Masukkan bobot penilaian anda disini..." step="0.01" min="0" max="100">
                                    <div class="form-control-feedback-icon">
                                        <i class="ph-percent ph-sm"></i>
                                    </div>
                              </div>
                              @error('komponen_penilaian')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                    </div>
                              @enderror
                          </div>
                          {{-- <div class="mt-2">
                              <label class="form-label">Pilih role</label>
                              <select data-placeholder="Pilih dosen" multiple="multiple" name="role_group_id[]" class="form-control select" required>
                                <option></option>
                                <optgroup label="Daftar Dosen">
                                    @foreach($role_krs as $rl)
                                        <option value="{{$rl->id}}"
                                            {{ in_array($rl->id, old('role_group_id')) ? 'selected' : '' }}
                                            >{{Str::limit($rl->nama,30)}}</option>
                                    @endforeach
                                </optgroup>
                              </select>
                              @error('nidn')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                              @enderror
                          </div> --}}
                      </div>
                  </div>
                  <div class="border-top p-3">
                      <button type="submit" class="btn btn-primary w-100">Submit</button>
                  </div>
              </form>
          </div>
        </div>
        <!-- /large panel -->
        <!-- /sticky footer -->
@endsection
