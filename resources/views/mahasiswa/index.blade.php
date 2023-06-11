@extends('main')

@section('title')
    <title>Manajemen Mahasiswa</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
@endpush

@section('breadscrumb')
    <span href="/mahasiswa" class="breadcrumb-item active py-2"><i class="ph-student"></i>&nbsp;Manajemen Mahasiswa</span>
@endsection


@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Daftar Mahasiswa</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" href="/mahasiswa/create"><i class="ph-plus-circle"></i>&nbsp;
                        TAMBAH MAHASISWA</a>
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
            @endif

            <!-- /individual column searching (text inputs) -->
            <table class="table datatable-users">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Proram Studi</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Proram Studi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->user ? $m->user->nama : '' }}</td>
                            <td>{{ $m->prodi ? $m->prodi->nama : '' }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="/mahasiswa/{{ $m->nim }}/edit" class="text-body" data-bs-popup="tooltip"
                                        title="Ubah">
                                        <i class="ph-pen"></i>
                                    </a>
                                    <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                        data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $m->nim }}">
                                        <i class="ph-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div id="modal_hapus{{ $m->nim }}" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-xs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Apakah anda yakin ingin menghapus data <span
                                            class="fw-semibold">{{ $m->user ? $m->user->nama : $m->nim }}</span>?
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <form action="/mahasiswa/{{ $m->nim }}" method="post">
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
