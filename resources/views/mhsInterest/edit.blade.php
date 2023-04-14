@extends('main')

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
                    <form action="{{ route('mhsInterest.update', $mhsinterest->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <fieldset class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Mahasiswa</label>
                                <select name="nim" class="form-select @error('nim') is-invalid @enderror">
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach ($mahasiswas as $item)
                                        <option value="{{ $item->nim }}"
                                            {{ $item->nim == $mhsinterest->nim ? 'selected' : '' }}>
                                            {{ $item->nama . ' - ' . $item->nim }}</option>
                                    @endforeach
                                </select>
                                @error('nim')
                                    <div class="text-danger text-sm p-1">
                                        <i class="ph-warning-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Antusias</label>
                                <select name="interest" class="form-select @error('interest') is-invalid @enderror">
                                    <option value="">Pilih Antusias</option>
                                    @foreach ($interests as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $mhsinterest->interest_id ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('interest')
                                    <div class="text-danger text-sm p-1">
                                        <i class="ph-warning-circle"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </fieldset>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit <i
                                    class="ph-paper-plane-tilt ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
