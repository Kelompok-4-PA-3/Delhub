@extends('main')

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('breadscrumb')
    <a href="/koordinator/myproject" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
    <a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2">{{$krs->kategori->nama_singkat}}</a>
    <span class="breadcrumb-item active py-2">Regulasi</span>
@endsection

@section('content')

        <style>
           .table-regulasi{
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        </style>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Data Kelompok</h5>
                        <div class="ms-auto">
                            @if ($krs->kategori->kategori->count() > 0)
                            <div class="d-flex">
                                <small>Ket : &nbsp;</small>
                                <div class="d-flex">
                                    <button class="btn bg-check-success shadow-sm"></button>
                                    <small>&nbsp;Terpenuhi</small>
                                </div>
                                <div></div>
                            </div>
                            @endif
                         </div>
                    </div>
                    <div class="card-body table-regulasi">
                        <style>
                            .img-success{
                                position: absolute;
                                margin-top: -25px;
                                margin-right: -85px;
                            }
                            .bg-check-success{
                                background-color: #D1E7DD !important;
                            }
                            .pembimbing-name{
                                cursor: pointer;
                            }
                        </style>

                        @php
                            $bimbingan = 0;
                        @endphp
                        @if ($krs->kategori->kategori->poin_regulasi != NULL)
                        <div class="card-body table-responsive">
                            <table class="table datatable-regulasi w-100 scrollable-table table-bordered"  style="min-width: 1200px;">
                                <thead>
                                    <tr>
                                        <th><small> Nama Kelompok </small></th>
                                        <th><small> Jlh Bimbingan </small></th>
                                        @foreach ($krs->kategori_role_get_pembimbing as $rrg)
                                            <th>{{$rrg->nama}}</th>
                                        @endforeach
                                        @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                                            <th>{{$kkkp->nama}}</th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th ></th>
                                        <th ></th>
                                        @foreach ($krs->kategori_role_get_pembimbing as $rrg)
                                            <th class="pembimbing-column">
                                                <select name="" id="" class="form-control">
                                                    @foreach($dosen as $d)
                                                        <div class="list-pembimbing">
                                                        </div>
                                                    @endforeach
                                                </select>
                                            </th>
                                        @endforeach
                                        {{-- <th class="pembimbing-column"></th> --}}
                                        @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                                            <th class="regulasi-column">{{$kkkp->nama}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelompok->sortBy('id') as $k) 
                                        @php
                                            $bimbingan = $k->bimbingan->where('is_done',true)->count();
                                        @endphp
                                        <tr>
                                            <td>
                                                {{$k->nama_kelompok}}
                                            </td>
                                            <td class="text-center">{{$bimbingan}}</td>
                                            @foreach ($krs->kategori_role_get_pembimbing as $rrg)
                                                @if ($k->role_kelompok_all->where('role_group_id',$rrg->id)->count() > 0)   
                                                    <td>{{$k->role_kelompok_all->where('role_group_id',$rrg->id)->first()->dosen->nama_singkat}}</td>
                                                @else
                                                    <td>-</td>
                                                @endif  
                                            @endforeach
                                            @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                                            @if($bimbingan > 0)
                                                @php
                                                    $bimbingan -= $kkkp->poin;
                                                @endphp

                                                @if($bimbingan >= 0 )
                                                    <td class="text-center bg-check-success checked">
                                                        <span class="d-none">Success</span>
                                                        {{$kkkp->poin}} <small class="text-muted"> / {{$kkkp->poin}} </small>
                                                        <img class="img-success" src="{{asset('img/check.gif')}}" style="max-width: 35px;"  alt=""> 
                                                    </td>
                                                @else 
                                                    <td class="text-center">  {{$bimbingan +  $kkkp->poin}} <small class="text-muted"> / {{$kkkp->poin}} </small></td>
                                                @endif
                                            @else
                                                <td class="text-center"> 0 <small class="text-muted"> / {{$kkkp->poin}} </small></td>
                                            @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else 
                            <i class="text-center text-muted">
                                Regulasi untuk proyek ini belum ditentukan
                            </i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection