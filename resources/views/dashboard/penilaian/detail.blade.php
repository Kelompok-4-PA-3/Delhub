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
                                <td>-</td>
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
                                    {{-- {{$penilaian->komponen_penilaian}} --}}
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
                                                        <input type="number" class="form-control" name="{{$pkp->id}}">
                                                    </div>
                                                </div>
                                                {{-- {{Auth::user()->dosen()->}} --}}
                                            @endforeach
                                            <div class="border-top p-3">
                                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                                            </div>
                                        </form>
                                          {{--@foreach ($penilaian->komponen_penilaian as $pkp)
                                        <div class="card">
                                            <div class="card-header container">
                                                <h6>Penilaian {{$pkp->nama}}</h6>
                                            </div>
                                            <form action="/kelompok/{{$kelompok->id}}/{{$km->mahasiswa->nim}}/penilaian" method="post">
                                                @csrf
                                                @foreach($pkp->komponen_penilaian as $pk)
                                                @php 
                                                    $role_penilaian = app('role_penilaian')->role_penilaian($kelompok);
                                                @endphp
                                                <input type="hidden" name="poin_regulasi_id" value="{{$pkp->id}}">
                                                @if ($konfigurasi != NULL)
                                                    <input type="hidden" name="role_penilaian" value="
                                                        @if($role_penilaian == 'pembimbing_1')
                                                            {{$konfigurasi->pembimbing_1}}
                                                        @elseif($role_penilaian == 'pembimbing_2')
                                                            {{$konfigurasi->pembimbing_2}}
                                                        @elseif($role_penilaian == 'penguji_1')
                                                            {{$konfigurasi->penguji_1}}
                                                        @elseif($role_penilaian == 'penguji_2')
                                                            {{$konfigurasi->penguji_2}}
                                                        @endif
                                                    ">
                                                @endif
                                                
                                                <input type="hidden" name="role" value="">
                                                <div class="row container">
                                                    <div class="col-7 mb-1">
                                                        <p>{!!$pk->komponen_penilaian!!}</p>
                                                    </div>
                                                    <div class="col-2 mb-1">
                                                        <p>{{$pk->bobot}}%</p>
                                                    </div>
                                                    <div class="col-3 mb-1">
                                                        {{$pk->detail_nilai_mahasiswa}}
                                                </div>
                                                @endforeach
                                                <div class="border-top p-3">
                                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endforeach --}}
                                    </div>
                                </div>
                                <!-- /large panel -->
                                <script>
                                    // Initialize first editor instance with custom configuration options
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
       

        {{-- <div class="col-xl-8">

            <div class="card">
                <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                    <h5 class="py-sm-2 my-sm-1">Penilaian Mahasiswa</h5><br>
                    <div class="mt-2 mt-sm-0 ms-sm-auto">
                    </div>
                </div>
                <div class="card-body">
                    @foreach($poin_penilaian as $pp)
                    <div class="p-1">
                        <div class="d-flex mb-2">
                            <a href="#" class="bg-info bg-opacity-10 text-info lh-1 rounded-pill p-2 me-3">
                                <i class="ph-note"></i>
                            </a>
                            <div>
                                <div class="fw-semibold">
                                    <a href="/kelompok/{{$pp->id}}">{{$pp->nama_poin}}</a>
                                </div>
                                <div>
                                    <small class="text-muted">{{$pp->bobot}} %</small>
                                </div>
                            </div>
                        </div>
                        <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                    </div>
                    @endforeach
                </div>
            </div>

            @foreach ($poin_regulasi as $p)
                <div class="p-2 card">
                    <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                        <h5 class="py-sm-2 my-sm-1">Komponen penilaian {{$pkp->nama}}</h5><br>
                        <div class="mt-2 mt-sm-0 ms-sm-auto">
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Komponen penilaian</th>
                                <th>Bobot</th>
                            </tr>
                            @foreach($pkp->komponen_penilaian as $pk)
                            <tr>
                                <td>{!!$pk->komponen_penilaian!!}</td>
                                <td>{!!$pk->bobot!!} %</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endforeach

        </div> --}}


        {{-- <div class="col-xl-4">

            <!-- Sales stats -->
            <div class="card">
                <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                    <h5 class="py-sm-2 my-sm-1">Bobot penilaian </h5><br>
                    <div class="mt-2 mt-sm-0 ms-sm-auto">
                    </div>
                </div>
             
                <div class="card-body pb-0">

                      <!-- Tabs -->
                      <ul class="nav nav-tabs nav-tabs-underline nav-justified">
                        <li class="nav-item">
                            <a href="#daftar-konfigurasi" class="nav-link active" data-bs-toggle="tab">
                                Daftar   
                            </a>
                        </li>
                         <li class="nav-item">
                             <a href="#edit-konfigurasi" class="nav-link" data-bs-toggle="tab">
                                {{$konfigurasi == NULL ? 'Tambah' : 'Update'}}
                             </a>
                         </li>
                    </ul>
                    <!-- /tabs -->
                    <!-- Tabs content -->
                    <div class="tab-content card-body">
                        <div class="tab-pane active fade show" id="daftar-konfigurasi">
                            <table class="table">
                                @if ($konfigurasi != NULL)
                                    <tr>
                                        <td>Pembimbing 1</td>
                                        <td>{{$konfigurasi->pembimbing_1}}</td>
                                    </tr>
                                    <tr>
                                        <td>Pembimbing 2</td>
                                        <td>{{$konfigurasi->pembimbing_2}}</td>
                                    </tr>
                                    <tr>
                                        <td>Penguji 1</td>
                                        <td>{{$konfigurasi->penguji_1}}</td>
                                    </tr>
                                    <tr>
                                        <td>Penguji 2</td>
                                        <td>{{$konfigurasi->penguji_2}}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <div class="tab-pane active fade" id="edit-konfigurasi">
                            <form action="/krs/{{$kelompok->krs->id}}/config-penilaian" method="post">
                                @csrf
                                <input type="hidden" value="{{$kelompok->krs->id}}" name="krs_id">
                                <div class="row">
                                    <div class="col-6">
                                       <label for="" class="py-1"> Pembimbing 1</label>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-control-feedback form-control-feedback-end mb-3">
                                            <input type="number" class="form-control" value="{{old('pembimbing_1', $konfigurasi == NULL ? 0 : $konfigurasi->pembimbing_1 )}}" name="pembimbing_1" placeholder="Bobot.." min="0" max="100">
                                            <div class="form-control-feedback-icon">
                                                <i class="ph-percent ph-sm"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>v 
                                <div class="row">
                                    <div class="col-6">
                                       <label for="" class="py-1"> Pembimbing 2</label>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-control-feedback form-control-feedback-end mb-3">
                                            <input type="number" class="form-control" value="{{old('pembimbing_2', $konfigurasi == NULL ? 0 : $konfigurasi->pembimbing_2 )}}" name="pembimbing_2" placeholder="Bobot.." min="0" max="100">
                                            <div class="form-control-feedback-icon">
                                                <i class="ph-percent ph-sm"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                       <label for="" class="py-1"> Penguji 1</label>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-control-feedback form-control-feedback-end mb-3">
                                            <input type="number" class="form-control" value="{{old('penguji_1', $konfigurasi == NULL ? 0 : $konfigurasi->penguji_1 )}}" name="penguji_1" placeholder="Bobot.." min="0" max="100">
                                            <div class="form-control-feedback-icon">
                                                <i class="ph-percent ph-sm"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                       <label for="" class="py-1"> Penguji 2</label>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-control-feedback form-control-feedback-end mb-3">
                                            <input type="number" class="form-control" value="{{old('penguji_2', $konfigurasi == NULL ? 0 : $konfigurasi->penguji_2 )}}" name="penguji_2" placeholder="Bobot.." min="0" max="100">
                                            <div class="form-control-feedback-icon">
                                                <i class="ph-percent ph-sm"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary w-100">Submit</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    <!-- /tabs content -->

                   
                </div>

                <div class="chart mb-2" id="app_sales"></div>
                <div class="chart" id="monthly-sales-stats"></div>
            </div>
            <!-- /sales stats -->
        </div>
    </div> --}}

@endsection
