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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
    <script>$.fn.poshytip={defaults:null}</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>
@endpush


@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <style>
        .editableform{
            background: white;
            box-shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;
            padding: 12px;
            /* border: 1px solid rgb(130, 130, 130); */
            border-radius: 3px;
        }

        .editable-buttons button{
            padding: 5px;
            padding-left: 12px;
            padding-right: 12px;
            border: 0;
            border-radius: 5px;
        }

        .editable-submit{
            background-color: rgb(9, 87, 231);
            color: white;
        }

        .editable-cancel{
            background-color: rgb(230, 48, 20);
            color: white;
        }

        .input-mini{
            border: 0;
            padding: 3px;
            max-width: 75px;
        }
        .input-mini:focus{
            outline: none;
            border: none;
            max-width: 75px;
            /* background-color: black; */
        }
    </style>

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
                                @foreach ($penilaian->komponen_penilaian as $pkp)
                                    <th>
                                       <a href="" data-bs-toggle="modal" data-bs-target="#detail_komponen_{{$pkp->id}}">
                                            N{{$loop->iteration}}
                                       </a><br>
                                        <small class="fw-light">{{$pkp->bobot}} %</small>
                                    </th>

                                    <!-- Modal with h5 -->
                                    <div id="detail_komponen_{{$pkp->id}}" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog modal-xs">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Penilaian {{$penilaian->nama_poin}}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <small class="fw-bold">Komponen penilaian : </small>
                                                        <p>{!!$pkp->nama_komponen!!}</p>
                                                        <hr>
                                                        <small class="fw-bold">Bobot : </small>
                                                        <p>{!!$pkp->bobot!!} %</p>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /modal with h5 -->

                                @endforeach
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                @foreach ($penilaian->komponen_penilaian as $item)
                                    <th>N{{$loop->iteration}}</th>
                                @endforeach
                                <th></th>
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
                                @if ($penilaian->komponen_penilaian->count() > 0)
                                @foreach ($penilaian->komponen_penilaian as $pkp)
                                    <td class="add_nilai text-primary" data-name="komponen" data-pkp_id="{{$pkp->id}}" data-mahasiswa={{$kkm->mahasiswa->nim}}  data-type="number" data-max="100" style="cursor:pointer;">
                                       {{-- {{$pkp->nilai_mahasiswa->where('kelompok_id',$kelompok->id  )}} --}}
                                       
                                       @php
                                           $nilai_komponen_mahasiswa = $pkp->detail_nilai_mahasiswa($kkm->mahasiswa->nim, $role_dosen->id, $penilaian->id)
                                                ->where('kelompok_id',$kelompok->id)
                                                ->where('komponen_id', $pkp->id)
                                                ->where('nim', $kkm->mahasiswa->nim)
                                                ->first();
                                       @endphp
                                        
                                       @if ( $nilai_komponen_mahasiswa != NULL)
                                            {{  $nilai_komponen_mahasiswa->nilai / ($pkp->bobot / 100) }}
                                       @endif
                                       {{-- {{  $nilai_komponen_mahasiswa->nilai / ($pkp->bobot / 100)}} --}}

                                    </td>
                                @endforeach
                                @endif
                                {{-- <td>
                                    @if ($kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $penilaian->id) != NULL)
                                        {{$kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $penilaian->id)->nilai}} 
                                    @else 
                                        0
                                    @endif
                                </td> --}}
                                <td>
                                    @if ($kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $penilaian->id) != NULL)
                                        {{$kkm->mahasiswa->nilai_mahasiswa($role_dosen->id, $kelompok->id, $penilaian->id)->nilai}} 
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
                                        <form class="container" action="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/{{$penilaian->id}}/mahasiswa/{{$kkm->mahasiswa->nim}}" method="post">
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
                                                        <input type="number" class="form-control" name="komponen{{$pkp->id}}" max="100" min="0" required>
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


        <script type="text/javascript">
            $.fn.editable.defaults.mode = 'inline';
        
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
        
            $('.add_nilai').editable({
                url : "/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/{{$penilaian->id}}/komponen/store",
                type: 'number',
                pk: function(){
                    return $(this).data('pkp_id');
                },
                mahasiswa:function(){
                    return $(this).data('mahasiswa');
                },
                name: 'komponen',
                title: 'Enter Field',
                // url: function(params) {
                //     // var rkp_id = $(this).data('rkp_id');
                //     return "/kelompok/{{$kelompok->id}}/penilaian/role_kelompok/{{$role_dosen->id}}/{{$penilaian->id}}/komponen/store";
                // },
                params: function(params) {
                    params.mahasiswa = $(this).editable().data('mahasiswa'); // add the new attribute to the AJAX request
                    return params;
                },
                success: function(response, newValue) {
                    console.log("Data submitted successfully!");
                    console.log("Response:", response);
                    console.log("New value:", response.data);
                },
                error: function(xhr, status, error) {
                    console.log("Error submitting data:", error);
                    console.log("Status:", status);
                    console.log("XHR object:", xhr);
                }
            });
        </script>
@endsection
