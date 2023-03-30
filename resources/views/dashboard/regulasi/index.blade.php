@extends('main')

@push('select_js')
    <script src="{{asset('/assets/js/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/form_layouts.js')}}"></script>
@endpush

@section('content')

        <style>
            table{
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        </style>

        <div class="row">

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Regulasi</h5>
                        <div class="ms-auto nav-tabs-responsive">
                            <ul class="nav nav-tabs nav-tabs-underline flex-nowrap">
                                <li class="nav-item">
                                    @if ($regulasi->count() < 0)
                                        <a href="#buat-regulasi" id="btn-buat-regulasi" class="btn btn-sm btn-primary fw-semibold" data-bs-toggle="tab"> + Buat Regulasi</a>
                                    @else
                                        <a href="#ubah-regulasi" id="btn-buat-regulasi" class="btn btn-sm btn-primary fw-semibold" data-bs-toggle="tab"> <i class="ph-pencil"></i> Edit Regulasi</a>
                                    @endif
                                    <a href="#regulasi" id="btn-regulasi" class="btn btn-sm btn-danger fw-semibold active" data-bs-toggle="tab">X Batal</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="regulasi">
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
                                            <td colspan="3" class="text-end"><button type="submit" class="btn btn-sm btn-primary">Kirim</button></td>
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
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="seminar" value="{{$regulasi->seminar}}" min="0">
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
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="proposal" value="{{$regulasi->proposal}}" min="0">
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
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="prasidang" value="{{$regulasi->prasidang}}" min="0">
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
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="sidang" value="{{$regulasi->sidang}}" min="0">
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

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Data Kelompok</h5>
                        <div class="ms-auto">
                            <a href="/krs/{{$krs->id}}/regulasi/show" class="text-primary fw-semibold"> Detail</a>
                         </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><small> Nama Kelompok </small></th>
                                    <th><small> Jlh Bimbingan </small></th>
                                    @if ($regulasi->seminar > 0)
                                        <th><small> Seminar </small></th>
                                    @endif
                                    @if($regulasi->proposal > 0)
                                        <th><small> Proposal </small></th>
                                    @endif
                                    @if($regulasi->prasidang > 0)
                                        <th><small> Prasidang </small></th>
                                    @endif
                                    @if($regulasi->sidang > 0)
                                        <th><small> Sidang </small></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelompok as $k) 
                                    @php
                                     $bimbingan = $k->bimbingan->count();
                                    @endphp
                                    <tr>
                                        <td><small> {{$k->nama_kelompok}} </small></td>
                                        <td><small> {{$k->bimbingan->count()}} </small></td>
                                        @if ($regulasi->seminar > 0)
                                            @php
                                                $bimbingan -= $regulasi->seminar;
                                            @endphp
                                            @if ($bimbingan >= 0)
                                                <td class="text-center"><small> <i class="ph-check text-success"></i> </small></td>
                                            @else
                                                <td class="text-center"><small><i class="ph-minus"></i></small></td>
                                            @endif
                                        @endif
                                        @if($regulasi->proposal > 0)
                                            @php
                                                $bimbingan -= $regulasi->proposal;
                                            @endphp
                                            @if ($bimbingan >= 0)
                                                <td class="text-center"><small> <i class="ph-check text-success"></i> </small></td>
                                            @else
                                                <td class="text-center"><small><i class="ph-minus"></i></small></td>
                                            @endif
                                        @endif
                                        @if($regulasi->prasidang > 0)
                                            @php
                                                $bimbingan -= $regulasi->prasidang;
                                            @endphp
                                            @if ($bimbingan >= 0)
                                                <td class="text-center"><small> <i class="ph-check text-success"></i> </small></td>
                                            @else
                                                <td class="text-center"><small><i class="ph-minus"></i></small></td>
                                            @endif
                                        @endif
                                        @if($regulasi->sidang > 0)
                                            @php
                                                $bimbingan -= $regulasi->sidang;
                                            @endphp
                                            @if ($bimbingan >= 0)
                                                <td class="text-center"><small> <i class="ph-check text-success"></i></small></td>
                                            @else
                                                <td class="text-center"><small><i class="ph-minus"></i></small></td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            $create = document.getElementById('btn-buat-regulasi');
            $index = document.getElementById('btn-regulasi');
            $index.style.display = "none";
            $create.style.display = "block";
            console.log($create);
            $create.onclick = (e) => {
                $index.style.display = 'block';
                e.target.style.display = 'none';
            }
            $index.onclick = (e) => {
                $create.style.display = 'block';
                e.target.style.display = 'none';
            }
        </script>
@endsection