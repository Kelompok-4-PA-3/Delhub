@extends('main')

@section('title')
    <title>Kelola Antusias</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('interest'));

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Antusias</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" href="{{ route('interest.create') }}">
                        <i class="ph-plus-circle"></i>&nbsp;
                        Tambah Antusias
                    </a>
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
                    <th>No</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th class="text-center">Ket</th>
                </thead>
                <tbody>
                    @foreach ($interests as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ Str::limit($item->keterangan, 50) }}</td>
                            <td>{{ $item->status }}</td>
                            <td class="text-center">
                                <a href="{{ route('interest.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="ph-pencil"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-sm btn-danger"
                                    onclick="handle_confirm('Are you sure you want to delete this coupon?', 'Yes, delete it', 'No, cancel', 'delete', '{{ route('interest.destroy', $item->id) }}')">
                                    <i class="ph-trash"></i>
                                </a>

                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        </div>
    </div>
@endsection
