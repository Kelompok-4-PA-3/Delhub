@extends('main')
   
@section('title')
    <title>Kartu Rencana Studi</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Daftar KRS</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a href="/krs/create" class="btn btn-primary btn-sm fw-bold"><i class="ph-plus-circle"></i>&nbsp; TAMBAH KRS</a>
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
                    <th>Kategori</th>
                    <th>Dosen</th>
                    <th>Program studi</th>
                    <th>Angkatan</th>
                    <th class="text-center">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Kategori</th>
                    <th>Dosen</th>
                    <th>Program studi</th>
                    <th>Angkatan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($krs as $k)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$k->kategori->nama_mk}}</td>
                    <td>{{$k->dosen->user->nama}}</td>
                    <td>{{$k->prodi->nama}}</td>
                    <td>{{$k->angkatan}}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="/krs/{{$k->id}}/edit" class="text-body" data-bs-popup="tooltip" title="Ubah">
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
                                    <div>
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="nama_mk" value="{{old('nama_mk',$k->nama_mk)}}" class="form-control" required placeholder="Masukkan nama mk disini">
                                        @error('nama_mk')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="form-label">Nama Singkat</label>
                                        <input type="text" name="nama_singkat" value="{{old('nama_singkat',$k->nama_singkat)}}" class="form-control" required placeholder="Masukkan nama singkat disini">
                                        @error('nama_singkat')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
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
                               Apakah anda yakin ingin menghapus data krs ini ?
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <form action="/krs/{{$k->id}}" method="post">
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
            </tbody>
        </table>
        <br>
    </div>
    <!-- /individual column searching (text inputs) -->

	<!-- /individual column searching (text inputs) -->
    <div class="chart position-relative" id="traffic-sources"></div>
    </div>
@endsection