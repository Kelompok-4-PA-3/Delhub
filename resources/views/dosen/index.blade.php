@extends('main')
   
@section('title')
    <title>Manajemen Dosen</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('breadscrumb')
    <span class="breadcrumb-item active py-2"><i class="ph-chalkboard-teacher"></i>&nbsp;Manajemen Dosen</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Daftar Dosen</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" href="/dosen/create"><i class="ph-plus-circle"></i>&nbsp; TAMBAH DOSEN</a>
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
                    <th>NIDN</th>
                    <th>Nama</th>
                    <th>Proram Studi</th>
                    <th class="text-center">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th>NIDN</th>
                    <th>Nama</th>
                    <th>Proram Studi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($dosen as $d)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$d->nidn}}</td>
                    @if ($d->user != NULL)
                        <td>{{$d->user->nama}}</td>
                    @endif
                    {{-- <td>{{$d->user->nama}}</td> --}}
                    <td>{{$d->prodi->nama}}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="/dosen/{{$d->nidn}}/edit" class="text-body" data-bs-popup="tooltip" title="Ubah">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{$d->nidn}}">
                                <i class="ph-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Delete Modal -->
                <div id="modal_hapus{{$d->nidn}}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                               {{-- Apakah anda yakin ingin menghapus data <span class="fw-semibold">{{$d->user->nama}}</span> ? --}}
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <form action="/dosen/{{$d->nidn}}" method="post">
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