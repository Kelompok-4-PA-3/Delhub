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


@section('breadscrumb')
@role('dosen')
@if (Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk || Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk_2) 
    <a href="/koordinator/myproject" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
    <a href="/koordinator/proyeksaya/{{$kelompok->krs->id}}" class="breadcrumb-item py-2"> {{$kelompok->krs->kategori->nama_singkat}}</a>
@endif
@endrole
	<a href="/kelompok/{{$kelompok->id}}" class="breadcrumb-item py-2"> {{$kelompok->nama_kelompok}}</a>
	<span class="breadcrumb-item active py-2">{{$role_dosen->role_group->nama}}</span>
@endsection


@section('content')

    <div class="row">

        <div class="mb-2">
            <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}" class="nav-link"> <i class="ph-squares-four"></i> &nbsp; Kelompok</a></li>
                <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}/orang" class="nav-link"> <i class="ph-users"></i> &nbsp; Orang</a></li>
                @role('dosen')
                    <li class="nav-item">
                        <a href="" class="nav-link btn btn-primary dropdown-toggle active" data-bs-toggle="dropdown"><i class="ph-notebook"></i> &nbsp; Penilaian</a>
                        <div class="dropdown-menu">
                            @foreach (Auth::user()->dosen->role_kelompok->where('kelompok_id',$kelompok->id) as $myrole)
                            @if ($myrole->role_group != NULL)
                                <div class="list-group">
                                    <div class="d-flex">
                                        <a @if($myrole->is_verified) href="/kelompok/{{$kelompok->id}}/penilaian/role/{{$myrole->id}}" @endif  class="dropdown-item"><i class="ph-notebook"></i> &nbsp;{{$myrole->role_group->nama}} &nbsp; @if(!$myrole->is_verified) <i class="ph-warning-circle text-warning" style="cursor:pointer;" data-bs-popup="tooltip" title="Role anda belum diverfikasi"></i> @endif</a>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                        </div>
                    </li>
                @endrole
                @role('dosen')
                    @if ($kelompok->krs->dosen_mk == Auth::user()->dosen->nim || $kelompok->krs->dosen_mk_2 == Auth::user()->dosen->nim)
                        <li class="nav-item">
                            <a href="/kelompok/{{$kelompok->id}}/penilaian/koordinator" class="nav-link active btn btn-primary"><i class="ph-notebook"></i> &nbsp; Hasil Penilaian</a>
                        </li>
                    @endif  
                @endrole
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
                        {{-- <th>
                            <div class="fw-semibold d-flex">
                                <a
                                @if ($role_dosen->role_group->komponen_penilaian->where('is_verified',false)->count() > 0 || $role_dosen->role_group->komponen_penilaian->count() <= 0)
                                @else
                                    href="/kelompok/{{$kelompok->id}}/penilaian/role_kelompok/{{$role_dosen->id}}/{{$role_dosen->role_group->id}}"
                                @endif
                                >{{$role_dosen->role_group->nama}}</a>
                                @if ($role_dosen->role_group->komponen_penilaian->where('is_verified',false)->count() > 0 || $role_dosen->role_group->komponen_penilaian->count() <= 0)
                                    <a href="#" class="ph-warning-circle px-1 text-warning" data-bs-popup="tooltip" title="Komponen penilaian pada poin ini belum tersedia atau belum terverifikasi"></a>
                                @endif
                            </div>
                            <div>
                                <small class="text-muted">{{$role_dosen->role_group->bobot}} %</small>
                            </div>
                        </th> --}}
                        {{-- {{$role_dosen->role_group->role_group_penilaian}} --}}
                        @if ($role_dosen->role_group != NULL)
                            @foreach($role_dosen->role_group->role_group_penilaian as $rr)
                            <th>
                                @if ($rr->poin_penilaian != NULL)
                                    <div class="fw-semibold d-flex">
                                        <a  @if($rr->poin_penilaian->komponen_penilaian->where('is_verified',false)->count() <= 0 
                                                && $rr->poin_penilaian->komponen_penilaian->count() > 0 && $rr->poin_penilaian->role_group_penilaian->where('is_verified',false)->count() <= 0)
                                                href="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/{{$rr->poin_penilaian->id}}"
                                            @endif>
                                            {{$rr->poin_penilaian->nama_poin}}
                                        </a>
                                        @if ($rr->poin_penilaian->komponen_penilaian->where('is_verified',false)->count() > 0
                                        || $rr->poin_penilaian->komponen_penilaian->count() <= 0 ||  $rr->poin_penilaian->role_group_penilaian->where('is_verified',false)->count() > 0)
                                            <a href="#" class="ph-warning-circle px-1 text-warning" data-bs-popup="tooltip" title="Komponen penilaian pada poin ini belum tersedia atau belum terverifikasi"></a>
                                        @endif
                                    </div>
                                    <div>
                                        <small class="text-muted">{{$rr->poin_penilaian->bobot}} %</small>
                                    </div>
                                @else
                                    <small> {{$rr}} ( <i>Belum memiliki komponen penilaian</i> )</small>
                                @endif
                            </th>
                            @endforeach
                        @endif
                           
                        {{-- <th>Total
                            <form action="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/approved" class="mt-1" method="post">
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
                                @endphp 
                                <input type="hidden" name="approved_status" value="
                                    @if ((int)$all_approved != 3)
                                        {{(int)$all_approved}}
                                    @endif
                                ">
                                @if ((int)$all_approved == 0)
                                    <button type="button"  class="btn btn-warning btn-sm border-0 fw-semibold" data-bs-toggle="modal" data-bs-target="#cancel_approve"><i class="ph-x-circle"></i> &nbsp; Batalkan</button> 
                                @elseif((int)$all_approved == 1)
                                    <button type="submit" class="btn btn-success btn-sm border-0 fw-semibold {{$btn_approve == 1 ? 'disabled' : ''}}" ><i class="ph-circle-wavy-check"></i> &nbsp;Approve</button>   
                                @endif
                            </form>
                        </th> --}}
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
                        @foreach($role_dosen->role_group->role_group_penilaian as $rr)
                            @if ($kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $rr->poin_penilaian->id) != NULL)
                                <td>
                                    {{$kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $rr->poin_penilaian->id)->detail_nilai_mahasiswa->sum('nilai')}}
                                    {{-- {{$role_dosen->id}} --}}
                                </td>
                            @else 
                                <td>
                                    <small class="text-secondary"><i>Nilai belum diassign</i></small>
                                </td>
                            @endif
                        @endforeach


                        {{-- @if ($role_dosen->role_group != NULL)
                            @foreach($role_dosen->role_group->role_group_penilaian as $rrr)
                                <td>
                                    @if ($kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $rrr->poin_penilaian->id) != NULL)
                                        @if ($rrr->poin_penilaian->id == $kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id,  $rrr->poin_penilaian->id)->poin_penilaian_id)
                                            @php
                                                ${"total_nilai".$kkm->nim} += (($kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id,  $rrr->poin_penilaian->id)->nilai) * ($rrr->poin_penilaian->bobot / 100));
                                            @endphp
                                            {{
                                                $kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id,  $rrr->poin_penilaian->id)->nilai 
                                                / ($rrr->bobot / 100)
                                            }}
                                        @else 
                                        0 
                                        @endif
                                    @else 
                                        -
                                    @endif
                                </td>
                            @endforeach
                         @endif --}}
                    </tr>
                    @endforeach
                    <td></td>
                </table>
                @endif
            </div>
        </div>




          

        </div>


        <div class="col-xl-4">

        </div>
    </div>

@endsection
