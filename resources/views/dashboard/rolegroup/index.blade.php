@extends('main')

@section('title')
    <title>Manajemen Role Group</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <link href="../../../assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">

@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Role Group</h5>
            <div class="ms-auto d-flex">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#tambah_role_group"><i class="ph-plus-circle"></i>&nbsp; TAMBAH ROLE GROUP</a>
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
            {{-- {{ $role_group->where}} --}}
            @if ($role_group->count() > 0 && $role_group->where('nama','Koordinator')->where('deleted_at','==',NULL)->count() > 0)
            <table class="table datatable-users w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Bobot</th>
                        <th>Akumulasi bobot</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Bobot</th>
                        <th>Akumulasi bobot</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($role_group as $rg)
                        {{-- @if ()
                            
                        @endif --}}
                        {{-- @if ($rg->krs_id == $krs->id) --}}
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rg->nama }}</td>
                            <td>{{ $rg->bobot }} %</td>
                            <td class="">
                                @if ($rg->komponen_penilaian->count() > 0)
                                    @php
                                        $total_bobot = $rg->komponen_penilaian->sum('bobot');
                                    @endphp
                                    <div class="d-flex">
                                        <p class=" text-primary "> <img src="{{asset('/img/R1.gif')}}" alt="" style="max-width: 50px;"> {{$total_bobot}} %</p>
                                        {{-- <p>{{$rg}}</p> --}}
                                    </div>
                                @else 
                                    <p class="fw-bold text-center">-</p>
                                @endif
                            </td>
                            @if ($rg->komponen_penilaian->count() > 0)
                                @if (!$rg->is_verified)
                                    @if ($total_bobot == 100)
                                        @if ($rg->komponen_penilaian->where('is_verified',false)->count() < 1)
                                            <td class="text-center bg-success bg-opacity-10">
                                                {{-- <small class="fw-semibold text-success"> <i class="ph-checks"></i> Memenuhi</small> --}}
                                                <form action="/krs/{{$krs->id}}/role_group/verifikasi/{{$rg->id}}" class="ms-auto" method="post">
                                                    @csrf
                                                    <button class="btn btn-sm btn-success">Buka akses penilaian</button>
                                                </form>
                                            </td>
                                        @else 
                                            <td class="text-center bg-secondary bg-opacity-10">
                                                <small class="text-secondary fw-bold">Tidak terverifikasi</small>
                                            </td>
                                        @endif
                                       
                                    @elseif($total_bobot < 100)
                                        <td class="text-center bg-primary bg-opacity-10 ">
                                            <small class="fw-semibold text-primary">Belum memenuhi</small>
                                        </td>
                                    @else 
                                        <td class="text-center bg-danger bg-opacity-10">
                                            <small class="fw-semibold text-danger">Melebihi</small>
                                        </td>
                                    @endif
                                    {{-- @php
                                        $total_bobot = 0;
                                    @endphp --}}
                                @else 
                                    <td class="text-center bg-success bg-opacity-10">
                                         <small class="fw-semibold text-success"> <i class="ph-checks"></i> Memenuhi</small>
                                    </td>
                                @endif
                            @else
                                <td class="text-center bg-secondary bg-opacity-10">
                                    <small class="fw-semibold text-secondary">__</small>
                                </td>
                            @endif
                                
                                {{-- @if ($rg->is_verified)
                                     <span class="badge p-2 bg-success rounded-pill bg-opacity-10 text-success">sudah diverifikasi</span>
                              @else
                                     <span class="badge p-2 bg-danger rounded-pill bg-opacity-10 text-danger">belum diverifikasi</span>
                              @endif --}}
                            {{-- <td>
                                <button class="btn btn-sm btn-outline-success">verifikasi</button>
                            </td> --}}
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah"
                                        data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $rg->id }}">
                                        <i class="ph-pen"></i>
                                    </a>

                                    <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                        data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $rg->id }}">
                                        <i class="ph-trash"></i>
                                    </a>

                                    @if (!$rg->is_verified)
                                    <a href="{{route('role_kelompok_penilaian.index',['kr' => $krs->id, 'role' => $rg->id])}}" class="text-body" data-bs-popup="tooltip" title="Komponen penilaian">
                                        <i  class="ph-notebook"></i>
                                    </a>
                                    @else 
                                       

                                        <div class="btn-group">
                                            <a class="text-warning fw-bold" href="" data-bs-toggle="dropdown"><i class="ph-warning-circle"></i></a>
                                            {{-- <a href="#" class="btn btn-primary dropdown-toggle" >Submenu on click</a> --}}
    
                                            <div class="dropdown-menu">
                                                <div class="px-2">
                                                    <small>
                                                        Saat ini penilaian pada role ini sudah diverifikasi,<br> apakah anda ingin membatalkannya?
                                                    </small>
                                                </div>
                                                <div class="p-2">
                                                    <form action="/krs/{{$krs->id}}/role_group/verifikasi/{{$rg->id}}" method="post">   
                                                        @csrf
                                                        <input type="hidden" name="cancel" value="1">
                                                        <button href="#" class="btn btn-warning btn-sm">Batalkan verifikasi</button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        <!-- Delete Modal -->
                        <div id="modal_hapus{{ $rg->id }}" class="modal fade" tabindex="-1">
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
                                        <form action="{{route('role_group.delete', ['kr' => $krs->id, 'roleGroupKelompok' => $rg->id])}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Ya</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Delete Modal -->

                        <!-- Sticky footer -->  
                          <!-- Large panel -->
                            <div id="form-edit{{$rg->id}}" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title fw-semibold">Edit Poin Penilaian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>

                                <div class="offcanvas-body p-2">
                                    <form action="{{route('role_group.edit', ['kr' => $krs->id, 'roleGroupKelompok' => $rg->id])}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <div class="mt-2">
                                                    <label class="form-label">Role Group</label>
                                                    <input class="form-control" value="{{old('nama',$rg->nama)}}" name="nama" placeholder="Masukkan poin penilaian anda disini..." required>
                                                    @error('nama')
                                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mt-2">
                                                    <label class="form-label">Bobot</label>
                                                    <div class="form-control-feedback form-control-feedback-end mb-3">
                                                        <input type="number" class="form-control" value="{{old('bobot',$rg->bobot)}}" name="bobot" placeholder="Masukkan bobot penilaian anda disini..." step="0.01" min="0" max="100">
                                                        <div class="form-control-feedback-icon">
                                                            <i class="ph-percent ph-sm"></i>
                                                        </div>
                                                    </div>
                                                    @error('bobot')
                                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                        </div>
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
                        <!-- /large panel -->
                        <!-- /sticky footer -->
                        {{-- @endif --}}

                    @endforeach 
                </tbody>
            </table>
            @else 
                <!-- Top panel -->
                <div id="panel_top" class="offcanvas offcanvas-top show" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                    <div class="offcanvas-body">
                        <div class="d-lg-flex">
                            <span class="flex-lg-1 me-lg-3">
                                <div class="container">
                                    <h3>Pemberitahuan : </h3>
                                    <h3 class="fw-light">Sepertinya koordniator krs ini belum memiliki bobot penilaian, tetapkan bobot penilaian koordinator terlebih dahulu</h3>
                                </div>
                                <br><i>Note : Pastikan jumlah seluruh bobot tepat 100%</i>
                            </span>
                            <div class="ms-lg-auto mt-3 mt-lg-auto mb-lg-auto flex-nowrap">
                                <form action="/krs/{{$krs->id}}/role_group/store" class="ms-auto" method="post">
                                        @csrf
                                        <input type="number" class="form-control" name="bobot" value="{{old('bobot')}}" max="100" required>
                                        <input type="hidden" class="form-control" name="nama" value="Koordinator" max="100" required>
                                        <input type="hidden" class="form-control" name="koordinator" value="1">
                                        @error('bobot')
                                            <div class="text-danger">
                                                {{$message}}
                                            </div>
                                        @enderror
                                        <button class=" btn btn-sm btn-primary mt-1" type="submit"><i class="ph-upload"></i>&nbsp;<i class="fw-semibold">Tetapkan</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /top panel -->
            @endif
            
            <br>
            @if ($role_group->where('is_verified',false)->count())
                <div style="position:relative">
                    <div class="d-flex p-1">
                        <form action="/krs/{{$krs->id}}/role_group/verifikasi" class="ms-auto" method="post">
                            @csrf
                            <button class=" btn btn-sm btn-success" type="submit"><i class="ph-upload"></i>&nbsp;<i class="fw-semibold"> VERIFIKASI SELURUH POIN PENILAIAN</i> &nbsp;<span class="bg-danger px-1 fw-semibold">{{$role_group->where('is_verified',false)->count()}}</span></butt>
                        </form>
                    </div>
                </div>
            @endif
            <br>
        </div>
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>


    <!-- Large panel -->
	<div id="tambah_role_group" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title fw-semibold">Tambah Role Group</h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>

		<div class="offcanvas-body p-2">
            <form action="/krs/{{$krs->id}}/role_group/store" method="post">
                @csrf
                <input type="hidden" name="krs_id" value="{{$krs->id}}">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="mt-2">
                            <label class="form-label">Role Group</label>
                            <input class="form-control" name="nama" value="{{old('nama')}}" placeholder="Masukkan role group anda disini..." required>
                            @error('nama')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
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
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
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

    @if($role_group->where('is_verified', false)->count() > 0)
    <!-- Top panel -->
   <div id="panel_top" class="offcanvas offcanvas-top show" tabindex="-1">
       <div class="offcanvas-body">
           <div>
               <h3>Pemberitahuan : </h3>
           </div>
           <div class="d-lg-flex">
               <h5 class="flex-lg-1 fw-light me-lg-3">
                   Sepertinya terdapat role yang memiliki akumulasi bobot tidak mencapai 100% atau melebihinya, silahkan verifikasi ulang seluruh role dan pastikan akumulasi bobot tepat 100%.
                   <br><i>Note : Pastikan jumlah seluruh bobot tepat 100%</i>
               </h5>
               <div class="ms-lg-auto mt-3 mt-lg-auto mb-lg-auto flex-nowrap">
                    <form action="/krs/{{$krs->id}}/role_group/verifikasi/" class="ms-auto" method="post">
                           @csrf
                           {{-- <button class=" btn btn-sm btn-success" type="submit"><i class="ph-upload"></i>&nbsp;<i class="fw-semibold"> VERIFIKASI </i> &nbsp;<span class="bg-danger px-1 fw-semibold">{{$role_group->where('is_verified',false)->count()}}</span></button> --}}
                           <button type="button" class="btn btn-link ms-2" data-bs-dismiss="offcanvas">Saya mengerti</button>
                   </form>
               </div>
           </div>
       </div>
   </div>
   <!-- /top panel -->
   @endif
   
@endsection
