@extends('main')

@section('title')
    <title>Manajemen Mahasiswa</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    {{-- <script src="{{asset('/assets/demo/pages/picker_date.js')}}"></script> --}}
    <script src="{{asset('/assets/js/vendor/ui/fab.min.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/extra_fab.js')}}"></script>
    <script src="{{asset('/assets/js/jquery/jquery.min.js')}}"></script>
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
                {{-- @if (Auth::user()->dosen() != NULL)
                    @if (array_intersect(Auth::user()->dosen->role_kelompok($kelompok->id)->pluck('id')->toArray(), $kelompok->role_kelompok->pluck('id')->toArray())) --}}
                <li class="nav-item">
                    <a href="" class="nav-link btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><i class="ph-notebook"></i> &nbsp; Penilaian</a>
                    <div class="dropdown-menu">
                        {{-- {{}} --}}
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

        <div class="col-xl-7">
            <div class="p-2 card">
                <div class="d-lg-flex">
                    <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                        <li class="nav-item">
                            <a href="#topik-proyek" class="nav-link active" data-bs-toggle="tab">
                                <i class="ph-user-circle me-2"></i>
                                Topik
                            </a>
                        </li>
                        <li class="nav-item">
                            {{-- @can('kelola topik kelompok') --}}
                                @if (app('is_kelompok_leader')->is_kelompok_leader($kelompok->id))
                                    <a href="#edit-topik" class="nav-link" data-bs-toggle="tab">
                                        <i class="ph-pencil me-2"></i>
                                        Edit
                                    </a>
                                @endif
                            {{-- @endcan --}}
                        </li>
                    </ul>

                    <div class="tab-content flex-lg-fill">
                        <div class="tab-pane fade show active" id="topik-proyek">
                            <div class="px-2">
                                <small class="text-muted ">Topik : </small>
                            </div>
                            @if ($kelompok->topik == NULL)
                                <small class="p-2">Kelompok ini belum memiliki topik</small>
                            @else
                            <h5 class="fw-semibold p-2">{{$kelompok->topik}}</h5>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="edit-topik">
                           <form action="/kelompok/topik" method="post">
                            @csrf
                            <input type="hidden" value="{{$kelompok->id}}" name="kelompok">
                            <input type="text" class="form-control" name="topik" value="{{old('topik',$kelompok->topik)}}" placeholder="Masukkan topik disini" required>
                            <div class="p-1">
                                <button class="btn btn-sm btn-primary w-100">Submit</button>
                            </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-2 card">
                <div class="d-lg-flex">
                    <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                        <li class="nav-item">
                            <a href="#pembimbing_penguji" class="nav-link active" data-bs-toggle="tab">
                                <i class="ph-user-circle me-2"></i>
                            </a>
                        </li>  
                        <li class="nav-item">
                            <a href="#edit_pembimbing_penguji" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-pencil me-2"></i>
                            </a>
                        </li>  
                    </ul>
                    <div class="tab-content flex-lg-fill">
                        <div class="tab-pane fade show active" id="pembimbing_penguji">
                            @php
                                if($kelompok->role_kelompok->where('is_verified',false)->count() > 0){
                                    $verified = false;
                                }else{
                                    $verified = true;
                                }
                            @endphp
                            <div class="d-flex mb-1">
                                <div class="d-flex">
                                    <small class="mt-1">Total : </small>&nbsp;
                                    <h5 class="{{$kelompok->role_kelompok->sum('bobot') == 100 ? 'text-primary' : 'text-warning'}}"> {{$kelompok->role_kelompok->sum('bobot')}} %</h5> 
                                </div>
                                @if($verified)
                                    <div class="d-flex ms-auto">    
                                        <span class="rounded-pill bg-opacity-10 text-success"><i class="ph-circle-wavy-check"></i>&nbsp; sudah diverifikasi</span>
                                    </div>
                                @else 
                                    <div class="d-flex ms-auto">    
                                        <span class="rounded-pill bg-opacity-10 text-danger"><i class="ph-circle-wavy-warning"></i>&nbsp; belum diverifikasi</span>
                                    </div>
                                @endif
                            </div>
                            @foreach($kelompok->role_kelompok as $kr)
                                <div>
                                    <div class="d-flex px-2 mt-2">
                                        <small class="text-muted">{{$kr->role_group->nama}} </small>
                                        @if(!$verified)
                                            <div class="ms-auto ">
                                                <small class="" data bs-popup="tooltip" title="hapus"> <a href="#" class="text-muted"data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $kr->id }}"><i class="ph-trash"></i></a></small>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="px-2">
                                        <h5>
                                            {{$kr->dosen->user->nama}}
                                        </h5>
                                    </div>
                                </div>

                                  <!-- Delete Modal -->
                                  <div id="modal_hapus{{ $kr->id }}" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog modal-xs">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus data pembimbing saat ini ?
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{Route('kelompok_role.delete', ['kelompok' => $kelompok->id, 'roleKelompok' => $kr->id])}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Ya</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Delete Modal -->
                            @endforeach
                            @if(!$verified)
                            <div>
                                <form action="/kelompok/{{$kelompok->id}}/verfikasi/role" method="post">
                                    @csrf
                                    <i class="text-warning">{{$kelompok->role_kelompok->sum('bobot') != 100 ? 'Tidak dapat melakukan verifikasi karena jumlah bobot belum mencapai 100%'  : ''}}</i>
                                    <div class="d-flex">
                                        <button class="btn btn-primary btn-sm fw-semibold ms-auto {{$kelompok->role_kelompok->sum('bobot') == 100 ? '' : 'disabled'}}"><i class="ph-circle-wavy-warning"></i>&nbsp; Verifikasi&nbsp;&nbsp;&nbsp; <span class="bg-warning px-1 fw-semibold">{{$kelompok->role_kelompok->count()}}</span></button>
                                    </div>
                                </form>
                            </div>
                            @else 
                                <form action="/kelompok/{{$kelompok->id}}/verfikasi/role" method="post">
                                    @csrf
                                    <i class="text-warning">{{$kelompok->role_kelompok->sum('bobot') != 100 ? 'Tidak dapat melakukan verifikasi karena jumlah bobot belum mencapai 100%'  : ''}}</i>
                                    <div class="d-flex">
                                        <input type="hidden" name="status" value="not_verified">
                                        <button class="btn btn-warning btn-sm fw-semibold ms-auto {{$kelompok->role_kelompok->sum('bobot') == 100 ? '' : 'disabled'}}">Batalkan verifikasi</span></button>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="tab-pane fade show" id="edit_pembimbing_penguji">
                            <form action="{{Route('kelompok_role.add',[ 'kelompok' => $kelompok->id])}}" method="post">
                                @csrf
                                <div class="py-1">
                                    <select data-placeholder="Pilih dosen" name="nidn" class="form-control select" required>
                                        <option></option>
                                        <optgroup label="Daftar Dosen">
                                            @foreach($dosen as $d)
                                                <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                                {{-- @if($role_dosen_edit != NULL)
                                                    <option value="{{$d->nidn}}" {{$role_dosen_edit->dosen->nidn == $d->nidn ? 'selected' : ''}} >{{Str::limit($d->user->nama,30)}}</option>
                                                @else
                                                    <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                                @endif --}}
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div> 
                                <div class="py-1">
                                    <select name="role_group_id" class="form-control" required>
                                        <option></option>
                                        <optgroup label="Daftar role">
                                            <option selected>Pilih role</option>
                                            @foreach($kelompok->krs->krs_role as $kkk)
                                                @if (!in_array($kkk->id, $kelompok->role_kelompok->pluck('role_group_id')->toArray()))
                                                    <option value="{{$kkk->id}}">{{Str::limit($kkk->nama,30)}}</option> 
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div> 
                                <div class="p-1">
                                    <button class="btn btn-sm btn-primary w-100">Submit</button>
                                </div>
                               </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-2 card">
                <div class="d-lg-flex">
                    <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                        @foreach ($kelompok->krs->krs_role as $kkk)
                        {{-- @php
                            $role_dosen = $kkk->role_kelompok->where('kelompok_id',$kelompok->id)->first()
                        @endphp --}}
                        <li class="nav-item">
                            <a href="#{{$kkk->nama}}" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-user-circle me-2"></i>
                               {{$kkk->nama}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#edit-pembimbing{{$kkk->id}}" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-pencil me-2"></i>
                                Edit
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="tab-content flex-lg-fill">
                        {{-- @foreach ($kelompok->role_kelompok as $kr)
                        <div class="tab-pane fade show  {{$loop->first ? 'active' : ''}}" id="pembimbing{{$kr->role_group->id}}">
                            @if ($kr->role_kelompok->where('kelompok_id',$kelompok->id)->count() != NULL)
                            <div class="d-flex px-1 ">
                                <div class="ms-auto ">
                                    <small class="" data bs-popup="tooltip" title="hapus"> <a href="#" class="text-muted"data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $kr->role_kelompok->id }}"><i class="ph-trash"></i></a></small>
                                </div>
                            </div>
                                <div>
                                    <div class="d-flex px-2 mt-2">
                                        <small class="text-muted">{{$kr->nama}} </small>
                                    </div>
                                    <div class="px-2">
                                        <h5>
                                            {{$kr->role_kelompok->dosen->user->nama}}
                                        </h5>
                                    </div>
                                </div>
                            @else 
                                <i>Kelompok ini belum memilki {{$kr->nama}}</i>
                            @endif
                        </div>
                        @endforeach --}}
                        @foreach ($kelompok->krs->krs_role as $kkk)
                        <div class="tab-pane fade show " id="{{$kkk->nama}}">
                            {{-- {{$kkk->role_kelompok->where('kelompok_id',$kelompok->id)->get()}} --}}
                            {{-- @php
                                $role_dosen = $kkk->role_kelompok->where('kelompok_id',$kelompok->id)->first()
                            @endphp --}}
                            @if ($role_dosen != NULL)
                            <div class="d-flex px-1 ">
                                <div class="ms-auto ">
                                    {{-- <small class="" data bs-popup="tooltip" title="hapus"> <a href="#" class="text-muted"data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $kkk->role_kelompok->id }}"><i class="ph-trash"></i></a></small> --}}
                                </div>
                            </div>
                            <div>
                                <div class="d-flex px-2 mt-2">
                                    {{-- <small class="text-muted">{{$role_dosen->role_group->nama}} </small> --}}
                                </div>
                                <div class="px-2">
                                    <h5>
                                        {{-- {{$role_dosen->dosen->user->nama}} --}}
                                    </h5>
                                </div>
                            </div>
                            @else 
                                <i>Kelompok ini belum memilki {{$kkk->nama}}</i>
                            @endif
                        </div>
                        @endforeach
                        @foreach ($kelompok->krs->krs_role as $kkk)
                        <div class="tab-pane fade" id="edit-pembimbing{{$kkk->id}}">
                            {{-- @php
                                $role_dosen_edit = $kkk->role_kelompok->where('kelompok_id',$kelompok->id)->first()
                            @endphp --}}
                            <form action="{{Route('kelompok_role.add',[ 'kelompok' => $kelompok->id, 'roleGroupKelompok' => $kkk->id])}}" method="post">
                             @csrf
                             <div class="py-1">
                                 <select data-placeholder="{{$kkk->nama}}" name="nidn" class="form-control select" required>
                                     <option></option>
                                     <optgroup label="Daftar Dosen">
                                         {{-- @foreach($dosen as $d)
                                         <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                             @if($role_dosen_edit != NULL)
                                                 <option value="{{$d->nidn}}" {{$role_dosen_edit->dosen->nidn == $d->nidn ? 'selected' : ''}} >{{Str::limit($d->user->nama,30)}}</option>
                                             @else
                                                 <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                             @endif
                                         @endforeach --}}
                                     </optgroup>
                                 </select>
                             </div> 
                             <div class="p-1">
                                 <button class="btn btn-sm btn-primary w-100">Submit</button>
                             </div>
                            </form>
                         </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="p-2 card d-none">
                <div class="d-lg-flex">
                    <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                        <li class="nav-item">
                            <a href="#pembimbing" class="nav-link {{session()->has('penguji') ? '' : 'active' }}" data-bs-toggle="tab">
                                <i class="ph-user-circle me-2"></i>
                                Pembimbing
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#edit-pembimbing" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-pencil me-2"></i>
                                Edit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#penguji" class="nav-link {{session()->has('penguji') ?  'active' : '' }}" data-bs-toggle="tab">
                                <i class="ph-user-circle me-2"></i>
                                Penguji
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#edit-penguji" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-pencil me-2"></i>
                                Edit
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content flex-lg-fill">
                        <div class="tab-pane fade show  {{session()->has('penguji') ?  '' : 'active' }}" id="pembimbing">
                            @if ($kelompok->pembimbings != NULL)
                                <div class="d-flex px-1 ">
                                    <div class="ms-auto ">
                                        <small class="" data bs-popup="tooltip" title="hapus"> <a class="text-muted"data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $kelompok->pembimbings->id }}"><i class="ph-trash"></i></a></small>
                                    </div>
                                </div>
                                <h4>
                                </h4>
                                @if ($kelompok->pembimbings->pembimbing_1 != NULL)
                                    <div>
                                        <div class="d-flex px-2 mt-2">
                                            <small class="text-muted">Pembimbing 1 : </small>
                                        </div>
                                        <div class="px-2">
                                            <h5>
                                                {{$kelompok->pembimbings->pembimbing_1_dosen->user->nama}}
                                                {{--$kelompok->pembimbings->pembimbing_1_dosen->user->getRoleNames()--}}
                                            </h5>
                                        </div>
                                    </div>
                                @endif

                                @if ($kelompok->pembimbings->pembimbing_2 != NULL)
                                    <div>
                                        <div class="d-flex p-2 mt-2">
                                            <small class="text-muted">Pembimbing 2 : </small>
                                        </div>
                                        <div class="px-2">
                                            <h5>
                                                {{$kelompok->pembimbings->pembimbing_2_dosen->user->nama}}
                                            </h5>
                                        </div>
                                    </div>
                                @endif

                                    <!-- Delete Modal -->
                                    <div id="modal_hapus{{ $kelompok->pembimbings->id }}" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog modal-xs">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus data pembimbing saat ini ?
                                                </div>

                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="/kelompok/dosen/pembimbing/{{$kelompok->pembimbings->id}}/delete" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">Ya</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Delete Modal -->

                                {{-- @endforeach --}}
                           @else
                                <i><small>Belum ada pembimbing di kelompok ini</small></i>
                           @endif
                        </div>

                        <div class="tab-pane fade show {{session()->has('penguji') ?  'active' : '' }}" id="penguji">

                            @if ($kelompok->pengujis != NULL)
                                <div class="d-flex px-1 ">
                                    <div class="ms-auto ">
                                        <small class="" data bs-popup="tooltip" title="hapus"> <a class="text-muted"data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $kelompok->pengujis->id }}"><i class="ph-trash"></i></a></small>
                                    </div>
                                </div>
                                @if ($kelompok->pengujis->penguji_1 != NULL)
                                    <div>
                                        <div class="d-flex px-2 mt-2">
                                            <small class="text-muted">Penguji 1 : </small>
                                        </div>
                                        <div class="px-2">
                                            <h5>
                                                {{$kelompok->pengujis->penguji_1_dosen->user->nama}}
                                            </h5>
                                        </div>
                                    </div>
                                @endif

                                @if ($kelompok->pengujis->penguji_2 != NULL)
                                    <div>
                                        <div class="d-flex p-2 mt-2">
                                            <small class="text-muted">Pembimbing 2 : </small>
                                        </div>
                                        <div class="px-2">
                                            <h5>
                                                {{$kelompok->pengujis->penguji_2_dosen->user->nama}}
                                            </h5>
                                        </div>
                                    </div>
                                @endif

                                    <!-- Delete Modal -->
                                    <div id="modal_hapus{{ $kelompok->pengujis->id }}" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog modal-xs">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus data pembimbing saat ini ?
                                                </div>

                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="/kelompok/dosen/penguji/{{$kelompok->pengujis->id}}/delete" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">Ya</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Delete Modal -->

                                {{-- @endforeach --}}
                           @else
                                <i><small>Belum ada penguji di kelompok ini</small></i>
                           @endif
                        </div>

                        {{-- @can('kelola pembimbing penguji') --}}
                        <div class="tab-pane fade" id="edit-pembimbing">
                           <form action="/kelompok/dosen/pembimbing" method="post">
                            @csrf
                            <input class="d-none" type="text" name="kelompok_id" value="{{$kelompok->id}}">

                            <div class="py-1">
                                <select data-placeholder="Pembimbing 1" name="pembimbing_1" class="form-control select" required>
                                    <option></option>
                                    <optgroup label="Daftar Dosen">
                                        @foreach($dosen as $d)
                                            @if($kelompok->pembimbings != NULL)
                                                <option value="{{$d->nidn}}" @if ($kelompok->pembimbings->pembimbing_1 != NULL) {{$kelompok->pembimbings->pembimbing_1 == $d->nidn ? 'selected' : ''}} @endif>{{Str::limit($d->user->nama,30)}}</option>
                                            @else
                                                <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            <div class="py-1">
                                <select data-placeholder="Pembimbing 2" name="pembimbing_2" class="form-control select">
                                    <option></option>
                                    <optgroup label="Daftar Dosen">
                                        @foreach($dosen as $d)
                                            @if($kelompok->pembimbings != NULL)
                                                <option value="{{$d->nidn}}" @if ($kelompok->pembimbings->pembimbing_2 != NULL) {{$kelompok->pembimbings->pembimbing_2 == $d->nidn ? 'selected' : ''}} @endif>{{Str::limit($d->user->nama,30)}}</option>
                                            @else
                                                <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>

                            <div class="p-1">
                                <button class="btn btn-sm btn-primary w-100">Submit</button>
                            </div>
                           </form>
                        </div>
                        {{-- @endcan --}}

                        {{-- @can('kelola pembimbing penguji') --}}
                        <div class="tab-pane fade" id="edit-penguji">
                            <form action="/kelompok/dosen/penguji" method="post">
                                @csrf
                                <input class="d-none" type="text" name="kelompok_id" value="{{$kelompok->id}}">

                                <div class="py-1">
                                    <select data-placeholder="Penguji 1" name="penguji_1" class="form-control select" required>
                                        <option></option>
                                        <optgroup label="Daftar Dosen">
                                            @foreach($dosen as $d)
                                                @if($kelompok->pengujis != NULL)
                                                    <option value="{{$d->nidn}}" @if ($kelompok->pengujis->penguji_1 != NULL) {{$kelompok->pengujis->penguji_1 == $d->nidn ? 'selected' : ''}} @endif>{{Str::limit($d->user->nama,30)}}</option>
                                                @else
                                                    <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="py-1">
                                    <select data-placeholder="Penguji 2" name="penguji_2" class="form-control select">
                                        <option></option>
                                        <optgroup label="Daftar Dosen">
                                            @foreach($dosen as $d)
                                                @if($kelompok->pengujis != NULL)
                                                    <option value="{{$d->nidn}}" @if ($kelompok->pengujis->penguji_2 != NULL) {{$kelompok->pengujis->penguji_2 == $d->nidn ? 'selected' : ''}} @endif>{{Str::limit($d->user->nama,30)}}</option>
                                                @else
                                                    <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="p-1">
                                    <button class="btn btn-sm btn-primary w-100">Submit</button>
                                </div>
                               </form>
                        </div>
                        {{-- @endcan --}}

                    </div>
                </div>
            </div>

        </div>


        <div class="col-xl-5">

            <!-- Sales stats -->
            <div class="card">
                <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                    <h5 class="py-sm-2 my-sm-1">Bimbingan </h5><br>
                    <div class="mt-2 mt-sm-0 ms-sm-auto">
                        <div class="d-flex mt-3">
                            <small class="text-muted">Total : </small>
                            <h1>{{$kelompok->bimbingan->where('is_done',true)->count()}}</h1> / <h6 class="text-muted">
                                @if ($regulasi == NULL)
                                    {{$kelompok->krs->kategori->kategori->poin_regulasi->sum('poin')}}
                                @else
                                    {{$regulasi}}
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>

                <div class="card-body pb-0">

                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-tabs-underline nav-justified">
                        <li class="nav-item">
                            <a href="#list-bimbingan" class="nav-link active" data-bs-toggle="tab">
                                Daftar
                            </a>
                        </li>
                         <li class="nav-item">
                             <a href="#tambah-bimbingan" class="nav-link" data-bs-toggle="tab">
                                 Request
                             </a>
                         </li>
                    </ul>
                    <!-- /tabs -->

                    <!-- Tabs content -->
                    <div class="tab-content card-body">
                        <div class="tab-pane active fade show" id="list-bimbingan">
                            <div class="">
                                <table class="table text-nowrap">
                                    <tbody>
                                        @if($kelompok->bimbingan->count() > 0)
                                        @foreach($kelompok->bimbingan as $kb)
                                        <tr>
                                            <td class="text-center">
                                                <h6 class="mb-0">{{Carbon\Carbon::parse($kb->waktu)->format('d')}}</h6>
                                                <div class="fs-sm text-muted lh-1 text-uppercase">{{Carbon\Carbon::parse($kb->waktu)->format('M')}}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <small><a href="#" class="text-body fw-semibold letter-icon-title">{{Str::limit($kb->description,20)}}</a></small>
                                                        <div class="d-flex align-items-center text-muted fs-sm">
                                                            <span class="
                                                            @if($kb->reference->value == 'waiting')
                                                                bg-info
                                                            @elseif($kb->reference->value == 'approved')
                                                                bg-success
                                                            @elseif($kb->reference->value == 'rejected')
                                                                bg-danger
                                                            @elseif($kb->reference->value == 'reschedule')
                                                                bg-warning
                                                            @endif
                                                             rounded-pill p-1 me-2"></span>
                                                            {{ $kb->is_done ? 'Done' : $kb->reference->value }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if (!$kb->is_done)
                                                    <div class="dropdown">
                                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                                            <i class="ph-list"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">

                                                            {{-- @can('update status bimbingan') --}}
                                                                {{-- @if (app('is_pembimbing')->is_pembimbing($kelompok->id)) --}}
                                                                {{-- @can('pembimbing-kelompok',$kelompok) --}}
                                                                    @if ($kb->reference->value == 'waiting')
                                                                        @foreach($status_bimbingan as $sb)
                                                                        <a href="/bimbingan/status/{{$sb->id}}/{{$kb->id}}" class="dropdown-item">
                                                                            @if($sb->value == 'approved')
                                                                                <i class="ph-checks text-success me-2"></i>
                                                                            @elseif($sb->value == 'rejected')
                                                                                <i class="ph-x text-danger me-2"></i>
                                                                            @elseif($sb->value == 'reschedule')
                                                                                <i class="ph-calendar-x text-info me-2"></i>
                                                                            @endif
                                                                            {{$sb->value}}
                                                                        </a>
                                                                        @endforeach
                                                                    @endif
                                                                {{-- @endcan --}}
                                                                

                                                                    @if($kb->reference->value == 'approved' && !$kb->is_done)
                                                                        <a href="#" class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#upload_bukti{{$kb->id}}">
                                                                            <i class="ph-microsoft-excel-logo me-2"></i>
                                                                            {{$kb->file_bukti == NULL ? 'upload MOM' : 'Lihat MOM'}}
                                                                        </a>
                                                                    @endif
                                                                {{-- @endif --}}
                                                            {{-- @endcan --}}

                                                            @if($kb->reference->value == 'waiting')
                                                                <a href="#" class="text-danger dropdown-item" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{$kb->id}}">
                                                                    <i class="ph-trash me-2"></i> Batal
                                                                </a>
                                                            @endif
                                                            {{-- @endif --}}

                                                        </div>
                                                    </div>
                                                @else
                                                    <div>
                                                       <i class="ph-circle-wavy-check text-success"></i>
                                                    </div>
                                                @endif


                                            </td>
                                        </tr>

                                       <!-- Sticky footer -->
                                        <div id="upload_bukti{{$kb->id}}" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
                                            <div class="offcanvas-header border-bottom">
                                                <h5 class="offcanvas-title fw-semibold">File Bukti</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                            </div>
                                            <div class="offcanvas-body">

                                                @if ($kb->file_bukti == NULL)
                                                    <div class="py-1">
                                                        <div class="mb-1">
                                                            <small class="text-danger"><i>Silahkan upload file MOM dan file - file pendukung sebagai bukti bahwa anda telah melakukan bimbingan</i></small>
                                                        </div>
                                                    </div>

                                                    <form action="/bimbingan/upload/{{$kb->id}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <p class="fw-semibold">Seret file pada area</p>
                                                                <input type="file" class="form-control" name="file-bukti" required>
                                                                {{-- <input id="file1" name="file1" type="file"> --}}
                                                            </div>
                                                        </div>

                                                        <div class="border-top p-3">
                                                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                                                        </div>
                                                    </form>
                                                @else

                                                <div class="py-1">
                                                    <div class="mb-1">
                                                        <small class=""><i>Silahkan konfirmasi jika bimbingan telah selesai dan dokumen pendukung sudah benar</i></small>
                                                    </div>
                                                </div>

                                                    <a href="{{asset('/storage/bukti-bimbingan/'.$kb->file_bukti)}}" download class="navbar-nav-link navbar-nav-link-icon text-primary bg-primary bg-opacity-10 fw-semibold rounded p-2" target="_blank">
                                                        <div class="d-flex align-items-center mx-md-1">
                                                            <i class="ph-file"></i>
                                                            <span class="d-none d-md-inline-block ms-2">{{$kb->file_bukti}}</span>
                                                        </div>
                                                    </a>

                                                    <form action="/bimbingan/approve/{{$kb->id}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="border-top p-3">
                                                            <button type="submit" class="btn btn-success w-100">Approve</button>
                                                        </div>
                                                    </form>
                                                @endif

                                            </div>
                                        </div>
                                        <!-- /sticky footer -->

                                         <!-- Delete Modal -->
                                        <div id="modal_hapus{{$kb->id}}" class="modal fade" tabindex="-1">
                                            <div class="modal-dialog modal-xs">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        Apakah anda yakin ingin menghapus    data bimbingan ini ?
                                                    </div>

                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        <form action="/request/{{$kb->id}}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-primary">Ya</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete Modal -->
                                        @endforeach
                                        @else
                                            <p class="text-muted text-center">Belum ada bimbingan tersedia</p>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- @can('request bimbingan') --}}
                        <div class="tab-pane active fade" id="tambah-bimbingan">
                            <form action="/bimbingan" method="post">
                                @csrf
                                <input type="text" name="kelompok_id" value="{{$kelompok->id}}" class="d-none">
                                <div class="p-1">
                                    <label for="">Deskripsi</label>
                                    <textarea class="form-control" name="description" type="text" placeholder="Deskripsi bimbingan" required>{{old('deskripsi')}}</textarea>
                                </div>
                                <div class="p-1">
                                    <label for="">Waktu</label>
                                    <input class="form-control" value="{{old('deskripsi')}}" name="waktu" type="datetime-local" placeholder="waktu bimbingan" required>
                                </div>
                                <div class="p-1">
                                    <label for="">Ruangan</label>
                                    <select class="form-control" name="ruangan_id" placeholder="waktu bimbingan" required>
                                        @foreach($ruangan as $r)
                                            <option value="{{$r->id}}">{{$r->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <button type="sumbit" class="btn btn-primary btn-sm w-100">Submit</button>
                                </div>
                            </form>
                        </div>
                        {{-- @endcan --}}
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
