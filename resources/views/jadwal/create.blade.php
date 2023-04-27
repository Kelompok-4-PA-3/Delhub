-@extends('main')

@push('select_js')
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_layouts.js') }}"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
        @csrf
        @method('PUT')
        @foreach($kelompoks as $k)
            <h5 class="mb-0">{{ $k->nama_kelompok }}</h5>
        @endforeach
        </div>

        <div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form action="{{ route('jadwal.store') }}" method="post">
                        @csrf
                        <fieldset class="mb-3">

                            <div class="mb-3">
                                <label class="form-label">Tanggal Bimbingan</label>
                                <input type="date" class="form-control" name="tanggal" required>
                                @error('tanggal')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Waktu Bimbingan</label>
                                <input type="time" class="form-control" name="waktu" required>
                                @error('waktu')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ruangan</label>
                                <input name="ruangan" type="text" class="form-control" value="{{old('ruangan')}}" placeholder="Masukkan Ruangan" required>
                                @error('ruangan')
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
