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
<link href="{{ asset('/assets/fonts/inter/inter.css" rel="stylesheet')}}" type="text/css">
<script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script>
<script src="{{asset('/assets/demo/pages/extra_fab.js')}}"></script>
@endpush

@section('breadscrumb')
<a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2"><i class="ph-house me-2"></i>
    Koordinator</a>
<a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2">{{$krs->kategori->nama_singkat}}</a>
<span class="breadcrumb-item active py-2"> Kategori Role</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">Kategori Role</h5>
        <div class="ms-auto d-flex">

            <div>
                <div class="fab-menu fab-menu-top" data-fab-toggle="hover">
                    <button type="button" class="btn btn-sm btn-primary">
                        <div class="d-flex">
                            <div class="fw-semibold">
                                <i class="ph-plus-circle"></i>&nbsp; TAMBAH KATEGORI GROUP
                            </div>
                        </div>
                    </button>

                    <ul class="fab-menu-inner bg-secondary">
                        <li>
                            <div class="d-flex">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#tambah_salin_data"
                                class="btn btn-secondary btn-icon rounded-pill border-2">
                                    <div class="fs-sm">
                                        <i class="ph-copy"></i>
                                        Tambah salin data
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex mb-1">
                                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#tambah_role_group"
                                    class="btn btn-secondary btn-icon rounded-pill border-2">
                                    <div class="fs-sm">
                                        <i class="ph-plus-circle"></i>
                                        Tambah manual
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
    </div>

         <!-- detail Modal -->
         {{-- <div id="tambah_salin_data" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Salin Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/krs/{{$krs->id}}/kategori_role/store" method="POST">
                            @csrf 
                            <div class="" id="form-copy container">
                                <div>
                                     <h5 class="fw-light"><i class="ph-copy text-success"></i> Pilih fitur yang ingin di copy</h5>
                                </div>
                                <div class="row p-2 rounded">
                                    <div class="mb-3">
                                        <label class="form-label">Salin KRS</label>
                                        <select data-placeholder="Pilih krs" id="krs_copy_select" class="form-control select" name="krs_copy" required>
                                            <optgroup label="Daftar Angkatan">
                                                @foreach ($krs_all as $k)
                                                    <option @if(old('krs_copy') == $k->id) selected @endif value="{{$k->id}}">{{$k->kategori->nama_mk}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                     <div class="col-md">
                                         <div class="form-check form-check-inline form-switch mb-2">
                                             <input id="kategori_role" name="kategori_role" type="checkbox" class="form-check-input" value="true" checked disabled> 
                                             <label for="kategori_role" class="form-check-label">Kategori Role</label>
                                         </div>
                                         <div class="form-check form-check-inline form-switch mb-2">
                                             <input id="poin_penilaian" name="poin_penilaian" type="checkbox" class="form-check-input" value="true">
                                             <label for="poin_penilaian" class="form-check-label">Poin penilaian</label>
                                         </div>
                                         <div class="form-check form-check-inline form-switch mb-2">
                                             <input id="assign_dosen" name="role" type="checkbox" class="form-check-input" value="true">
                                             <label for="assign_dosen" class="form-check-label">Assign dosen ke penilaian</label>
                                         </div>
                                     </div>
                                     <div class="col-md">
                                         <div class="form-check form-check-inline form-switch mb-2">
                                             <input id="role" name="role" type="checkbox" class="form-check-input" value="true">
                                             <label for="role" class="form-check-label">Role</label>
                                         </div>
                                         <div class="form-check form-check-inline form-switch mb-2">
                                             <input id="komponen_penilaian" name="role" type="checkbox" class="form-check-input" value="true">
                                             <label for="komponen_penilaian" class="form-check-label">Komponen penilaian</label>
                                         </div>
                                     </div>
                                </div>
                             </div> 
                            <br>
                            <button class="btn btn-primary w-100" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- detail Modal -->

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

                            <a href="#" class="text-body " data-bs-popup="tooltip" title="Detail" data-bs-toggle="modal"
                                data-bs-target="#modal_detail{{ $k->id }}">
                                <i class="ph-eye"></i>
                            </a>

                            <a href="/krs/{{$krs->id}}/role_group/{{$k->id}}" class="text-body  mx-2"
                                data-bs-popup="tooltip" title="Role">
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
                                        <input class="form-control" value="{{old('nama',$k->nama)}}" name="nama"
                                            placeholder="Masukkan kategori role disini" required>
                                        @error('nama')
                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{
                                            $message }}
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
                        <input class="form-control" name="nama" value="{{old('nama')}}"
                            placeholder="Masukkan kategori anda disini..." required>
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
<div id="tambah_role_group_koordinator" class="offcanvas offcanvas-top offcanvas-size-lg show" data-bs-backdrop="static"
    tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
    </div>

    <div class="offcanvas-body p-2">
        <div class="container">
            <h1 class="text-center"><i class="ph-warning text-warning ph-2x"></i> </h1>
            <h4 class="fw-light text-center">
                Sepertinya role Koordinator belum terdapat di krs ini pastikan untuk membuat role tersebut terlabih
                dahulu
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

    <!-- detail Modal -->
    <div id="tambah_salin_data" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Salin Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/krs/{{$krs->id}}/kategori_role/store" method="POST">
                        @csrf 
                        <div class="" id="form-copy container">
                            <div>
                                 <h5 class="fw-light"><i class="ph-copy text-success"></i> Pilih fitur yang ingin di copy</h5>
                            </div>
                            <div class="row p-2 rounded">
                                <div class="mb-3">
                                    <label class="form-label">Salin KRS</label>
                                    <select data-placeholder="Pilih krs" id="krs_copy_select" class="form-control select" name="krs_copy" required>
                                        <optgroup label="Daftar Angkatan">
                                            @foreach ($krs_all as $k)
                                                <option @if(old('krs_copy') == $k->id) selected @endif value="{{$k->id}}">{{$k->kategori->nama_mk}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                                 <div class="col-md">
                                     <div class="form-check form-check-inline form-switch mb-2">
                                         <input id="kategori_role" name="kategori_role" type="checkbox" class="form-check-input" value="true" checked disabled> 
                                         <label for="kategori_role" class="form-check-label">Kategori Role</label>
                                     </div>
                                     <div class="form-check form-check-inline form-switch mb-2">
                                         <input id="poin_penilaian" name="poin_penilaian" type="checkbox" class="form-check-input" value="true">
                                         <label for="poin_penilaian" class="form-check-label">Poin penilaian</label>
                                     </div>
                                     <div class="form-check form-check-inline form-switch mb-2">
                                         <input id="assign_dosen" name="assign_dosen" type="checkbox" class="form-check-input" value="true">
                                         <label for="assign_dosen" class="form-check-label">Assign dosen ke penilaian</label>
                                     </div>
                                 </div>
                                 <div class="col-md">
                                     <div class="form-check form-check-inline form-switch mb-2">
                                         <input id="role" name="role" type="checkbox" class="form-check-input" value="true">
                                         <label for="role" class="form-check-label">Role</label>
                                     </div>
                                     <div class="form-check form-check-inline form-switch mb-2">
                                         <input id="komponen_penilaian" name="komponen_penilaian" type="checkbox" class="form-check-input" value="true">
                                         <label for="komponen_penilaian" class="form-check-label">Komponen penilaian</label>
                                     </div>
                                 </div>
                            </div>
                         </div> 
                        <br>
                        <button class="btn btn-primary w-100" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- detail Modal -->

<script>
$(document).ready(function() {
    $('#komponen_penilaian').prop('disabled', true);
    $('#poin_penilaian').prop('disabled', true);
    $('#assign_dosen').prop('disabled', true);


  $('#role').change(function() {
    if ($(this).is(':checked')) {
      $('#poin_penilaian').prop('disabled', false);
    } else {
      $('#poin_penilaian').prop('disabled', true).prop('checked', false);
      $('#komponen_penilaian').prop('disabled', true).prop('checked', false);
      $('#assign_dosen').prop('disabled', true).prop('checked', false);
    }
  });

  $('#poin_penilaian').change(function() {
    if ($(this).is(':checked')) {
      $('#komponen_penilaian').prop('disabled', false);
    } else {
      $('#komponen_penilaian').prop('disabled', true).prop('checked', false);
      $('#assign_dosen').prop('disabled', true).prop('checked', false);
    }
  });

  $('#komponen_penilaian').change(function() {
    if ($(this).is(':checked')) {
      $('#assign_dosen').prop('disabled', false);
    } else {
      $('#assign_dosen').prop('disabled', true).prop('checked', false);
    }
  });

});
</script>


@endsection