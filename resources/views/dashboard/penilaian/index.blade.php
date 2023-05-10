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
                {{-- @if (Auth::user()->dosen() != NULL)
                    @if (array_intersect(Auth::user()->dosen->role_kelompok($kelompok->id)->pluck('id')->toArray(), $kelompok->role_kelompok->pluck('id')->toArray())) --}}
                <li class="nav-item">
                    <a href="" class="nav-link btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><i class="ph-notebook"></i> &nbsp; Penilaian</a>
                    <div class="dropdown-menu">
                        @foreach (Auth::user()->dosen->role_kelompok->where('kelompok_id',$kelompok->id) as $myrole)
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
                    @php
                    $btn_approve = true;  
                    foreach ($kelompok->kelompok_mahasiswa as $kkm) {
                    foreach ($poin_penilaian as $pp) {
                            if ($kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $pp->id) != NULL) {
                                $btn_approve = false;
                            }
                    }
                    }
                @endphp
                    <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>
                            {{-- {{}} --}}
                            <a href="/kelompok/{{$kelompok->id}}/penilaian/role_kelompok/{{$role_dosen->id}}/{{$role_dosen->role_group->id}}">{{$role_dosen->role_group->nama}}</a>
                            <div>
                                <small class="text-muted">{{$role_dosen->role_group->bobot}} %</small>
                            </div>
                        </th>
                            @foreach($poin_penilaian as $pp)
                            <th>
                                <div class="fw-semibold d-flex">
                                    <a  @if($pp->komponen_penilaian->where('is_verified',false)->count() > 0 || $pp->komponen_penilaian->count() > 0)  href="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/{{$pp->id}}" @endif>{{$pp->nama_poin}}</a>
                                    @if ($pp->komponen_penilaian->where('is_verified',false)->count() > 0 || $pp->komponen_penilaian->count() <= 0)
                                        <a href="#" class="ph-warning-circle px-1 text-warning" data-bs-popup="tooltip" title="Komponen penilaian pada poin ini belum tersedia atau belum terverifikasi"></a>
                                    @endif
                                </div>
                                <div>
                                    <small class="text-muted">{{$pp->bobot}} %</small>
                                </div>
                            </th>
                            @endforeach
                        <th>Total
                            <form action="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/approved" class="mt-1" method="post">
                                {{-- {{$myrole}} --}}
                                @csrf
                                @php
                                $all_approved = $kelompok->nilai_mahasiswa->pluck('approved_status')->every(function($status){
                                    // return $status != 1;
                                    if ($status == 0) {
                                        return 1;
                                    }elseif($status == 1){
                                        return 0; 
                                    }else{
                                        return 3;
                                    }
                                });
                                // $all_not_approved = $kelompok->nilai_mahasiswa->pluck('approved_status')->every(function($status){
                                //     return $statis == 1;
                                // });
                                @endphp 
                                {{-- {{$all_approved}} --}}
                                <input type="hidden" name="approved_status" value="
                                    @if ((int)$all_approved != 3)
                                        {{(int)$all_approved}}
                                    @endif
                                ">
                                {{-- {{$all_approved}} --}}
                                @if ((int)$all_approved == 0)
                                    <button type="button"  class="btn btn-warning btn-sm border-0 fw-semibold" data-bs-toggle="modal" data-bs-target="#cancel_approve"><i class="ph-x-circle"></i> &nbsp; Batalkan</button> 
                                @elseif((int)$all_approved == 1)
                                    <button type="submit" class="btn btn-success btn-sm border-0 fw-semibold {{$btn_approve == 1 ? 'disabled' : ''}}" ><i class="ph-circle-wavy-check"></i> &nbsp;Approve</button>   
                                @endif
                            </form>
                        </th>
                    </tr>

                    <!-- Delete Modal -->
                    <div id="cancel_approve" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    Apakah anda yakin ingin membatalkan approve seluruh nilai? 
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <form action="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/approved" method="post">
                                        @csrf
                                        <input type="hidden" name="approved_status" value="0" />
                                        <button type="submit" class="btn btn-primary">Ya</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Delete Modal -->

                    @foreach($kelompok->kelompok_mahasiswa as $kkm)
                    @php  
                        ${"total_nilai".$kkm->nim} = 0;
                    @endphp
                    <tr>
                        <td>{{$kkm->mahasiswa->nim}}</td>
                        <td>{{$kkm->mahasiswa->user->nama}}</td>
                        <td>-</td>
                        @foreach($poin_penilaian as $pp)
                            <td>
                                @if ($kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $pp->id) != NULL)
                                    @if ($pp->id == $kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $pp->id)->poin_penilaian_id)
                                        @php
                                            ${"total_nilai".$kkm->nim} += (($kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $pp->id)->nilai) * ($pp->bobot / 100));
                                            // / ((double)$role_dosen->role_group->bobot / 100)
                                        @endphp
                                        {{$kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $pp->id)->nilai}}
                                    @else 
                                    0 
                                    @endif
                                @else 
                                    -
                                @endif
                            </td>
                         @endforeach
                        <td class="
                            @if ((int)$all_approved == 3)
                                text-primary
                            @elseif((int)$all_approved == 0)
                                bg-success
                            @elseif((int)$all_approved == 1)
                                bg-warning
                            @endif
                        ">{{number_format(${"total_nilai".$kkm->nim}, 2, '.', '')}}</td>
                    </tr>
                    @endforeach
                    <td></td>
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
