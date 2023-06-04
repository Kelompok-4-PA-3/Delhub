@extends('main')

@push('select_js')
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_layouts.js') }}"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Jadwal</h5>
        </div>

        <div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form action="/jadwal" method="post">
    @csrf
                            <fieldset class="mb-3">
                            {{-- <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Mandatory fields</legend> --}}

                            <div class="mb-3">
                                <label class="form-label">Nama jadwal</label>
                                <input name="nama_jadwal" type="text" class="form-control" value="{{old('nama')}}" placeholder="Masukkan nama jadwal disini" required>
                                @error('nama')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">URL</label>
                                <input name="url" type="text" class="form-control" value="{{old('nama')}}" placeholder="Masukkan url disini" required>
                                @error('nama')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                        </fieldset>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Kirim <i
                                    class="ph-paper-plane-tilt ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection