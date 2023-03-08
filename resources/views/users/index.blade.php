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
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Daftar Pengguna</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                   <a href="/users/create" class="btn btn-primary btn-sm fw-bold"><i class="ph-plus-circle"></i>&nbsp; TAMBAH PENGGUNA</a>
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

    {{-- datatable_js --}}
	{{-- <script>
        $(document).ready(function() {
            $('.datatable-column-search-inputs thead tr:eq(1) th').not(':last-child').each(function () {
                const title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
            });

            $('#user-table').DataTable( {
                orderCellsTop: true,
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function (index) {
                            const that = this;
        
                            $('input').on('keyup change clear', function () {
                                if (that.search() !== this.value) {
                                    that.column($(this).parent().index() + ':visible').search(this.value).draw();
                                }
                            });
                        });
                },
                "ajax": "/data/user",
                "columns": [
                    { data: "nama", "name": "nama" },
                    { data: "username", name: "username" },
                    { data: "email", name: "email" },
                    {
                        data: "aksi",
                        render: function(data, type, row, meta){
                            return '<div class="row"><div class="col" data-toggle="modal" data-target="#detail(${row.id})" ><button  class="btn btn-outline-info"><span class="fas fa-eye"></button></div><div class="col"><a href="/pasar/edit/${row.id}" class="btn btn-outline-warning"><span class="fas fa-edit"></a></div><div class="col"><button class="btn btn-outline-danger" onclick="deleteDataPasar(${row.id})"><span class="fas fa-trash"></button></div></div>';
                        }
                    }
                ]
            });
    } ); 
	</script> --}}
@endsection