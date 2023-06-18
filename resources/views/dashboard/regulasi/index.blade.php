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
    .table-regulasi {
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
                    .img-success {
                        position: absolute;
                        margin-top: -25px;
                        margin-right: -85px;
                    }

                    .bg-check-success {
                        background-color: #D1E7DD !important;
                    }

                    .pembimbing-name {
                        cursor: pointer;
                    }
                </style>

                @php
                $bimbingan = 0;
                @endphp
                @if ($krs->kategori->kategori->poin_regulasi != NULL)
                <div class="card-body table-responsive">
                    <table class="table datatable-regulasi w-100 scrollable-table table-bordered"
                        style="min-width: 1200px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th><small> Nama Kelompok </small></th>
                                <th><small> Jlh Bimbingan </small></th>
                                @foreach ($krs->kategori_role_get_pembimbing as $rrg)
                                <th>{{$rrg->nama}}</th>
                                @endforeach
                                @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                                <th>{{$kkkp->nama}}</th>
                                @endforeach
                                <th>Rekap Bimbingan</th>
                                @foreach ($krs->submission as $ks)
                                <th>
                                    <div class="text-center">
                                        <small class="fs-sm text-muted fw-light">Submission</small><br>
                                        {{$ks->deskripsi}}
                                    </div>
                                </th>
                                @endforeach
                                @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                                <th>
                                    <div class="text-center">
                                        <small class="fs-sm text-muted fw-light">Feedback</small><br>
                                        {{$kkkp->nama}}
                                    </div>
                                </th>
                                @endforeach
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                                <th class="regulasi-column">{{$kkkp->nama}}</th>
                                @endforeach
                                <th></th>
                                @foreach ($krs->submission as $ks)
                                <th></th>
                                @endforeach
                                @foreach($krs->kategori->kategori->poin_regulasi as $kkkp)
                                <th></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelompok->sortBy('id') as $k)
                            @php
                            $bimbingan = $k->bimbingan->where('is_done',true)->count();
                            @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$k->nama_kelompok}}
                                </td>
                                <td class="text-center">{{$bimbingan}}</td>
                                @foreach ($krs->kategori_role_get_pembimbing as $rrg)
                                @if ($k->role_kelompok_all->where('role_group_id',$rrg->id)->count() > 0)
                                <td data-bs-popup="tooltip"
                                    title="{{$k->role_kelompok_all->where('role_group_id',$rrg->id)->first()->dosen->user->nama}}">
                                    {{$k->role_kelompok_all->where('role_group_id',$rrg->id)->first()->dosen->nama_singkat}}
                                </td>
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
                                    <img class="img-success" src="{{asset('img/check.gif')}}" style="max-width: 35px;"
                                        alt="">
                                </td>
                                @else
                                <td class="text-center"> {{$bimbingan + $kkkp->poin}} <small class="text-muted"> /
                                        {{$kkkp->poin}} </small></td>
                                @endif
                                @else
                                <td class="text-center"> 0 <small class="text-muted"> / {{$kkkp->poin}} </small></td>
                                @endif
                                @endforeach
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#rekap_bimbingan_{{$k->id}}">Lihat hasil bimbingan</button>

                                    <!-- Large modal -->
                                    <div id="rekap_bimbingan_{{$k->id}}" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Rekap hasil bimbingan</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Waktu bimbingan</th>
                                                            <th>Topik bimbingan</th>
                                                            <th>Hasil bimbingan</th>
                                                        </tr>
                                                        @if ($k->bimbingan->count() > 0)
                                                        @foreach ($k->bimbingan as $kb)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $kb->waktu }}</td>
                                                            <td>{{ $kb->description }}</td>
                                                            <td>{!! $kb->hasil !!}</td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="4">
                                                                <div class="text-center">
                                                                    <i>Tidak ada data hasil bimbingan</i>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /large modal -->
                                </td>

                                @foreach ($krs->submission as $ks)
                                <td>
                                    @if ($ks->artefak_kelompok->where('kelompoks_id',$k->id) == NULL ||
                                    $ks->artefak_kelompok->where('kelompoks_id',$k->id)->count() < 1) <small
                                        class="fs-sm"> <i class="text-warning">Belum disubmit!</i></small>
                                        @else
                                        @foreach ($ks->artefak_kelompok->where('kelompoks_id',$k->id) as $item)
                                        <div class="border border-1 p-2 rounded">
                                            <div class="d-flex p-1">
                                                <div class="me-3">
                                                    <small class="fs-sm mb-2"> <i class="ph-file text-primary"></i>
                                                        {{Str::limit($item->file, 15)}}</small><br>
                                                    @if (\Carbon\Carbon::parse($ks->deadline) >=
                                                    \Carbon\Carbon::parse($item->created_at))
                                                    <span class="text-success bg-success fs-sm bg-opacity-10">Tepat
                                                        waktu</span>
                                                    @else
                                                    @php
                                                    $terlambat =
                                                    Carbon\Carbon::parse($item->created_at)->diff(Carbon\Carbon::parse($ks->deadline));
                                                    @endphp
                                                    <a href="#" class="text-danger fs-sm  py-1" data-bs-popup="popover"
                                                        title="Waktu keterlambatan" data-bs-content=" {{ $terlambat->days . ' Hari ' }}
                                                        {{ $terlambat->h . ' jam ' }}
                                                        {{ $terlambat->i . ' menit ' }}
                                                        {{ $terlambat->s . ' detik ' }}"><i
                                                            class="ph-warning-circle"></i> Terlambat</a>
                                                    @endif
                                                </div>
                                                <div class="ms-auto ">
                                                    <small><a
                                                            href="{{asset('/storage/artefaks/'.$item->folder.'/'.$item->file)}}"
                                                            class="p-2 bg-primary bg-opacity-10 rounded-circle"
                                                            download><i class="ph-download"></i></a></small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                </td>
                                
                                @endforeach
                                @foreach($krs->kategori->kategori->poin_regulasi as $kkkkp)
                                <td>
                                    <a href="" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#feedback_{{$kkkkp->id}}_{{$k->id}}">Lihat feedback</a>
                                </td>

                                {{-- modal  --}}
                                <div id="feedback_{{$kkkkp->id}}_{{$k->id}}" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog modal-sm modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rekap hasil feedback</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                @if ($k->feedback->where('poin_regulasi_id',$kkkkp->id)->count() > 0)
                                                @foreach ($k->feedback->where('poin_regulasi_id',$kkkkp->id) as $f)
                                                <div class="">
                                                    <div>
                                                        <small class="fw-bold text-muted">Deskripsi feedback : </small>
                                                    </div>
                                                    <div class="fw-light">
                                                        {!!$f->feedback!!}
                                                    </div>
                                                    <div>
                                                        <small>
                                                            status :
                                                            @if ($f->status > 0)
                                                            @if ($f->status == 1)
                                                            <span
                                                                class="bg-success text-success fw-semibold fs-sm bg-opacity-10 p-1 px-2 rounded-pill">Terpenuhi</span>
                                                            @elseif($f->status == 2)
                                                            <span
                                                                class="bg-warning text-warning fw-semibold fs-sm bg-opacity-10 p-1 px-2 rounded-pill">Sebagian</span>
                                                            @else
                                                            <span
                                                                class="bg-danger text-danger fw-semibold fs-sm bg-opacity-10 p-1 px-2 rounded-pill">Belum</span>
                                                            @endif
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                                <hr>
                                                @endforeach

                                                @endif
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- modal  --}}

                                <!-- Sticky footer -->
                                <div id="feedback_{{$kkkkp->id}}_{{$k->id}}" class="offcanvas offcanvas-end  "
                                    tabindex="-1">
                                    <div class="offcanvas-header border-bottom">
                                        <h5 class="offcanvas-title fw-semibold">Tambah ruangan Lorem ipsum dolor, sit
                                            amet consectetur adipisicing elit. Doloribus laborum aliquam suscipit!
                                            Tenetur temporibus neque voluptatem quae suscipit nobis nostrum!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                    </div>

                                    <div class="offcanvas-body">
                                            <div class="modal-body">
                                                @if ($k->feedback->where('poin_regulasi_id',$kkkkp->id)->count() > 0)
                                                @foreach ($k->feedback->where('poin_regulasi_id',$kkkkp->id) as $f)
                                                <div class="border border-1 p-2 mb-2 " style="overflow-x:hidden">
                                                    <div>
                                                        <small>Deskripsi feedback : </small>
                                                    </div>
                                                    <div class="fw-light w-100">
                                                        {!!$f->feedback!!}
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Error
                                                        quia aut quam cupiditate saepe ipsa laborum nihil a dignissimos
                                                        aliquid.
                                                    </div>
                                                    <div>
                                                        <small>
                                                            status :
                                                            @if ($f->status > 0)
                                                                @if ($f->status == 1)
                                                                <span
                                                                    class="bg-success text-success fw-semibold fs-sm bg-opacity-10 p-1 px-2 rounded-pill">Terpenuhi</span>
                                                                @elseif($f->status == 2)
                                                                <span
                                                                    class="bg-warning text-warning fw-semibold fs-sm bg-opacity-10 p-1 px-2 rounded-pill">Sebagian</span>
                                                                @else
                                                                <span
                                                                    class="bg-danger text-danger fw-semibold fs-sm bg-opacity-10 p-1 px-2 rounded-pill">Belum</span>
                                                                @endif
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                    </div>
                                    <div class="border-top p-3">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, libero voluptas?
                                        Officia soluta nobis voluptatum reiciendis deserunt ducimus! Libero, error.
                                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                                    </div>
                                </div>
                                <!-- /sticky footer -->

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