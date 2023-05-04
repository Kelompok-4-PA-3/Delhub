@extends('main')
   
@section('title')
    <title>Manajemen Mahasiswa</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/extra_fab.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script src="{{asset('/assets/js/vendor/editors/ckeditor/ckeditor_classic.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/editor_ckeditor_classic.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush


@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')

    <div class="row">

        <div class="mb-2">
            <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                <li class="nav-item"><a href="#" class="nav-link active"> <i class="ph-squares-four"></i> &nbsp; Kelompok</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Artefak</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Manajemen</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Tugas</a></li>
                <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}/orang" class="nav-link"> <i class="ph-users"></i> &nbsp; Orang</a></li>
                <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}/penilaian" class="nav-link"><i class="ph-notebook"></i> &nbsp; Penilaian</a></li>
            </ul>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                    <h5 class="py-sm-2 my-sm-1">Penilaian {{$penilaian->nama_poin}}</h5><br>
                    <div class="mt-2 mt-sm-0 ms-sm-auto">
                    </div>
                </div>
                <div class="card-body">
                    <table class="table datatable-users">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Nilai</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelompok->kelompok_mahasiswa as $kkm)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$kkm->mahasiswa->nim}}</td>
                                <td>{{$kkm->mahasiswa->user->nama}}</td>
                                @php
                                    
                                @endphp
                                <td>
                                    @if ($kkm->mahasiswa->nilai_mahasiswa(Auth::user()->dosen->role_kelompok($kelompok->id)->role_group_id, $kelompok->id) != NULL)
                                        {{$kkm->mahasiswa->nilai_mahasiswa(Auth::user()->dosen->role_kelompok($kelompok->id)->role_group_id, $kelompok->id)->nilai / ((double)Auth::user()->dosen->role_kelompok($kelompok->id)->role_group->bobot / 100)}} 
                                    @else 
                                        0
                                    @endif
                                    {{-- {{Auth::user()->dosen->role_kelompok($kelompok->id)->role_group_id}} --}}
                                {{-- ->nilai(Auth::user()->dosen->role_kelompok($kelompok))
                                }} --}}
                                </td>
                                <td>
                                    <button data-bs-toggle="offcanvas" data-bs-target="#tambah_penilaian{{$kkm->mahasiswa->nim}}" class="btn btn-sm btn-primary fw-semibold">Nilai</button>    
                                </td>
                            </tr>

                                <!-- Large panel -->
                                <div id="tambah_penilaian{{$kkm->mahasiswa->nim}}" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
                                    <div class="offcanvas-header">
                                        <h5 class="offcanvas-title fw-semibold">Tambah Komponen Penilaian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                    </div>
                                    <div class="offcanvas-body p-2">
                                        <form class="container" action="/kelompok/{{$kelompok->id}}/penilaian/{{$penilaian->id}}/mahasiswa/{{$kkm->mahasiswa->nim}}" method="post">
                                           @csrf
                                           @foreach ($penilaian->komponen_penilaian as $pkp)
                                                <div class="row">
                                                    <div class="col-7">
                                                        {!!$pkp->nama_komponen!!}
                                                    </div>
                                                    <div class="col-2">
                                                        {{$pkp->bobot.'%'}}
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="nilai" class="form-control" name="komponen{{$pkp->id}}" required>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="border-top p-3">
                                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                                <!-- /large panel -->
                                <script>
                                    CKEDITOR.replace('#tambah_penilaian{{$kkm->mahasiswa->nim}}', {
                                        toolbar: 'Basic'
                                    });
                                </script>
                         @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection
