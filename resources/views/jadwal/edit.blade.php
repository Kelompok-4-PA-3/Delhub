@extends('main')

@push('select_js')
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/form_layouts.js') }}"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Edit JAdwal</h5>
        </div>

        <div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form method="POST" action="{{ route('jadwal.update', $jadwal->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="kel">Kelas</label>
        <input type="text" name="kel" class="form-control" value="{{ $jadwal->kel }}">
    </div>
    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="{{ $jadwal->tanggal }}">
    </div>
    <div class="form-group">
        <label for="waktu">Waktu</label>
        <input type="time" name="waktu" class="form-control" value="{{ $jadwal->waktu }}">
    </div>
    <div class="form-group">
        <label for="ruangan">Ruangan</label>
        <input type="text" name="ruangan" class="form-control" value="{{ $jadwal->ruangan }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

                </div>
            </div>
        </div>
    </div>
@endsection
