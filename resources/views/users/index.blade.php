@extends('main')

@section('title')
    <title>Manajemen Permission</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/ui/fab.min.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/extra_fab.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/uploaders/fileinput/fileinput.min.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/uploader_bootstrap.js')}}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Daftar Pengguna</h5>
            <div class="ms-auto">
                {{-- <label class="form-check form-switch form-check-reverse">
                   <a href="/users/create" class="btn btn-primary btn-sm fw-bold"><i class="ph-plus-circle"></i>&nbsp; TAMBAH PENGGUNA</a>
                </label> --}}
                <style>
                    #tambah-pengguna{
                        transform: scale(0.9);
                    }
                    .btn-add-user{
                        transform: scale(0.8);
                    }
                </style>
                <div class="btn btn-primary btn-sm btn-add-user">
                    <div class="fab-menu" data-fab-toggle="click">
                        <button id="tambah-pengguna" type="button" class="fab-menu-btn btn text-white">
                            {{-- TAMBAH PENGGUNA --}}
                            <div class="m-1">
                                <i class="fab-icon-open ph-plus"></i>
                                <i class="fab-icon-close ph-x"></i>
                            </div>
                        </button>

                        <ul class="fab-menu-inner" style="margin-top: -20px;">
                            <li>
                                <div class="fab-label-end fab-label-visible" data-fab-label="Tambah Pengguna Manual">
                                    <a href="/users/create" class="btn btn-light btn-icon rounded-pill">
                                        <i class="ph-note-pencil m-1"></i>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="fab-label-end fab-label-visible" data-fab-label="Upload File Excel">
                                    <a href="#" class="btn btn-light btn-icon rounded-pill" data-bs-toggle="offcanvas" data-bs-target="#panel_footer">
                                        <i class="ph-microsoft-excel-logo m-1"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <label for="tambah-pengguna" class="text-uppercase fs-6 fw-bold me-3">Tambah Pengguna </label>
                </div>
                <br>
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
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th class="text-center">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $u)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$u->nama}}</td>
                    <td>{{$u->username}}</td>   
                    <td>{{$u->email}}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="modal" data-bs-target="#modal_ubah{{$u->id}}">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{$u->id}}">
                                <i class="ph-trash"></i>
                            </a>
                            <a href="#" class="text-body" data-bs-popup="tooltip" title="Lihat">
                                <i class="ph-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                 <!-- Vertical form modal -->
                <div id="modal_ubah{{$u->id}}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Pengguna</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="/users/{{$u->id}}" method="post">
                                @csrf
                                @method('put')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="nama" value="{{$u->nama}}" class="form-control" required>
                                                @error('nama')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label">Username</label>
                                                <input type="text" name="username" value="{{$u->username}}" class="form-control" required>
                                                @error('username')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-label">Email</label>
                                                <input type="text" name="email" value="{{$u->email}}" class="form-control" required>
                                                @error('email')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>
                                            @php
                                                $selected_roles = $u->getRoleNames()->toArray();
                                            @endphp
                                            <div class="col-sm-6">
                                                <label class="form-label">Role</label>
                                                <select data-placeholder="Pilih role..." multiple="multiple" name="roles[]" class="form-control select" required   @if($roles->count() <= 0) disabled  @endif>
                                                    {{-- <option></option> --}}
                                                    <optgroup label="Daftar Role">
                                                        @foreach($roles as $r)
                                                            <option @if(in_array($r->name ,$selected_roles)) selected @endif value="{{$r->name}}">{{$r->name}} </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @if($roles->count() <= 0)
                                                    <div class="p-1">
                                                        <small class="text-danger">Tidak ada permission yang tersedia silahkan create permission terlebih dahulu</small>
                                                    </div>
                                                @endif
                                                @error('roles')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                       <h6 class="fw-semibold">Ubah Password</h6>
                                    </div>

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-label">Password</label>
                                                <input type="text" name="password" placeholder="Masukkan password baru" class="form-control">
                                                @error('password')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label">Konfirmasi Password</label>
                                                <input type="text" name="password_confirmation" placeholder="Konfirmasi password baru" class="form-control">
                                                @error('password_confirmation')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Kirim <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /vertical form modal -->

                <!-- Delete Modal -->
                <div id="modal_hapus{{$u->id}}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                               Apakah anda yakin ingin menghapus data <span class="fw-semibold">{{$u->nama}}</span> ?
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <form action="/users/{{$u->id}}" method="post">
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

     <!-- Sticky footer -->
     <div id="panel_footer" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-semibold">Tambah Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            
            <div class="py-1">
                <div class="mb-1">
                    <small class="text-danger"><i>Silahkan gunakan template dibawah ini sebagai format file yang di upload</i></small>
                </div>
                <a href="{{asset('/template/file-user.xlsx')}}" class="btn btn-light" downloaad><i class="ph-microsoft-excel-logo"></i>&nbsp; Download Template</a>
            </div>

            <form action="/users/upload" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Specify file types</h5>
                    </div>

                    <div class="card-body">
                        <p class="fw-semibold">Seret file excel pada area</p>
                        <input type="file" class="file-input" name="user-file" data-allowed-file-extensions='["xlsx", "xls", "csv"]'>
                    </div>
                </div>

                <div class="border-top p-3">
                    <button type="submit" class="btn btn-primary w-100">Kirim</button>
                </div>
            </form>
        </div>
        <!-- /sticky footer -->

@endsection
