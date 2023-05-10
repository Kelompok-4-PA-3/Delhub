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
            <div class="mb-2">
                <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                    <li class="nav-item"><a href="#" class="nav-link active"> <i class="ph-squares-four"></i> &nbsp; Kelompok</a></li>
                    <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Artefak</a></li>
                    <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Manajemen</a></li>
                    <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Tugas</a></li>
                    <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}/orang" class="nav-link"> <i class="ph-users"></i> &nbsp; Orang</a></li>
                    {{-- @if (Auth::user()->dosen() != NULL)
                        @if (array_intersect(Auth::user()->dosen->role_kelompok($kelompok->id)->pluck('id')->toArray(), $kelompok->role_kelompok->pluck('id')->toArray())) --}}
                    <li class="nav-item">
                        <a href="" class="nav-link btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><i class="ph-notebook"></i> &nbsp; Penilaian</a>
                        <div class="dropdown-menu">
                            @foreach (Auth::user()->dosen->role_kelompok($kelompok->id) as $myrole)
                                <a href="/kelompok/{{$kelompok->id}}/penilaian/role/{{$myrole->id}}" class="dropdown-item"><i class="ph-notebook"></i> &nbsp;{{$myrole->role_group->nama}}</a>
                            @endforeach
                            {{-- {{Auth::user()->dosen->all_role_kelompok}} --}}
                        </div>
                    </li>
                        {{-- @endif
                    @endif --}}
                    {{-- {{Auth::user()->dosen->role_kelompok($kelompok->id)}} --}}
                    @if ($kelompok->krs->dosen_mk == Auth::user()->dosen->nim || $kelompok->krs->dosen_mk_2 == Auth::user()->dosen->nim)
                        <li class="nav-item">
                            <a href="/kelompok/{{$kelompok->id}}/penilaian/koordinator" class="nav-link btn btn-primary"><i class="ph-notebook"></i> &nbsp; Hasil Penilaian</a>
                        </li>
                    @endif  
                </ul>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                    <h5 class="py-sm-2 my-sm-1">Penilaian {{$roleGroup->nama}}</h5><br>
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
                                    @if ($kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $roleGroup->id) != NULL)
                                        {{$kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $roleGroup->id)->nilai}} 
                                    @else 
                                        0
                                    @endif
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
                                        {{-- {{$role_dosen->id}} --}}
                                        <form class="container" action="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/{{$roleGroup->id}}/mahasiswa/{{$kkm->mahasiswa->nim}}" method="post">
                                           @csrf
                                           @foreach ($roleGroup->komponen_penilaian as $rkp)
                                                <div class="row">
                                                    <div class="col-7">
                                                        {!!$rkp->nama_komponen!!}
                                                    </div>
                                                    <div class="col-2">
                                                        {{$rkp->bobot.'%'}}
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" class="form-control" name="komponen{{$rkp->id}}" max="100" min="0" required>
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
                                {{-- <script>
                                    CKEDITOR.replace('#tambah_penilaian{{$kkm->mahasiswa->nim}}', {
                                        toolbar: 'Basic'
                                    });
                                </script> --}}
                         @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection
