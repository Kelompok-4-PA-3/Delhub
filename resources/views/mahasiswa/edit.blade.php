@extends('main')

@push('select_js')
    <script src="{{asset('../../../assets/js/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('../../../assets/js/vendor/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('../../../assets/demo/pages/form_layouts.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Edit Mahasiswa</h5>
        </div>

        <div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form action="/mahasiswa/{{$mahasiswa->nim}}" method="post">
                        @csrf
                        @method('put')
                        <fieldset class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Pengguna</label>
                                <select data-placeholder="Pilih pengguna" class="form-control select" name="user_id">
                                    <option></option>
                                    <optgroup label="Daftar pengguna">
                                        @foreach($user as $u)
                                            <option value="{{$u->id}}" @if(old('prodi_id', $mahasiswa->user->id) == $u->id) selected @endif>{{$u->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('pengguna')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <input name="nim" type="number" class="form-control" value="{{old('nim',$mahasiswa->nim)}}" placeholder="Masukkan nim disini" required>
                                @error('nim')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Program Studi</label>
                                <select data-placeholder="Pilih pengguna" class="form-control select" name="prodi_id">
                                    <option></option>
                                    <optgroup label="Daftar program studi">
                                        @foreach($prodi as $p)
                                            <option value="{{$p->id}}" @if(old('prodi_id', $mahasiswa->prodi->id) == $p->id) selected @endif>{{$p->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('prodi_id')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Angkatan</label>
                                <select data-placeholder="Pilih angkatan" class="form-control select" name="angkatan" required>
                                    <option></option>
                                    <optgroup label="Daftar Angkatan">
                                        <option @if(old('angkatan', $mahasiswa->angkatan) == '2019') selected @endif value="2019">2019</option>
                                        <option @if(old('angkatan', $mahasiswa->angkatan) == '2020') selected @endif value="2020">2020</option>
                                        <option @if(old('angkatan', $mahasiswa->angkatan) == '2021') selected @endif value="2021">2021</option>
                                        <option @if(old('angkatan', $mahasiswa->angkatan) == '2022') selected @endif value="2022">2022</option>
                                        <option @if(old('angkatan', $mahasiswa->angkatan) == '2023') selected @endif value="2023">2023</option>
                                        <option @if(old('angkatan', $mahasiswa->angkatan) == '2024') selected @endif value="2024">2024</option>
                                        <option @if(old('angkatan', $mahasiswa->angkatan) == '2025') selected @endif value="2025">2025</option>
                                        <option @if(old('angkatan', $mahasiswa->angkatan) == '2026') selected @endif value="2026">2026</option>
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