@extends('main')

@section('title')
<title>{{$kelompok->nama_kelompok}}</title>
@endsection

@push('datatable_js')
<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
<script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
<script src="{{asset('/assets/js/vendor/ui/fab.min.js')}}"></script>
<script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script>
<script src="{{asset('/assets/demo/pages/extra_fab.js')}}"></script>
<script src="{{asset('/assets/js/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

@endpush


@section('breadscrumb')
@role('dosen')
@if (Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk || Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk_2)
<a href="/koordinator/myproject" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
<a href="/koordinator/proyeksaya/{{$kelompok->krs->id}}" class="breadcrumb-item py-2">
    {{$kelompok->krs->kategori->nama_singkat}}</a>
@endif
@endrole
@role('admin')
@if (Auth::user()->dosen == NULL)
<a href="/koordinator/proyeksaya/{{$kelompok->krs->id}}" class="breadcrumb-item py-2">
    {{$kelompok->krs->kategori->nama_singkat}}</a>
@endif
@endrole
@role('mahasiswa')
<a href="/home" class="breadcrumb-item py-2"> Home</a>
@endrole
<span class="breadcrumb-item active py-2">{{$kelompok->nama_kelompok}}</span>
@endsection

@section('content')
{{-- @dd($kelompok) --}}
<div class="row">

    <div class="mb-2">
        <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
            <li class="nav-item"><a href="#" class="nav-link active"> <i class="ph-squares-four"></i> &nbsp;
                    Kelompok</a></li>
            <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}/artefak" class="nav-link"> <i class="ph-folders"></i> &nbsp; Artefak</a></li>
            <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}/orang" class="nav-link"> <i class="ph-users"></i>
                    &nbsp; Orang</a></li>
            @role('dosen')
            <li class="nav-item">
                <a href="" class="nav-link btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="ph-notebook"></i> &nbsp; Penilaian</a>
                <div class="dropdown-menu">
                    @foreach (Auth::user()->dosen->role_kelompok->where('kelompok_id',$kelompok->id) as $myrole)
                    @if ($myrole->role_group != NULL)
                    <div class="list-group">
                        <div class="d-flex">
                            <a @if($myrole->is_verified)
                                href="/kelompok/{{$kelompok->id}}/penilaian/role/{{$myrole->id}}" @endif
                                class="dropdown-item"><i class="ph-notebook"></i> &nbsp;{{$myrole->role_group->nama}}
                                &nbsp; @if(!$myrole->is_verified) <i class="ph-warning-circle text-warning"
                                    style="cursor:pointer;" data-bs-popup="tooltip"
                                    title="Role anda belum diverfikasi"></i> @endif</a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </li>
            @endrole
            {{-- @role('dosen')
            @if ($kelompok->krs->dosen_mk == Auth::user()->dosen->nim || $kelompok->krs->dosen_mk_2 ==
            Auth::user()->dosen->nim)
            <li class="nav-item">
                <a href="/kelompok/{{$kelompok->id}}/penilaian/koordinator" class="nav-link btn btn-primary"><i
                        class="ph-notebook"></i> &nbsp; Hasil Penilaian</a>
            </li>
            @endif
            @endrole --}}
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
                        @role('mahasiswa')
                        @if (Gate::check('mahasiswa_allowed', $kelompok))
                        <a href="#edit-topik" class="nav-link" data-bs-toggle="tab">
                            <i class="ph-pencil me-2"></i>
                            Edit
                        </a>
                        @endif
                        @endrole
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
                            <input type="text" class="form-control" name="topik"
                                value="{{old('topik',$kelompok->topik)}}" placeholder="Masukkan topik disini" required>
                            <div class="p-1">
                                <button class="btn btn-sm btn-primary w-100">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                <h5 class="py-sm-2 my-sm-1">Mahasiswa</h5>
            </div>
            <div class="card-body">
                @foreach ($kelompok->kelompok_mahasiswas as $km)
                <p><span class="fw-semibold">{{$km->mahasiswa->nim}}</span> - {{$km->mahasiswa->user->nama}}</p>
                @endforeach
            </div>
        </div>

        <div class="p-2 card">
            @php
            if($kelompok->role_kelompok->where('is_verified',false)->count() > 0 || $kelompok->role_kelompok->count() <=
                0){ $verified=false; }else{ $verified=true; } @endphp <div class="d-lg-flex">
                <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                    <li class="nav-item">
                        <a href="#pembimbing_penguji" class="nav-link active" data-bs-toggle="tab">
                            <i class="ph-user-circle me-2"></i>
                        </a>
                    </li>
                    @if (!$verified)
                    <li class="nav-item">
                        <a href="#edit_pembimbing_penguji" class="nav-link" data-bs-toggle="tab">
                            <i class="ph-pencil me-2"></i>
                        </a>
                    </li>
                    @endif

                </ul>
                <div class="tab-content flex-lg-fill">
                    <div class="tab-pane fade show" id="edit_pembimbing_penguji">
                        <form action="{{Route('kelompok_role.add',[ 'kelompok' => $kelompok->id])}}" method="post">
                            @csrf
                            <div class="py-1">
                                <select data-placeholder="Pilih dosen" name="nidn" class="form-control select" required>
                                    <option></option>
                                    <optgroup label="Daftar Dosen">
                                        @foreach($dosen as $d)
                                        <option value="{{$d->nidn}}">{{Str::limit($d->user->nama,30)}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="py-1">
                                <select name="role_group_id" class="form-control" required>
                                    <optgroup label="Daftar role">
                                        <option value="" selected>Pilih role </option>
                                        @foreach($kelompok->krs->kategori_role_get_role as $kkk)
                                        @if (!in_array($kkk->id,
                                        $kelompok->role_kelompok->pluck('role_group_id')->toArray()))
                                        <option value="{{$kkk->id}}">{{Str::limit($kkk->nama,30)}} <span
                                                class="text-primary">{{$kkk->is_main ? ' - wajib' : ''}}</span></option>
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

                    <div class="tab-pane fade show active" id="pembimbing_penguji">
                        @role('dosen')
                        {{-- @if (Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk || Auth::user()->dosen->nidn ==
                        $kelompok->krs->dosen_mk_2) --}}
                        {{-- @if (Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk || Auth::user()->dosen->nidn ==
                        $kelompok->krs->dosen_mk_2) --}}
                        @if ($kelompok->role_kelompok->count() > 0)
                        @if(!$verified)
                        <div>
                            <div class="d-flex">
                                <span class="text-primary text-warning p-1 px-3 rounded-pill fw-semibold"><i
                                        class="ph-warning-circle"></i> not verified</span>
                                @if (Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk || Auth::user()->dosen->nidn
                                == $kelompok->krs->dosen_mk_2)
                                <div class="ms-auto">
                                    <form action="/kelompok/{{$kelompok->id}}/verfikasi/role" method="post">
                                        @csrf
                                        <button class="btn btn-primary btn-sm fw-semibold ms-auto"><i
                                                class="ph-circle-wavy-warning"></i>&nbsp; Verifikasi&nbsp;&nbsp;&nbsp;
                                            <span
                                                class="bg-warning px-1 fw-semibold">{{$kelompok->role_kelompok->count()}}</span></button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="d-flex">
                            @if (Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk || Auth::user()->dosen->nidn ==
                            $kelompok->krs->dosen_mk_2)
                            <span class="text-primary text-success p-1 px-3 rounded-pill fw-semibold mt-1"><i
                                    class="ph-checks"></i> verified</span>
                            <div class="ms-auto">
                                <form action="/kelompok/{{$kelompok->id}}/verfikasi/role" method="post">
                                    @csrf
                                    <div class="d-flex">
                                        <input type="hidden" name="status" value="not_verified">
                                        <button class="btn btn-warning btn-sm fw-semibold ms-auto">Batalkan
                                            verifikasi</span></button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                        @endif
                        {{-- @endif --}}
                        {{-- @endif --}}
                        @endif
                        @endrole
                        @if ($kelompok->role_kelompok->count() > 0)
                        @foreach($kelompok->role_kelompok as $kr)
                        <div>
                            <div class="d-flex px-2 mt-2">
                                <small class="text-muted">{{$kr->role_group != NULL ? $kr->role_group->nama : ''}}
                                </small>
                                @if(!$verified && strtolower($kr->role_group->nama) != 'koordinator')
                                <div class="ms-auto ">
                                    <small class="" data bs-popup="tooltip" title="hapus">
                                        <a href="#" class="text-muted" data-bs-toggle="modal"
                                            data-bs-target="#modal_hapus{{ $kr->id }}"><i class="ph-trash"></i></a>
                                    </small>
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
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form
                                            action="{{Route('kelompok_role.delete', ['kelompok' => $kelompok->id, 'roleKelompok' => $kr->id])}}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Ya</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Delete Modal -->
                        @endforeach
                        @else
                        <h6 class="fw-light text-secondary text-center p-2">Belum terdapat role dosen</h6>
                        @endif

                    </div>

                </div>
        </div>
    </div>



    <div class="p-2 card d-none">
        <div class="d-lg-flex">



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
                    <h4>{{$kelompok->bimbingan->where('is_done',true)->count()}}</h4> / <h6 class="text-muted">
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
                @role('mahasiswa')
                <li class="nav-item">
                    <a href="#tambah-bimbingan" class="nav-link" data-bs-toggle="tab">
                        Request
                    </a>
                </li>
                @endrole
            </ul>
            <!-- /tabs -->

            <!-- Tabs content -->
            <div class="tab-content card-body">
                <div class="tab-pane active fade show" id="list-bimbingan">
                    <div class="">
                        <div class="d-flex mb-1">
                            <div class="">
                                <a href="" class="btn btn-sm btn-primary fw-light" data-bs-toggle="modal"
                                    data-bs-target="#modal_detail_rekap_bimbingan">&nbsp;
                                    Hasil bimbingan</a>
                            </div>
                            <div class="ms-auto">
                                <select class="form-control form-control-sm" name="" id="filter-status-bimbingan">
                                    <option value="waiting">Request</option>
                                    <option value="done">Done</option>
                                    <option value="all">Semua</option>
                                </select>
                            </div>
                        </div>
                        <table class="table text-nowrap w-100">
                            <tbody>
                                @if($kelompok->bimbingan->count() > 0)
                                @foreach($kelompok->bimbingan->sortByDesc('created_at') as $kb)
                                <tr class="bimbingan_list bimbingan{{ $kb->is_done ? 'done' : $kb->reference->value }} bimbingan{{ $kb->is_done ? 'done' : $kb->reference->value }}"
                                    {{-- id="bimbingan{{ $kb->is_done ? 'done' : $kb->reference->value }}" --}}>
                                    <td class="text-center">
                                        <h6 class="mb-0">{{Carbon\Carbon::parse($kb->waktu)->format('d')}}</h6>
                                        <div class="fs-sm text-muted lh-1 text-uppercase">
                                            {{Carbon\Carbon::parse($kb->waktu)->format('M')}}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <small>
                                                    <a href="#" class="text-body fw-semibold letter-icon-title"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_detail{{ $kb->id }}">
                                                        {{Str::limit($kb->description,15)}}
                                                    </a>
                                                </small>
                                                <div class="d-flex align-items-center text-muted fs-sm">
                                                    <span class="
                                                            @if($kb->reference->value == 'waiting')
                                                                bg-info
                                                            @elseif($kb->reference->value == 'approve')
                                                                bg-success
                                                            @elseif($kb->reference->value == 'reject')
                                                                bg-danger
                                                            @elseif($kb->reference->value == 'reschedule')
                                                                bg-warning
                                                            @endif
                                                             rounded-pill p-1 me-2"></span>
                                                    {{ $kb->is_done ? 'done' : $kb->reference->value }}
                                                    @if ($kb->is_done)
                                                    <a class="fs-sm ms-2" href="" data-bs-toggle="modal"
                                                        data-bs-target="#modal_detail{{ $kb->id }}"> Detail</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if (!$kb->is_done)
                                        <div class="dropdown">
                                            <a href="#" class="text-body" data-bs-toggle="dropdown">
                                                <i class="ph-list">
                                                    @role('dosen')
                                                    @if ($kb->hasil)
                                                    <small>
                                                        <i style="font-size: 14px;" data-bs-popup="tooltip"
                                                            title="Cek hasil bimbingan yang telah diuppload"
                                                            class="text-warning ph-warning-circle"></i>
                                                    </small>
                                                    @endif
                                                    @endrole
                                                </i>
                                                {{-- $kb->hasil --}}
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">

                                                @role('dosen')
                                                {{-- @can('update status bimbingan') --}}
                                                @if (Gate::check('is_pembimbing', $kelompok))
                                                @if ($kb->reference->value == 'waiting')
                                                @foreach($status_bimbingan as $sb)
                                                <a href="/bimbingan/status/{{$sb->id}}/{{$kb->id}}"
                                                    class="dropdown-item">
                                                    @if($sb->value == 'approve')
                                                    <i class="ph-checks text-success me-2"></i>
                                                    @elseif($sb->value == 'reject')
                                                    <i class="ph-x text-danger me-2"></i>
                                                    @elseif($sb->value == 'reschedule')
                                                    <i class="ph-calendar-x text-info me-2"></i>
                                                    @endif
                                                    {{$sb->value}}
                                                </a>
                                                @endforeach
                                                @endif
                                                @endif
                                                @endrole
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#modal_detail{{ $kb->id }}"
                                                    class="dropdown-item text-secondary"><i
                                                        class="ph-eye"></i>&nbsp;Lihat</a>
                                                @if ($kb->hasil == NULL)
                                                @role('mahasiswa')
                                                @if($kb->reference->value == 'approve' && !$kb->is_done)
                                                <a href="#" class="dropdown-item" data-bs-toggle="offcanvas"
                                                    data-bs-target="#upload_bukti{{$kb->id}}">
                                                    <i class="ph-microsoft-excel-logo me-2"></i>
                                                    Hasil bimbingan
                                                </a>
                                                @endif
                                                @endrole
                                                @else
                                                {{-- @role('dosen') --}}
                                                @if($kb->reference->value == 'approve' && !$kb->is_done)
                                                <a href="#" class="dropdown-item" data-bs-toggle="offcanvas"
                                                    data-bs-target="#upload_bukti{{$kb->id}}">
                                                    <i class="ph-microsoft-excel-logo me-2"></i>
                                                    Lihat Hasil bimbingan
                                                </a>
                                                @endif
                                                {{-- @endrole --}}
                                                @endif
                                                {{-- @endif --}}
                                                {{-- @endcan --}}
                                                @role('mahasiswa')
                                                @if($kb->reference->value == 'waiting')
                                                <a href="#" class="text-danger dropdown-item" data-bs-popup="tooltip"
                                                    title="hapus" data-bs-toggle="modal"
                                                    data-bs-target="#modal_hapus{{$kb->id}}">
                                                    <i class="ph-trash me-2"></i> Batal
                                                </a>
                                                @endif
                                                @endrole
                                                {{-- @endif --}}

                                            </div>
                                        </div>
                                        @else
                                        <div class="d-flex">
                                            <i class="ph-circle-wavy-check text-success"></i>&nbsp;
                                        </div>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Lihat bimbingan Modal -->
                                <div id="modal_detail{{ $kb->id }}" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Bimbingan</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div>
                                                    <small class="fw-bold">Deskripsi : </small>
                                                    <p>{{$kb->description}}</p>
                                                </div>
                                                <div>
                                                    <small class="fw-bold">Waktu : </small>
                                                    <p>{{$kb->waktu}}</p>
                                                </div>
                                                <div>
                                                    <small class="fw-bold">Ruangan : </small>
                                                    <p>{{$kb->ruangan->nama}}</p>
                                                </div>
                                                @if ($kb->is_done)
                                                <div class=" bg-primary bg-opacity-10 rounded p-2 d-flex">
                                                    <small>
                                                        {!!$kb->hasil!!}
                                                    </small>
                                                </div>
                                                @endif
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <div class="ms-auto">
                                                    @if (!$kb->is_done)
                                                    <div class="dropdown">
                                                        <a href="#" class="btn btn-sm btn-primary"
                                                            data-bs-toggle="dropdown">
                                                            <span>
                                                                Pilih opsi
                                                                @role('dosen')
                                                                @if ($kb->hasil)
                                                                <small><i style="font-size: 14px;"
                                                                        data-bs-popup="tooltip"
                                                                        title="Cek hasil bimbingan"
                                                                        class="text-warning ph-warning-circle"></i></small>
                                                                @endif
                                                                @endrole
                                                            </span>
                                                            {{-- $kb->hasil --}}
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">

                                                            @role('dosen')
                                                            {{-- @can('update status bimbingan') --}}
                                                            @if (Gate::check('is_pembimbing', $kelompok))
                                                            @if ($kb->reference->value == 'waiting')
                                                            @foreach($status_bimbingan as $sb)
                                                            <a href="/bimbingan/status/{{$sb->id}}/{{$kb->id}}"
                                                                class="dropdown-item">
                                                                @if($sb->value == 'approve')
                                                                <i class="ph-checks text-success me-2"></i>
                                                                @elseif($sb->value == 'reject')
                                                                <i class="ph-x text-danger me-2"></i>
                                                                @elseif($sb->value == 'reschedule')
                                                                <i class="ph-calendar-x text-info me-2"></i>
                                                                @endif
                                                                {{$sb->value}}
                                                            </a>
                                                            @endforeach
                                                            @endif
                                                            @endif
                                                            @endrole
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#modal_detail{{ $kb->id }}"
                                                                class="dropdown-item text-secondary"><i
                                                                    class="ph-eye"></i>&nbsp;Lihat</a>
                                                            @if ($kb->hasil == NULL)
                                                            @role('mahasiswa')
                                                            @if($kb->reference->value == 'approve' && !$kb->is_done)
                                                            <a href="#" class="dropdown-item" data-bs-toggle="offcanvas"
                                                                data-bs-target="#upload_bukti{{$kb->id}}">
                                                                <i class="ph-microsoft-excel-logo me-2"></i>
                                                                Hasil bimbingan
                                                            </a>
                                                            @endif
                                                            @endrole
                                                            @else
                                                            {{-- @role('dosen') --}}
                                                            @if($kb->reference->value == 'approve' && !$kb->is_done)
                                                            <a href="#" class="dropdown-item" data-bs-toggle="offcanvas"
                                                                data-bs-target="#upload_bukti{{$kb->id}}">
                                                                <i class="ph-microsoft-excel-logo me-2"></i>
                                                                Lihat hasil bimbingan
                                                            </a>
                                                            @endif
                                                            {{-- @endrole --}}
                                                            @endif
                                                            {{-- @endif --}}
                                                            {{-- @endcan --}}
                                                            @role('mahasiswa')
                                                            @if($kb->reference->value == 'waiting')
                                                            <a href="#" class="text-danger dropdown-item"
                                                                data-bs-popup="tooltip" title="hapus"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal_hapus{{$kb->id}}">
                                                                <i class="ph-trash me-2"></i> Batal
                                                            </a>
                                                            @endif
                                                            @endrole
                                                            {{-- @endif --}}

                                                        </div>
                                                    </div>
                                                    @else
                                                    <div>
                                                        <i class="ph-circle-wavy-check text-success"></i>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Lihat bimbingan Modal -->

                                <!-- Sticky footer -->
                                <div id="upload_bukti{{$kb->id}}" class="offcanvas offcanvas-end offcanvas-size-lg"
                                    tabindex="-1">
                                    <div class="offcanvas-header border-bottom">
                                        <h5 class="offcanvas-title fw-semibold">Hasil Bimbingan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                    </div>
                                    <div class="offcanvas-body">

                                        @if ($kb->hasil == NULL)
                                        <form action="/bimbingan/upload/{{$kb->id}}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mt-2">
                                                <label class="form-label">Hasil bimbingan</label>
                                                <textarea class="form-control" id="ckeditor_classic_edit{{$kb->id}}"
                                                    name="hasil"
                                                    placeholder="Masukkan komponen penilaian anda disini..."
                                                    required>{{old('komponen_penilaian',$kb->komponen_penilaian)}}</textarea>
                                                @error('komponen_penilaian')
                                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{
                                                    $message }}
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="border-top p-3">
                                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                                            </div>
                                        </form>
                                        @else

                                        <div class="py-1">
                                            <small>Hasil Bimbingan</small>
                                        </div>

                                        <div class=" bg-primary bg-opacity-10 rounded p-2 d-flex">
                                            <small>
                                                {!!$kb->hasil!!}
                                            </small>
                                            {{-- <a href="{{asset('/storage/public/bukti-bimbingan/'.$kb->hasil)}}"
                                                download class="navbar-nav-link navbar-nav-link-icon text-primary"
                                                target="_blank">
                                                <div class="d-flex align-items-center mx-md-1">
                                                    <i class="ph-file"></i>
                                                    <span class="d-none d-md-inline-block ms-2">{{$kb->hasil}}</span>
                                                </div>
                                            </a> --}}
                                            @role('mahasiswa')
                                            <div class="ms-auto">
                                                <small class="fw-light" data-bs-toggle="modal"
                                                    data-bs-target="#modal_hapus{{$kb->id}}_file"><a href="#"
                                                        class="text-secondary">Hapus</a></small>
                                            </div>
                                            @endrole
                                        </div>
                                        @role('dosen')
                                        <form action="/bimbingan/approve/{{$kb->id}}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="border-top p-3">
                                                <button type="submit" class="btn btn-success w-100">Approve</button>
                                            </div>
                                        </form>
                                        @endrole

                                        @endif

                                    </div>
                                </div>
                                <!-- /sticky footer -->

                                <!-- Delete Modal -->
                                <div id="modal_hapus{{$kb->id}}_file" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog modal-xs">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="ph-warning text-warning"></i>
                                                    Konfirmasi</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus file ini ?
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form action="/request/{{$kb->id}}/delete-file" method="post">
                                                    @csrf
                                                    <input type="hidden" name="old_file" value="{{$kb->hasil}}">
                                                    <button type="submit" class="btn btn-primary">Ya</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Delete Modal -->

                                <!-- Delete Modal -->
                                <div id="modal_hapus{{$kb->id}}" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog modal-xs">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="ph-warning text-warning"></i>
                                                    Konfirmasi</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus data bimbingan ini ?
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Batal</button>
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

                                <script>
                                    CKEDITOR.replace('ckeditor_classic_edit{{$kb->id}}', {
                                        toolbar: 'Basic'
                                    });
                                </script>
                                @endforeach
                                @else
                                <p class="text-muted text-center">Belum ada bimbingan tersedia</p>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                @role('mahasiswa')
                <div class="tab-pane fade" id="tambah-bimbingan">
                    <form action="/bimbingan" method="post">
                        @csrf
                        <input type="text" name="kelompok_id" value="{{$kelompok->id}}" class="d-none">
                        <div class="p-1">
                            <label for="">Deskripsi</label>
                            <textarea class="form-control" name="description" type="text"
                                placeholder="Deskripsi bimbingan" required>{{old('deskripsi')}}</textarea>
                        </div>
                        <div class="p-1">
                            <label for="">Waktu</label>
                            <input class="form-control" value="{{old('deskripsi')}}" name="waktu" type="datetime-local"
                                placeholder="waktu bimbingan" required>
                        </div>
                        <div class="p-1">
                            <label for="">Ruangan</label>
                            <select class="form-control" name="ruangan_id" placeholder="waktu bimbingan" required>
                                <option value="">Pilih ruangan</option>
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
                @endrole
            </div>
            <!-- /tabs content -->


        </div>

        <div class="chart mb-2" id="app_sales"></div>
        <div class="chart" id="monthly-sales-stats"></div>
    </div>
    <!-- /sales stats -->

    @if ($kelompok->krs->template->where('is_verified',true)->count() > 0)
    <div class="card">
        <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
            <h5 class="py-sm-2 my-sm-1">Template Dokumen </h5><br>
        </div>
        <div class="card-body">
            @foreach ($kelompok->krs->template->where('is_verified',true) as $d)
            <div class="p-2 w-100 border border-1 rounded mb-2">
                @php
                $size = '';
                $path = '/app/public/public/file-template/'.$d->file_template;
                if (file_exists(storage_path($path))) {
                $size = File::size(storage_path($path));
                $size = (int) $size;
                $base = log($size) / log(1024);
                $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
                $size = round(pow(1024, $base - floor($base)),2) . $suffixes[floor($base)];
                }else{
                $size = 'unknown';
                }
                @endphp
                <p class="fs-sm text-muted">{{$d->deskripsi}}</p>
                <a href="{{public_path('storage/public/file-template/'.$d->file_template)}}"
                    class="btn btn-sm bg-secondary bg-opacity-10 text-secondary rounded" download=""><i
                        class="ph-file-doc"></i>&nbsp; {{Str::limit($d->file_template, 15)}} <span
                        class="ms-3 fw-semibold"><i class="ph-download"></i> &nbsp;{{$size}}</span></a>
            </div>
            @endforeach

        </div>
    </div>
    @endif
</div>
</div>

<!-- Large modal -->
<div id="modal_detail_rekap_bimbingan" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rekap hasil bimbingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Waktu bimbingan</th>
                        <th>Topik bimbingan</th>
                        <th>Hasil bimbingan</th>
                    </tr>
                    @foreach ($kelompok->bimbingan as $kb)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$kb->waktu}}</td>
                        <td>{{$kb->description}}</td>
                        <td>{!!$kb->hasil!!}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- /large modal -->

<script>
    // $('.bimbingan_list').hide();
    $('.bimbinganall').show();
    $('#filter-status-bimbingan').change(function() {
        var selectedValue = $(this).val();
        console.log(selectedValue);
        $('.bimbingan_list').hide();
        if (selectedValue == 'all') {
            $('.bimbingan_list').show();
        } else {
            $('.bimbingan' + selectedValue).show();
        }
    });
</script>

@endsection
