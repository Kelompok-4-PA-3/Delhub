@extends('main')

@section('title')
    <title>Kelola Jadwal</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('jadwal'));

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Jadwal</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" href="{{ route('jadwal.create') }}">
                        <i class="ph-plus-circle"></i>&nbsp;
                        Kelola Jadwal
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
                    <th><input type="checkbox" id="select-all"></th>
                    <th>No.Kelompok</th>
                    <th>Tanggal Bimbingan</th>
                    <th>Waktu Bimbingan</th>
                    <th>Ruangan</th>
                    <th>Aksi</th>
                </thead>
                @foreach($jadwals as $jadwal)
                <tbody>
                    <td><input type="checkbox" name="jadwal[]" value="{{$jadwal->id}}"></td>
                    <td>{{$jadwal->kel}}</td>
                    <td>{{$jadwal->tanggal}}</td>
                    <td>{{$jadwal->waktu}}</td>
                    <td>{{$jadwal->ruangan}}</td>
                    <td><a class="btn btn-warning btn-sm fw-bold" href="{{ route('jadwal.edit', $jadwal->id) }}">
                        <i class="ph-pencil-circle"></i>&nbsp; Edit
                    </a>
                    <a class="btn btn-danger btn-sm fw-bold" href="{{route('jadwal.destroy', ['jadwal' => $jadwal])}}">
                        <i class="ph-delete-circle"></i>&nbsp; Hapus
                    </a>
                </td>
                </tbody>
                @endforeach
            </table>
        </div>

    </div>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" href="{{ route('jadwal.create') }}">
                        <i class="ph-plus-circle"></i>&nbsp;
                        Submit
                    </a>
                    &emsp;
                    <a class="btn btn-primary btn-sm fw-bold" href="{{ route('jadwal.create') }}">
                        <i class="ph-plus-circle"></i>&nbsp;
                        Publish
                    </a>
                </label>
</div>


<script>
    var selectAll = document.getElementById('select-all');
    var checkboxes = document.getElementsByName('jadwal[]');

    selectAll.onclick = function() {
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    };
</script>
@endsection
