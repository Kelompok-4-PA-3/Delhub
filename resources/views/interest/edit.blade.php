+@extends('main')

@push('select_js')
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_layouts.js') }}"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Edit Antusias</h5>
        </div>

        <div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form action="{{ route('interest.update', $interest->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <fieldset class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input name="nama" type="text"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Masukkan nama disini" value="{{ $interest->nama }}" />
                                @error('nama')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <input name="keterangan" type="text"
                                    class="form-control @error('keterangan') is-invalid @enderror"
                                    placeholder="Masukkan keterangan disini" value="{{ $interest->keterangan }}" />
                                @error('keterangan')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </fieldset>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Simpan
                                <i class="ph-paper-plane-tilt ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
