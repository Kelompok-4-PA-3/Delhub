@extends('main')
   
@section('title')
    <title>Manajemen Mahasiswa</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    {{-- <script src="{{asset('/assets/demo/pages/picker_date.js')}}"></script> --}}
    {{-- <script src="{{asset('/assets/js/vendor/ui/fab.min.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script> --}}
	<script src="{{asset('/assets/demo/pages/extra_fab.js')}}"></script>
    {{-- <script src="{{asset('/assets/js/jquery/jquery.min.js')}}"></script> --}}
	{{-- <script src="{{asset('/assets/js/vendor/uploaders/fileinput/fileinput.min.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/uploader_bootstrap.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/ui/moment/moment.min.js')}}"></script> --}}
    {{-- <script src="{{asset('/assets/js/vendor/pickers/daterangepicker.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/pickers/datepicker.min.js')}}"></script> --}}
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
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

        <div class="card">
            <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                <h5 class="py-sm-2 my-sm-1">Nilai Mahasiswa</h5><br>
                <div class="mt-2 mt-sm-0 ms-sm-auto">
                </div>
            </div>
            <div class="card-body">
                @if ($poin_penilaian->where('is_verified',false)->count() > 0)
                   <div class="py-5 w-100 text-center">
                        <h3 class="text-muted"><i class="ph-warning mb-1"></i> Poin penilaian belum diverifikasi <i class="ph-warning mb-1"></i></h3>
                        <i class="text-warning">Penilaian tidak dapat dilakukan karena poin penilaian belum diverifikasi</i>
                   </div>
                @else
                <table class="table">
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                            @foreach($poin_penilaian as $pp)
                            <th>
                                <div class="fw-semibold d-flex">
                                   
                                    <a  @if($pp->komponen_penilaian->where('is_verified',false)->count() > 0 || $pp->komponen_penilaian->count() > 0)  href="/kelompok/{{$kelompok->id}}/penilaian/{{$pp->id}}" @endif>{{$pp->nama_poin}}</a>
                                    @if ($pp->komponen_penilaian->where('is_verified',false)->count() > 0 || $pp->komponen_penilaian->count() <= 0)
                                        <a href="#" class="ph-warning-circle px-1 text-warning" data-bs-popup="tooltip" title="Komponen penilaian pada poin ini belum tersedia atau belum terverifikasi"></a>
                                    @endif
                                </div>
                                <div>
                                    <small class="text-muted">{{$pp->bobot}} %</small>
                                </div>
                            </th>
                            @endforeach
                        {{-- @else
                            <td>
                                <small><i class="text-warning">Komponen penilaian pada penilaian ini belum diverifikasi</i></small><br>
                                <small><i><a class="" href="">Cek komponen disini</a></i></small>
                            </td>
                        @endif --}}
                        <th>Total</th>
                    </tr>
                        @foreach($kelompok->kelompok_mahasiswa as $kkm)
                        <tr>
                            <td>{{$kkm->mahasiswa->nim}}</td>
                            <td>{{$kkm->mahasiswa->user->nama}}</td>
                         {{-- @if ($poin_penilaian->where('is_verified',false)->count() == 0)  --}}
                            @foreach($poin_penilaian as $pp)
                                <td>
                                    -
                                </td>
                             @endforeach
                        {{-- @else
                            <td>
                                <small><i class="text-warning">Komponen penilaian pada penilaian ini belum diverifikasi</i></small><br>
                            </td>
                        @endif --}}
                        <td>-</td>
                        </tr>
                        @endforeach
                        <td></td>
                    
                    {{-- <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                    </tr> --}}
                </table>
                @endif
            </div>
        </div>



        <div class="col-xl-8">

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

          

        </div>


        <div class="col-xl-4">

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
                                </div>
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
    </div>

@endsection
