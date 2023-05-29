@extends('main')

@section('title')
    <title>Manajemen Dosen</title>
@endsection

@push('select_js')
    <script src="{{asset('../../../assets/js/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('../../../assets/js/vendor/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('../../../assets/demo/pages/form_layouts.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('breadscrumb')
    <a href="/dosen" class="breadcrumb-item active py-2"><i class="ph-chalkboard-teacher"></i>&nbsp;Manajemen Dosen</a>
    <span class="breadcrumb-item active py-2">Tambah Dosen</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Dosen</h5>
        </div>

        <div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form action="/dosen" method="post">
                        @csrf
                        <fieldset class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Pengguna</label>
                                <select data-placeholder="Pilih pengguna" class="form-control select" name="user_id">
                                    <option></option>
                                    <optgroup label="Daftar pengguna">
                                        @foreach($user as $u)
                                            <option @if(old('user_id') == $u->id) selected @endif value="{{$u->id}}">{{$u->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('pengguna')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Singkat</label>
                                <input name="nama_singkat" type="text" class="form-control" value="{{old('nama_singkat')}}" placeholder="Masukkan nama singkat disini" required>
                                @error('nama_singkat')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">NIDN</label>
                                <input name="nidn" type="number" class="form-control" value="{{old('nidn')}}" placeholder="Masukkan nidn disini" required>
                                @error('nidn')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Program Studi</label>
                                <select data-placeholder="Pilih pengguna" class="form-control select" name="prodi_id">
                                    <option></option>
                                    <optgroup label="Daftar pengguna">
                                        @foreach($prodi as $p)
                                            <option @if(old('prodi_id') == $p->id) selected @endif value="{{$p->id}}">{{$p->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('prodi_id')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
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