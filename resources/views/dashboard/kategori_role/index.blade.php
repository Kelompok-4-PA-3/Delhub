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
    <span class="breadcrumb-item active py-2"> Kategori Role</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Kategori Role</h5>
            <div class="ms-auto d-flex">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#tambah_role_group"><i class="ph-plus-circle"></i>&nbsp; TAMBAH KATEGORI GROUP</a>
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
            {{-- {{ $kategori->where}} --}}
            {{-- @if ($kategori->count() > 0 ) --}}
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
                    @foreach ($kategori as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">

                                    @if (strtolower($k->nama) != 'koordinator')
                                        <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah"
                                            data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $k->id }}">
                                            <i class="ph-pen"></i>
                                        </a>

                                        <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                            data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $k->id }}">
                                            <i class="ph-trash"></i>
                                        </a>
                                    @endif

                                    <a href="#" class="text-body " data-bs-popup="tooltip" title="Detail"
                                        data-bs-toggle="modal" data-bs-target="#modal_detail{{ $k->id }}">
                                        <i class="ph-eye"></i>
                                    </a>
                                    
                                    <a href="/krs/{{$krs->id}}/role_group/{{$k->id}}" class="text-body  mx-2" data-bs-popup="tooltip" title="Role">
                                        <i class="ph-notebook"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                        <!-- Delete Modal -->
                        <div id="modal_hapus{{ $k->id }}" class="modal fade" tabindex="-1">
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
                                        <form action="/krs/{{$krs->id}}/kategori_role/{{$k->id}}/delete" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Ya</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Delete Modal -->

                        <!-- detail Modal -->
                        <div id="modal_detail{{ $k->id }}" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-xs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"> {{$k->nama}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <small class="fw-semibold">Kategori</small>
                                            <p class="fw-light">{{$k->nama}}</p>
                                        </div>
                                        <div>
                                            <small class="fw-semibold">Daftar role</small><br>
                                            @foreach ($k->role_group as $krg)
                                                <span class="fw-light">{{$krg->nama}}</span><br>
                                            @endforeach
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- detail Modal -->

                        <!-- Sticky footer -->  
                          <!-- Large panel -->
                            <div id="form-edit{{$k->id}}" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title fw-semibold">Edit Poin Penilaian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>

                                <div class="offcanvas-body p-2">
                                    <form action="/krs/{{$krs->id}}/kategori_role/{{$k->id}}/edit" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <div class="mt-2">
                                                    <label class="form-label">Role Group</label>
                                                    <input class="form-control" value="{{old('nama',$k->nama)}}" name="nama" placeholder="Masukkan kategori role disini" required>
                                                    @error('nama')
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
            {{-- @endif --}}
        </div>
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>


    <!-- Large panel -->
	<div id="tambah_role_group" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title fw-semibold">Tambah Kategori Role</h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>

		<div class="offcanvas-body p-2">
            <form action="/krs/{{$krs->id}}/kategori_role/store" method="post">
                @csrf
                <input type="hidden" name="krs_id" value="{{$krs->id}}">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="mt-2">
                            <label class="form-label">Kategori</label>
                            <input class="form-control" name="nama" value="{{old('nama')}}" placeholder="Masukkan kategori anda disini..." required>
                            @error('nama')
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

    @if ($kategori->where('nama',strtolower('koordinator'))->first() == NULL)
        <!-- Large panel -->
        <div id="tambah_role_group_koordinator" class="offcanvas offcanvas-top offcanvas-size-lg show" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel">
            <div class="offcanvas-header">
            </div>

            <div class="offcanvas-body p-2">
                <div class="container">
                    <h1 class="text-center"><i class="ph-warning text-warning ph-2x"></i> </h1>
                    <h4 class="fw-light text-center">
                        Sepertinya role Koordinator belum terdapat di krs ini pastikan untuk membuat role tersebut terlabih dahulu
                    </h4>
                </div>
                <form action="/krs/{{$krs->id}}/kategori_role/store" method="post">
                    @csrf
                    <input type="hidden" name="koordinator" value="koordinator">
                    <div class="border-top p-3">
                        <button type="submit" class="btn btn-primary w-100">Lanjutkan</button>
                        <a href="/koordinator/proyeksaya/{{$krs->id}}" class="btn btn-muted w-100 mt-2">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    @endif
   
@endsection
