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
            <h5 class="mb-0">Tambah KRS</h5>
        </div>

        <div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form action="/krs" method="post">
                        @csrf
                        <fieldset class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Kategori Mata Kuliah</label>
                                <select data-placeholder="Pilih " class="form-control select" name="mk_id">
                                    <option></option>
                                    <optgroup label="Daftar Kategori Mata Kuliah">
                                        @foreach($kategori as $k)
                                            <option @if(old('mk_id') == $k->id) selected @endif value="{{$k->id}}">{{$k->nama_mk}} - {{$k->kode_mk}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('mk_id')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfigurasi</label>
                                <select data-placeholder="Pilih Konfigurasi" class="form-control select" name="config_id">
                                    <option></option>
                                    <optgroup label="Daftar Konfigurasi">
                                        @foreach($config as $c)
                                            <option @if(old('config_id') == $c->id) selected @endif value="{{$c->id}}">{{$c->tahun_aktif}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('config_id')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Dosen Pembimbing</label>
                                <select data-placeholder="Pilih Konfigurasi" class="form-control select" name="dosen_mk">
                                    <option></option>
                                    <optgroup label="Daftar Dosen">
                                        @foreach($dosen as $d)
                                            <option @if(old('dosen_mk') == $d->nidn) selected @endif value="{{$d->nidn}}">{{$d->user->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('dosen_mk')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Program Studi</label>
                                <select data-placeholder="Pilih program studi" class="form-control select" name="prodi_id">
                                    <option></option>
                                    <optgroup label="Daftar Dosen">
                                        @foreach($prodi as $p)
                                            <option @if(old('prodi_id') == $p->id) selected @endif value="{{$p->id}}">{{$p->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('dosen_mk')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Angkatan</label>
                                <select data-placeholder="Pilih angkatan" class="form-control select" name="angkatan" required>
                                    <option></option>
                                    <optgroup label="Daftar Angkatan">
                                        <option @if(old('angkatan') == '2019') selected @endif value="2019">2019</option>
                                        <option @if(old('angkatan') == '2020') selected @endif value="2020">2020</option>
                                        <option @if(old('angkatan') == '2021') selected @endif value="2021">2021</option>
                                        <option @if(old('angkatan') == '2022') selected @endif value="2022">2022</option>
                                        <option @if(old('angkatan') == '2023') selected @endif value="2023">2023</option>
                                        <option @if(old('angkatan') == '2024') selected @endif value="2024">2024</option>
                                        <option @if(old('angkatan') == '2025') selected @endif value="2025">2025</option>
                                        <option @if(old('angkatan') == '2026') selected @endif value="2026">2026</option>
                                    </optgroup>
                                </select>
                                @error('angkatan')
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