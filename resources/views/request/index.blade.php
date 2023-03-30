@extends('main')

@section('title')
    <title>History Bimbingan</title>
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
            <h5 class="mb-0">Daftar Bimbingan</h5>
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
                    <th>Nama Kelompok</th>
                    <th>Deskripsi</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Nama Kelompok</th>
                    <th>Deskripsi</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $r)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$r->kelompok->nama_kelompok ?? ''}}</td>
                    <td>{{$r->description}}</td>
                    <td>{{$r->waktu}}</td>
                    <td>{{$r->status}}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{$r->id}}">
                                <i class="ph-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>



                <!-- Delete Modal -->
                <div id="modal_hapus{{$r->id}}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                               Apakah anda yakin ingin menghapus data bimbingan ini ?
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <form action="/request/{{$r->id}}" method="post">
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
