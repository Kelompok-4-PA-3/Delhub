@extends('main')
   
@section('title')
    <title>Kategori Mata Kuliah</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('breadscrumb')
    <span class="breadcrumb-item active py-2"><i class="ph-squares-four"></i>&nbsp;Manajemen KRS</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Daftar Kategori</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#panel_footer"><i class="ph-plus-circle"></i>&nbsp; TAMBAH KATEGORI</a>
                 </label>
            </div>
        </div>

        <div class="card-body pb-0">
        @if (session()->has('success'))
        <div class="alert alert-success alert-icon-start alert-dismissible fade show">
            <span class="alert-icon bg-success text-white">
                <i class="ph-check-circle"></i>
            </span>
            <span class="fw-semibold">Berhasil!</span> {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- /individual column searching (text inputs) -->
        <table class="table datatable-users">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori Proyek</th>
                    <th class="text-center">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori Proyek</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($kategori->count() > 0)
                @foreach($kategori as $k)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$k->kode_mk}}</td>
                    <td>{{$k->nama_mk}}</td>
                    <td>{{$k->kategori->nama}}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="offcanvas" data-bs-target="#form-edit{{$k->id}}">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{$k->id}}">
                                <i class="ph-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Sticky footer -->
                <div id="form-edit{{$k->id}}" class="offcanvas offcanvas-end" tabindex="-1">
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title fw-semibold">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <div class="offcanvas-body">
                        <form action="/kategori/{{$k->id}}" method="post">
                            @method('put')
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label">Kode</label>
                                        <input type="text" name="kode_mk" value="{{old('kode_mk',$k->kode_mk)}}" class="form-control" required placeholder="Masukkan kode mk disini">
                                        @error('kode_mk')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="nama_mk" value="{{old('nama_mk',$k->nama_mk)}}" class="form-control" required placeholder="Masukkan nama mk disini">
                                        @error('nama_mk')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">Nama Singkat</label>
                                        <input type="text" name="nama_singkat" value="{{old('nama_singkat',$k->nama_singkat)}}" class="form-control" required placeholder="Masukkan nama singkat disini">
                                        @error('nama_singkat')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label">Kategori Proyek</label>
                                        <select type="text" name="kategori_proyek" class="form-control" required>
                                            <option value="">Pilih kategori proyek</option>
                                            @foreach ($kategori_proyek as $kp)
                                                <option value="{{$kp->id}}" {{$kp->id == $k->kategori_proyek ? 'selected' : ''}}>{{$kp->nama}}</option>
                                                {{-- <option value="{{$kp->id}}" {{$kp->id == $pr->kategori_id ? 'selected' : ''}}>{{$kp->nama}}</option> --}}
                                            @endforeach
                                        </select>
                                        @error('kategori_proyek')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top p-3">
                            <button type="submit" class="btn btn-primary w-100" >Kirim</button>
                        </div>
                    </form>
                </div>
                <!-- /sticky footer -->

                <!-- Delete Modal -->
                <div id="modal_hapus{{$k->id}}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                               Apakah anda yakin ingin menghapus data <span class="fw-semibold">{{$k->nama_mk}}</span> ?
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <form action="/kategori/{{$k->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-primary">Ya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
	            <!-- /Delete Modal -->


                @endforeach
                @endif
            </tbody>
        </table>
        <br>
    </div>
    <!-- /individual column searching (text inputs) -->

    <!-- Sticky footer -->
	<div id="panel_footer" class="offcanvas offcanvas-end  " tabindex="-1">
		<div class="offcanvas-header border-bottom">
			<h5 class="offcanvas-title fw-semibold">Tambah Kategori</h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>

		<div class="offcanvas-body">
            <form action="/kategori" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="mt-2">
                            <label class="form-label">Kode</label>
                            <input type="text" name="kode_mk" value="{{old('kode_mk')}}" class="form-control" required placeholder="Masukkan kode mk disini">
                            @error('kode_mk')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama_mk" value="{{old('nama_mk')}}" class="form-control" required placeholder="Masukkan nama mk disini">
                            @error('nama_mk')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Nama Singkat</label>
                            <input type="text" name="nama_singkat" value="{{old('nama_singkat')}}" class="form-control" required placeholder="Masukkan nama singkat disini">
                            @error('nama_singkat')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Kategori Proyek</label>
                            <select type="text" name="kategori_proyek" class="form-control" required>
                                <option value="">Pilih kategori proyek</option>
                                @foreach ($kategori_proyek as $kp)
                                    <option value="{{$kp->id}}" {{$kp->id == old('kategori_id') ? 'selected' : ''}}>{{$kp->nama}}</option>
                                @endforeach
                            </select>
                            @error('nama')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-top p-3">
                <button type="submit" class="btn btn-primary w-100" >Kirim</button>
            </div>
        </form>
	</div>
	<!-- /sticky footer -->

	<!-- /individual column searching (text inputs) -->
    <div class="chart position-relative" id="traffic-sources"></div>
    </div>
@endsection