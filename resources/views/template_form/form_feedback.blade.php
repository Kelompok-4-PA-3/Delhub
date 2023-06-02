@extends('main')

@section('title')
    <title>Dokumen</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
<div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Data Kelompok</h5>
        </div>

<div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form action="{{route('formfeedback.formFeedback') }}" method="post">
                        @csrf
                        <fieldset class="mb-3">


                            <div class="mb-3">
                                <label class="form-label">Kelompok</label>
                                <input name="kelompok" type="number" class="form-control" value="{{old('kelompok')}}" placeholder="Masukkan nomor kelompok disini" required>
                                @error('kelompok')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>


                        <div class="mb-3">
                            <div class="row">
                            <b><p>Mahasiswa 1</p></b>
                            <div class="col-sm-6">
                                <label class="form-label">Nama</label>
                                <input name="nama1" type="text" class="form-control" value="{{old('nama1')}}" placeholder="Masukkan nama  disini" required>
                                @error('nama1')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label">NIM</label>
                                <input name="nim1" type="text" class="form-control" value="{{old('nim1')}}" placeholder="Masukkan NIM  disini" required>
                                @error('nim1')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="mb-3">
                            <div class="row">
                            <b><p>Mahasiswa 2</p></b>
                            <div class="col-sm-6">
                                <label class="form-label">Nama</label>
                                <input name="nama2" type="text" class="form-control" value="{{old('nama2')}}" placeholder="Masukkan nama  disini" required>
                                @error('nama2')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                           <div class="col-sm-6">
                                <label class="form-label">NIM</label>
                                <input name="nim2" type="text" class="form-control" value="{{old('nim2')}}" placeholder="Masukkan NIM  disini">
                                @error('nim2')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <div class="mb-3">
                            <div class="row">
                            <b><p>Mahasiswa 3</p></b>
                            <div class="col-sm-6">
                                <label class="form-label">Nama</label>
                                <input name="nama3" type="text" class="form-control" value="{{old('nama3')}}" placeholder="Masukkan nama  disini">
                                @error('nama3')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label">NIM</label>
                                <input name="nim3" type="text" class="form-control" value="{{old('nim3')}}" placeholder="Masukkan NIM  disini">
                                @error('nim3')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <br>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input name="tanggal" type="date" class="form-control" value="{{old('tanggal')}}" placeholder="Masukkan tanggal  disini">
                                @error('tanggal')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hari</label>
                                <input name="hari" type="text" class="form-control" value="{{old('hari')}}" placeholder="Masukkan hari  disini">
                                @error('hari')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-2">
                            <div class="row">
                                <label class="form-label">Waktu</label>
                                <div class="col-sm-1">
                                <input name="mulai" type="time" class="form-control" value="{{old('mulai')}}" placeholder="Masukkan NIM  disini">
                                @error('mulai')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                                </div>
                                -
                                <div class="col-sm-1">
                                <input name="selesai" type="time" class="form-control" value="{{old('selesai')}}" placeholder="Masukkan NIM  disini">
                                @error('selesai')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                                </div>
                            </div>
                            </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ketua Prasidang</label>
                                <input name="ketua" type="text" class="form-control" value="{{old('ketua')}}" placeholder="Masukkan nama disini">
                                @error('ketua')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ketua Penguji</label>
                                <input name="penguji1" type="text" class="form-control" value="{{old('penguji1')}}" placeholder="Masukkan nama disini">
                                @error('penguji1')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Anggota Penguji</label>
                                <input name="penguji2" type="text" class="form-control" value="{{old('penguji2')}}" placeholder="Masukkan nama disini">
                                @error('penguji2')
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
        </div>

<!-- <h2>PHP Word</h2>

<form method="post" action="{{route('formfeedback.formFeedback') }}">
@csrf
<input type="number" name="kelompok">
<input type="text" name="nama1">
<input type="text" name="nim1">
<input type="text" name="nama2">
<input type="text" name="nim2">
<input type="text" name="nama3">
<input type="text" name="nim3">
<input type="date" name="tanggal">
<input type="text" name="hari">
<input type="time" name="mulai">
<input type="time" name="selesai">
<input type="text" name="ketua">
<input type="text" name="penguji1">
<input type="text" name="penguji2">

<input type="submit" value="Submit" />

</form> -->

@endsection
