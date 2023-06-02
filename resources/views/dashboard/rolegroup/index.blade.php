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

@section('breadscrumb')
    <a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
    <a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2">{{$krs->kategori->nama_singkat}}</a>
    <a href="/krs/{{$krs->id}}/kategori_role" class="breadcrumb-item py-2">Kategori Role</a>
    <span class="breadcrumb-item active py-2"> {{$kategori->nama}}</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Role Group {{$kategori->nama}}</h5>
            <div class="ms-auto d-flex">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#tambah_role_group"><i class="ph-plus-circle"></i>&nbsp; TAMBAH ROLE GROUP</a>
                </label>
            </div>
        </div>

        <div class="card-body pb-0">

            {{-- @if (session()->has('success'))
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
            @endif --}}
            <table class="table datatable-users w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($role_group as $rg)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rg->nama }} <small class="{{$rg->is_main ? 'text-primary' : 'text-warning'}}">{{$rg->is_main ? '( wajib )' : '(opsional)'}}</small> </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    @if (strtolower($rg->nama) != 'koordinator')
                                        <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah"
                                            data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $rg->id }}">
                                            <i class="ph-pen"></i>
                                        </a>

                                        <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                            data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $rg->id }}">
                                            <i class="ph-trash"></i>
                                        </a>
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
                                        <form action="/krs/{{$krs->id}}/role_group/{{$kategori->id}}/{{$rg->id}}/delete" method="post">
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
                                    <form action="/krs/{{$krs->id}}/role_group/{{$kategori->id}}/{{$rg->id}}/edit" method="post">
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
                                                    <input type="checkbox" class="form-check-input" name="is_main" {{$rg->is_main ? 'checked' : ''}}>
                                                    <i class="form-label"><small class="text-warning">Jadikan sebagai role utama</small></i>
                                                    @error('is_main')
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
            <br>
        </div>
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>


    <!-- Large panel -->
	<div id="tambah_role_group" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title fw-semibold">Tambah Role</h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>

		<div class="offcanvas-body p-2">
            <form action="/krs/{{$krs->id}}/role_group/{{$kategori->id}}/store" method="post">
                @csrf
                <input type="hidden" name="krs_id">
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
                            <input type="checkbox" class="form-check-input" name="is_main" >
                            <i class="form-label"><small class="text-warning">Jadikan sebagai role utama</small></i>
                            @error('is_main')
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


 
   
@endsection
