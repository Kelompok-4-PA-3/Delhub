@extends('main')

@section('title')
    <title>Manajemen Permission</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Permission</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                   <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#panel_footer"><i class="ph-plus-circle"></i>&nbsp; TAMBAH PERMISSIONS</a>
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

        @if (session()->has('failed'))
        <div class="alert alert-danger alert-icon-start alert-dismissible fade show">
            <span class="alert-icon bg-danger text-white">
                <i class="ph-warning-circle"></i>
            </span>
            <span class="fw-semibold">Gagal!</span> {{session('failed')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- /individual column searching (text inputs) -->
        <table class="table datatable-users">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Guard Name</th>
                    <th class="text-center">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>Guard Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($permission as $p)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$p->name}}</td>
                    <td>{{$p->guard_name}}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="offcanvas" data-bs-target="#form_edit{{$p->id}}">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{$p->id}}">
                                <i class="ph-trash"></i>
                            </a>
                            {{-- <a href="#" class="text-body" data-bs-popup="tooltip" title="Lihat">
                                <i class="ph-eye"></i>
                            </a> --}}
                        </div>
                    </td>
                </tr>

                 <!-- Delete Modal -->
                 <div id="modal_hapus{{$p->id}}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
    
                            <div class="modal-body">
                               Apakah anda yakin ingin menghapus data <span class="fw-semibold">{{$p->name}}</span> ?
                            </div>
    
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <form action="/permission/{{$p->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-primary">Ya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Delete Modal -->

                <!-- Sticky footer -->
                <div id="form_edit{{$p->id}}" class="offcanvas offcanvas-end  @error('name') show @enderror @error('guard_name') show @enderror" tabindex="-1">
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title fw-semibold">Edit Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <div class="offcanvas-body">
                        <form action="/permission/{{$p->id}}" method="post">
                            @csrf
                            @method('put')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="name" value="{{old('name', $p->name)}}" class="form-control" required placeholder="Masukkan name disini">
                                        @error('name')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="form-label">Guard Name</label>
                                        <select name="guard_name" id=""  class="form-control" required placeholder="Masukkan guard name disini" disabled>
                                            <option value="">Pilih guard name</option>
                                            <option @if(old('guard_name', $p->guard_name) == 'web') selected @endif value="web">Web</option>
                                            <option @if(old('guard_name', $p->guard_name) == 'api') selected @endif value="api">API</option>
                                        </select>
                                        @error('guard_name')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="border-top p-3">
                        <button type="submit" class="btn btn-primary w-100" >Submit</button>
                    </div>
                </form>
                </div>
                <!-- /sticky footer -->

                @endforeach
                {{-- @foreach($user as $u)
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

                                            <div class="col-sm-6">
                                                <label class="form-label">role</label>
                                                <input type="text" placeholder="Kopyov" class="form-control" required>
                                                @error('role')
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
                                    <button type="submit" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
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


                @endforeach --}}
            </tbody>
        </table>
        <br>
    </div>
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>

     <!-- Vertical form modal -->
     <div id="modal_tambah_roles" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="/permission" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="name" value="{{old('name')}}" class="form-control" required>
                                    @error('name')
                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label">Guard Name</label>
                                    <input type="text" name="username" value="{{old('guard_name')}}" class="form-control" required>
                                    @error('guard_name')
                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /vertical form modal -->

    <!-- Sticky footer -->
	<div id="panel_footer" class="offcanvas offcanvas-end  @error('name') show @enderror @error('guard_name') show @enderror" tabindex="-1">
		<div class="offcanvas-header border-bottom">
			<h5 class="offcanvas-title fw-semibold">Tambah Permission</h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>

		<div class="offcanvas-body">
            <form action="/permission" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div>
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" value="{{old('name')}}" class="form-control" required placeholder="Masukkan name disini">
                            @error('name')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Guard Name</label>
                            <select name="guard_name" id=""  class="form-control" required placeholder="Masukkan guard name disini">
                                <option value="">Pilih guard name</option>
                                <option @if(old('guard_name') == 'web') selected @endif value="web">Web</option>
                                <option @if(old('guard_name') == 'api') selected @endif value="api">API</option>
                            </select>
                            @error('guard_name')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
		</div>

		<div class="border-top p-3">
			<button type="submit" class="btn btn-primary w-100" >Submit</button>
		</div>
    </form>
	</div>
	<!-- /sticky footer -->

@endsection