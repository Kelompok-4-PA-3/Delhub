@extends('main')

@section('title')
    <title>Manajemen Fakultas</title>
@endsection

@push('select_js')
    <script src="{{asset('../../../assets/js/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('../../../assets/js/vendor/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('../../../assets/demo/pages/form_layouts.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('breadscrumb')
    <a href="/fakultas" class="breadcrumb-item active py-2"><i class="ph-circles-four"></i>&nbsp;Manajemen Fakultas</a>
    <span class="breadcrumb-item active py-2">Tambah Fakultas</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Fakultas</h5>
        </div>

        <div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form action="/prodi" method="post">
                        @csrf
                        <fieldset class="mb-3">
                            {{-- <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Mandatory fields</legend> --}}

                            <div class="mb-3">
                                <label class="form-label">Fakultas</label>
                                <select class="form-select" name="fakultas_id">
                                    @foreach ($fakultas as $f)
                                        <option value="{{  $f->id }}">{{  $f->nama }}</option>
                                    @endforeach
                                </select>
                                @error('fakultas')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <!-- <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    @foreach ($statuses as $s)
                                        <option value="{{  $s->deskripsi }}">{{  $s->deskripsi }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div> -->

                            <!-- <div class="mb-3">
                                <label class="form-label">Status</label>
                                <input name="status" type="text" class="form-control" value="{{old('status')}}" placeholder="Masukkan status" required>
                                @error('status')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div> -->

                        </fieldset>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="chart position-relative" id="traffic-sources"></div>
    </div>
@endsection
