@extends('main')

@section('title')
    <title>Kartu Rencana Studi</title>
@endsection

@push('select_js')
    <script src="{{asset('../../../assets/js/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('../../../assets/js/vendor/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('../../../assets/demo/pages/form_layouts.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('breadscrumb')
    <a href="/krs" class="breadcrumb-item active py-2"><i class="ph-squares-four"></i>&nbsp;Manajemen KRS</a>
    <span class="breadcrumb-item active py-2">Tambah KRS</span>
@endsection

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
                                <label class="form-label">Tahun Ajaran</label>
                                <select data-placeholder="Pilih Konfigurasi" class="form-control select" name="config_id">
                                    <option></option>
                                    <optgroup label="Daftar Konfigurasi">
                                        @foreach($config as $c)
                                            <option @if(old('config_id') == $c->id) selected @endif value="{{$c->id}}">{{$c->tahun_aktif}} - {{$c->semester == '1' ? 'Gasal' : 'Genap'}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('config_id')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kooridnator</label>
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
                                <label class="form-label">Kooridnator 2</label>
                                <select data-placeholder="Pilih Konfigurasi" class="form-control select" name="dosen_mk_2">
                                    <option></option>
                                    <optgroup label="Daftar Dosen">
                                        @foreach($dosen as $d)
                                            <option @if(old('dosen_mk_2') == $d->nidn) selected @endif value="{{$d->nidn}}">{{$d->user->nama}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('dosen_mk_2')
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

                            <div class="mb-3">
                                <label class="form-label">Salin KRS</label>
                                <select data-placeholder="Pilih krs" id="krs_copy_select" class="form-control select" name="krs_copy" required>
                                    <optgroup label="Daftar Angkatan">
                                        <option></option>
                                        @foreach ($krs->where('kate') as $k)
                                            <option @if(old('krs_copy') == $k->id) selected @endif value="{{$k->id}}">{{$k->kategori->nama_mk}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
{{-- 
                            <div class="" id="form-copy container">
                               <div>
                                    <h5 class="fw-light"><i class="ph-copy text-success"></i> Pilih fitur yang ingin di copy</h5>
                               </div>
                               <div class="row border border-1 p-2 rounded">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline form-switch">
                                            <input id="kategori_role" name="kategori_role" type="checkbox" class="form-check-input" value="true">
                                            <label for="kategori_role" class="form-check-label">Jumlah Kelompok</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch">
                                            <input id="kategori_role" name="kategori_role" type="checkbox" class="form-check-input" value="true">
                                            <label for="kategori_role" class="form-check-label">Kategori Role</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch">
                                            <input id="kategori_role" name="kategori_role" type="checkbox" class="form-check-input" value="true">
                                            <label for="kategori_role" class="form-check-label">Poin Penilaian</label>
                                        </div>
                                        <div class="form-check form-check-inline form-switch">
                                            <input id="kategori_role" name="kategori_role" type="checkbox" class="form-check-input" value="true">
                                            <label for="kategori_role" class="form-check-label">Kategori Role</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                    </div>
                               </div>
                            </div> --}}

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


    <script>
        // var copy_krs_field = document.getElementById('form-copy').style.display = "none";
        // var select = document.getElementById('krs_copy_select');
    
        // select.addEventListener('change', function() {
        //     console.log('success');
        //     var selectedOption = select.options[select.selectedIndex];
    
        //     if (selectedOption.value != '') {
        //         document.getElementById('form-copy').style.display = 'block';
        //     } else {
        //         document.getElementById('form-copy').style.display = 'none';
        //     }
        // });
        // $('#form-copy').hide();

    //     $(document).ready(function() {
    //     $('#krs_copy_select').change(function() {
    //         if ($(this).val() !== '') {
    //             $('#form-copy').show();
    //         } else {
    //             $('#form-copy').hide();
    //         }
    //     });
    // });
    </script>


@endsection
