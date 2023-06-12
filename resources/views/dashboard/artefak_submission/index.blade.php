@extends('main')

@section('title')
<title>Manajemen Artefak Submission</title>
@endsection

@push('datatable_js')
<script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
<script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
<script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
<script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
@endpush

@section('breadscrumb')
    <a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
    <a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2">{{$krs->kategori->nama_singkat}}</a>
    <span class="breadcrumb-item active py-2"> Manajemen Artefak Submission</span>
@endsection



@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">Tambah Artefak Submission</h5>
        <div class="ms-auto">
            <label class="form-check form-switch form-check-reverse">
                <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#panel_footer"><i
                        class="ph-plus-circle"></i>&nbsp; TAMBAH ARTEFAK SUBMISSION</a>
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
        <div class="alert alert-success alert-icon-start alert-dismissible fade show">
            <span class="alert-icon bg-success text-white">
                <i class="ph-check-circle"></i>
            </span>
            <span class="fw-semibold">Gagal!</span> {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- /individual column searching (text inputs) -->
        <table class="table datatable-users">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Deskripsi</th>
                    <th>Deadline</th>
                    <th class="text-center">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Deskripsi</th>
                    <th>Deadline</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submission as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->deskripsi }}</td>
                    <td>{{ $s->deadline }}</td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah"
                                data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $s->id }}">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $s->id }}">
                                <i class="ph-trash"></i>
                            </a>
                            {{-- <a href="#" class="text-body" data-bs-popup="tooltip" data-bs-toggle="modal"
                                data-bs-target="#modal_small" title="Lihat">
                                <i class="ph-eye"></i>
                            </a> --}}
                        </div>
                    </td>
                </tr>

                <!-- Small modal -->
                <div id="modal_small" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Artefak Submission</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

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
                <div id="modal_hapus{{ $s->id }}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                Apakah anda yakin ingin menghapus data submission ini ?
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <form action="/krs/{{$krs->id}}/submission/{{$s->id}}" method="post">
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
                <div id="form-edit{{ $s->id }}"
                    class="offcanvas offcanvas-end  {{-- @error('name_edit') show @enderror @error('guard_name_edit') show @enderror"
                    --}} tabindex="-1">
                    {{-- @if ($errors->any()) show @endif --}}
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title fw-semibold">Edit Submission Artefak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <div class="offcanvas-body">
                        <form action="/krs/{{$krs->id}}/submission/{{$s->id}}/edit" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label">Deskripsi</label>
                                        <input type="text" name="deskripsi" value="{{ old('deskripsi',$s->deskripsi) }}" class="form-control" required
                                            placeholder="Masukkan deskripsi disini">
                                        @error('deskripsi')
                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="form-label">Deadline</label>
                                        <input type="datetime-local" name="deadline" class="form-control" value="{{ old('deadline',$s->deadline) }}" required>
                                        @error('deadline')
                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="border-top p-3">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
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



<!-- Sticky footer -->
<div id="panel_footer" class="offcanvas offcanvas-end  " tabindex="-1">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-semibold">Tambah Artefak Submission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form action="/krs/{{$krs->id}}/submission/store" method="post">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <div>
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" class="form-control" required
                            placeholder="Masukkan deskripsi disini">
                        @error('deskripsi')
                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label class="form-label">Deadline</label>
                        <input type="datetime-local" name="deadline" class="form-control" value="{{old('deadline')}}" required>
                        @error('deadline')
                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
    </div>
    <div class="border-top p-3">
        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </div>
    </form>
</div>
<!-- /sticky footer -->
@endsection