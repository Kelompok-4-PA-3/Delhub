@extends('main')

@section('title')
    <title>Manajemen Roles</title>
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
            <h5 class="mb-0">Tambah Role</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                   <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#panel_footer"><i class="ph-plus-circle"></i>&nbsp; TAMBAH ROLES</a>
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
        @elseif(session()->has('failed'))
        <div class="alert alert-success alert-icon-start alert-dismissible fade show">
            <span class="alert-icon bg-success text-white">
                <i class="ph-check-circle"></i>
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
                @foreach($roles as $r)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$r->name}}</td>
                    <td>{{$r->guard_name}}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="offcanvas" data-bs-target="#form-edit{{$r->id}}">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{$r->id}}">
                                <i class="ph-trash"></i>
                            </a>
                            <a href="#" class="text-body" data-bs-popup="tooltip" data-bs-toggle="modal" data-bs-target="#modal_small" title="Lihat">
                                <i class="ph-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Small modal -->
                <div id="modal_small" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Roles</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <b class="fw-semibold">Nama : </b>
                                <p>{{$r->name}}</p>
                                <b class="fw-semibold">Guar name : </b>
                                <p>{{$r->guard_name}}</p>
                                <b class="fw-semibold">Permission : </b>
                                    @foreach($permission as $p)
                                    @foreach($r->role_permission as $rrp)
                                       @if ($p->id == $rrp->permission_id)
                                       <br><span>{{$p->name}}</span>
                                       @endif
                                    @endforeach
                                @endforeach
                               
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /small modal -->

                <!-- Delete Modal -->
                <div id="modal_hapus{{$r->id}}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
    
                            <div class="modal-body">
                               Apakah anda yakin ingin menghapus data <span class="fw-semibold">{{$r->name}}</span> ?
                            </div>
    
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <form action="/roles/{{$r->id}}" method="post">
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
                 <div id="form-edit{{$r->id}}" class="offcanvas offcanvas-end  {{--@error('name_edit') show @enderror @error('guard_name_edit') show @enderror"--}} tabindex="-1">
                    {{-- @if($errors->any()) show @endif --}}
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title fw-semibold">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <div class="offcanvas-body">
                        <form action="/roles/{{$r->id}}" method="post">
                            @csrf
                            @method('put')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div>
                                    </div>
                                        <div>
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="name_edit" value="{{old('name',$r->name)}}" class="form-control" required placeholder="Masukkan name disini">
                                            @error('name_edit')
                                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="form-label">Guard Name</label>
                                            <select name="guard_name_edit" id="guard_name_select_edit"  class="form-control" required placeholder="Masukkan guard name disini" disabled>
                                                <option value="">Pilih guard name</option>
                                                <option @if(old('guard_name_edit', $r->guard_name) == 'web') selected @endif value="web">Web</option>
                                                <option @if(old('guard_name_edit',  $r->guard_name) == 'api') selected @endif value="api">API</option>
                                            </select>
                                            @error('guard_name_edit')
                                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div>
                                            @php
                                                $selected_permisison = $r->role_permission->pluck('permission_id')->toArray();
                                            @endphp
                                            <label class="col-form-label col-lg-3">Permisison</label>
                                            <div class="">
                                                <select data-placeholder="Select a State..." multiple="multiple" id="permission_select_edit"  name="permission[]" class="form-control select select-permission" required   @if($permission->count() <= 0) disabled  @endif>
                                                    <option></option>
                                                    <optgroup label="Daftar Permission">
                                                        @foreach($permission as $p)
                                                            @if ($r->guard_name == $p->guard_name)
                                                                <option value="{{$p->name}}"  {{ in_array($p->id ,$selected_permisison) ? 'selected' : '' }}>{{$p->name}}</option> 
                                                            @endif
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @if($permission->count() <= 0) 
                                                    <div class="p-1">
                                                        <small class="text-danger">Tidak ada permission yang tersedia silahkan create permission terlebih dahulu</small>
                                                    </div>
                                                @endif
                                            </div>
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
                
                @endforeach
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
                    <h5 class="modal-title">Edit Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="/roles" method="post">
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
                        <button type="submit" class="btn btn-primary">Kirim <i class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /vertical form modal -->

    <!-- Sticky footer -->
	<div id="panel_footer" class="offcanvas offcanvas-end  " tabindex="-1">
		<div class="offcanvas-header border-bottom">
			<h5 class="offcanvas-title fw-semibold">Tambah Role</h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>

		<div class="offcanvas-body">
            <form action="/roles" method="post">
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
                                <select name="guard_name" class="form-control" id="guard_name_select" required placeholder="Masukkan guard name disini">
                                    <option value="">Pilih guard name</option>
                                    <option @if(old('guard_name') == 'web') selected @endif value="web">Web</option>
                                    <option @if(old('guard_name') == 'api') selected @endif value="api">API</option>
                                </select>
                                @error('guard_name')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                            <div>
                            	<label class="col-form-label col-lg-3">Permisison</label>
                            	<div class="">
                            		<select data-placeholder="Select a State..." id="permission_select" multiple="multiple" name="permission[]" class="form-control select select-disabled" required   @if($permission->count() <= 0) disabled  @endif>
                            			{{-- <option></option> --}}
                            			<optgroup label="Daftar Permission">
                                            @foreach($permission as $p)
                                                <option class="{{$p->guard_name}}" {{ in_array($p->name, old('permission', [])) ? 'selected' : '' }} value="{{$p->name}}">{{$p->name}}</option>
                                            @endforeach
                            			</optgroup>
                            		</select>
                                    @if($permission->count() <= 0) 
                                        <div class="p-1">
                                            <small class="text-danger">Tidak ada permission yang tersedia silahkan create permission terlebih dahulu</small>
                                        </div>
                                    @endif
                            	</div>
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

    {{-- <select id="mySelect">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
      </select> --}}

    <script>
        var selectElem = document.getElementById("guard_name_select");
        var selectPermission = document.getElementById("permission_select");
        var options = selectPermission.options;

        // var selectElem_edit = document.getElementById("guard_name_select_edit");
        // var selectPermission_edit = document.getElementById("permission_select_edit");
        // var options_edit = selectPermission_edit.options;

        selectElem.onchange = function() {
        var selectedValue = selectElem.options[selectElem.selectedIndex].value;
          for (let i = 0; i < options.length; i++) {
                if(options[i].className == selectedValue){
                   options[i].removeAttribute('disabled');
                }else{
                    options[i].setAttribute('disabled','');
                    options[i].selected = false;
                }
          }
          console.log(selectedValue);
        }

        // selectElem_edit.onchange = function() {
        // var selectedValue = selectElem_edit.options[selectElem_edit.selectedIndex].value;
        //   for (let i = 0; i < options_edit.length; i++) {
        //         if(options_edit[i].className == selectedValue){
        //            options_edit[i].removeAttribute('disabled');
        //         }else{
        //             options_edit[i].setAttribute('disabled','');
        //             options_edit[i].selected = false;
        //         }
        //   }
        //   console.log(selectedValue);
        // }

      </script>
@endsection