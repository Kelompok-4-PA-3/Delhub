@extends('main')

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('content')

        <style>
           .table-regulasi{
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        </style>

        <div class="row">

            <div class="col-xl-4 d-none">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Regulasi</h5>
                        {{-- <div class="ms-auto nav-tabs-responsive">
                            <ul class="nav nav-tabs nav-tabs-underline flex-nowrap">
                                <li class="nav-item">
                                    @if ($regulasi != NULL)
                                        @if ($regulasi->count() < 0)
                                           
                                        @else
                                            <a href="#ubah-regulasi" id="btn-buat-regulasi" class="btn btn-sm btn-primary fw-semibold" data-bs-toggle="tab"> <i class="ph-pencil"></i> Edit Regulasi</a>
                                        @endif
                                            <a href="#regulasi" id="btn-regulasi" class="btn btn-sm btn-danger fw-semibold active" data-bs-toggle="tab">X Batal</a>
                                    @else 
                                        <a href="#buat-regulasi" id="btn-buat-regulasi" class="btn btn-sm btn-primary fw-semibold" data-bs-toggle="tab"> + Buat Regulasi</a>
                                        <a href="#regulasi" id="btn-regulasi" class="btn btn-sm btn-danger fw-semibold active" data-bs-toggle="tab">X Batal</a>
                                    @endif
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Nama</th>
                                <th>Poin</th>
                            </tr>
                            @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                            <tr>
                                <td>{{$kkkp->nama}}</td>
                                <td>{{$kkkp->poin}}</td>
                            </tr>
                            @endforeach
                        </table>
                        <div>
                            {{-- {{$krs->kategori->kategori->poin_regulasi}} --}}
                           
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="regulasi">
                            @if($regulasi != NULL)
                                @php
                                    $total_bimbingan = $regulasi->seminar + $regulasi->proposal + $regulasi->prasidang + $regulasi->sidang;
                                @endphp
                                @if ($regulasi->count() > 0)
                                    <table class="" cellpadding="5">
                                        <tr>
                                            <td><small class="fw-semibold">Jumlah Bimbingan</small></td>
                                            <td>  </td>
                                            <td> {{$total_bimbingan}} </td>
                                        </tr>
                                        <tr><td></td></tr>
                                        <tr>
                                            <td><small class="text-muted">Rincian</small></td>
                                            <td><small class="text-muted">Minimum</small></td>
                                        </tr>
                                        <tr >
                                            <td><small class="">Seminar</small></td>
                                            <td> {{$regulasi->seminar}} </td>
                                        </tr>
                                        <tr >
                                            <td><small class="">Proposal</small></td>
                                            <td> {{$regulasi->proposal}} </td>
                                        </tr>
                                        <tr>
                                            <td><small class="">Prasidang</small></td>
                                            <td> {{$regulasi->prasidang}} </td>
                                        </tr>
                                        <tr>
                                            <td><small class="">Sidang</small></td>
                                            <td> {{$regulasi->sidang}} </td>
                                        </tr>
                                    </table>
                                @else
                                    <div>
                                        <small><i class="text-muted">Anda belum membuat regulasi!</i></small>
                                    </div>
                                @endif
                            @endif
                            </div>
                            <div class="tab-pane fade show" id="buat-regulasi">
                                <form action="/krs/{{$krs->id}}/regulasi/add" method="post">
                                    <input type="hidden" name="krs_id" value="{{$krs->id}}">
                                    @csrf
                                    <table class="" cellpadding="4">
                                        <tr>
                                            <td><label for="">Seminar</label></td>
                                            <td></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                        <i class="ph-minus ph-sm"></i>
                                                    </button>
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="seminar" value="0" min="0">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                        <i class="ph-plus ph-sm"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="">Proposal</label></td>
                                            <td></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                        <i class="ph-minus ph-sm"></i>
                                                    </button>
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="proposal" value="0" min="0">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                        <i class="ph-plus ph-sm"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="">Prasidang</label></td>
                                            <td></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                        <i class="ph-minus ph-sm"></i>
                                                    </button>
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="prasidang" value="0" min="0">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                        <i class="ph-plus ph-sm"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="">Sidang</label></td>
                                            <td></td>
                                            <td class="text-end">
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                        <i class="ph-minus ph-sm"></i>
                                                    </button>
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="sidang" value="0" min="0">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                        <i class="ph-plus ph-sm"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><button type="submit" class="btn btn-sm btn-primary">Submit</button></td>
                                        </tr>
                                    </table>
                                </form> 
                            </div>

                            <div class="tab-pane fade show" id="ubah-regulasi">
                                <form action="/krs/{{$krs->id}}/regulasi/edit" method="post">
                                    <input type="hidden" name="regulasi" value="{{$krs->id}}">
                                    @csrf
                                    <table class="" cellpadding="4">
                                        <tr>
                                            <td><label for="">Seminar</label></td>
                                            <td></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                        <i class="ph-minus ph-sm"></i>
                                                    </button>
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="seminar" @if($regulasi != NULL) value="{{$regulasi->seminar}} @endif" min="0">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                        <i class="ph-plus ph-sm"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="">Proposal</label></td>
                                            <td></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                        <i class="ph-minus ph-sm"></i>
                                                    </button>
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="proposal" @if($regulasi != NULL) value="{{$regulasi->proposal}} @endif" min="0">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                        <i class="ph-plus ph-sm"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="">Prasidang</label></td>
                                            <td></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                        <i class="ph-minus ph-sm"></i>
                                                    </button>
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="prasidang" @if($regulasi != NULL) value="{{$regulasi->prasidang}} @endif" min="0">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                        <i class="ph-plus ph-sm"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="">Sidang</label></td>
                                            <td></td>
                                            <td class="text-end">
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                        <i class="ph-minus ph-sm"></i>
                                                    </button>
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="sidang" @if($regulasi != NULL)value="{{$regulasi->sidang}} @endif" min="0">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                        <i class="ph-plus ph-sm"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><button type="submit" class="btn btn-sm btn-primary">Edit</button></td>
                                        </tr>
                                    </table>
                                </form> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
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
                                {{-- <a href="/krs/{{$krs->id}}/regulasi/show" class="text-primary fw-semibold"> Detail</a> --}}
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
                        </style>

                        @php
                            $bimbingan = 0;
                        @endphp
                        @if ($krs->kategori->kategori->poin_regulasi != NULL)
                        <table class="table datatable-regulasi" cellpadding="5">
                            <thead>
                                <tr>
                                    <th><small> Nama Kelompok </small></th>
                                    <th><small> Jlh Bimbingan </small></th>
                                    <th><small> Pembimbing 1</small></th>
                                    <th><small> Pembimbing 2 </small></th>
                                    @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                                        <th>{{$kkkp->nama}}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                                        <th>{{$kkkp->nama}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelompok as $k) 
                                    @php
                                     $bimbingan = $k->bimbingan->count();
                                    @endphp
                                    <tr class="mt-5">
                                        <td>
                                            {{$k->nama_kelompok}}
                                        </td>
                                        <td class="text-center">{{$bimbingan}}</td>
                                        <td>{{$k->pembimbings != NULL ? $k->pembimbings->pembimbing_1_dosen->user->nama : '-'}}</td>
                                        <td class="text-center">{{$bimbingan}}</td>
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
                        @else 
                            <i class="text-center text-muted">
                                Regulasi untuk proyek ini belum ditentukan
                            </i>
                        @endif
                    </div>
                </div>
            </div>

            
            
        </div>
        {{-- <div class="mb-2">
            <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}" class="nav-link {{ (request()->is('/kelompok/{id}')) ? 'active' : '' }}"> <i class="ph-squares-four"></i> &nbsp; Kelompok</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Artefak</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Manajemen</a></li>
                <li class="nav-item"><a href="#" class="nav-link {{ (request()->is('/kelompok/orang')) ? 'active' : '' }}"> <i class="ph-folders"></i> &nbsp; Tugas</a></li>
                <li class="nav-item"><a href="/kelompok" class="nav-link  active"> <i class="ph-users"></i> &nbsp; Orang</a></li>
            </ul>
        </div> --}}
        <script>
            // $create = document.getElementById('btn-buat-regulasi');
            // $index = document.getElementById('btn-regulasi');
            // $index.style.display = "none";
            // $create.style.display = "block";
            // console.log($create);
            // $create.onclick = (e) => {
            //     $index.style.display = 'block';
            //     e.target.style.display = 'none';
            // }
            // $index.onclick = (e) => {
            //     $create.style.display = 'block';
            //     e.target.style.display = 'none';
            // }
            // $('.table-regulasi thead tr:eq(1) th').not(':first-child').each(function () {
            //     const title = $(this).text();
            //     $(this).html('<input type="checkbox" class="form-check-input column-check" value="Success"' + title + '" /> <button class="btn bg-check-success shadow-sm"></button>');
            // });

            // var table = $('.table-regulasi').DataTable();
            // table.columns().every( function () {
            //     $('.column-check').on('change', function () {
            //     if ($(this).is(':checked')) {
            //         console.log(this.value);
                    // that.column($(this).parent().index() + ':visible').search(this.value).draw();
                    // var val = [];
            //     }
            // });
            // });

            // $('.column-check').on('change', function () {
            //     if ($(this).is(':checked')) {
            //         console.log(this.value);

            //     }
            // });
        </script>
@endsection