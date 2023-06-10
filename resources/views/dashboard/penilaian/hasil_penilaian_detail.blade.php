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
@endpush

@section('breadscrumb')
@if (Auth::user()->dosen->nidn == $krs->dosen_mk || Auth::user()->dosen->nidn == $krs->dosen_mk_2)
<a href="/koordinator/myproject" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
@endif
<a href="/krs/{{$krs->id}}/hasil_penilaian{{$pembimbing_kelompok != NULL ? '?kelompok='.$pembimbing_kelompok : ''}} " class="breadcrumb-item py-2"> Hasil Penilaian</a>
<span class="breadcrumb-item active py-2">{{$penilaian->nama_poin}}</span>
@endsection

@section('content')
<div class="row">
    <div class="card">
        <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
            <h5 class="py-sm-2 my-sm-1">Nilai Mahasiswa {{$penilaian->nama_poin}}</h5><br>
            <div class="mt-2 ms-sm-auto">
                @if($pembimbing_kelompok == NULL)
                <div class="d-flex">
                    <a href="/krs/{{$krs->id}}/hasil_penilaian/penilaian/{{$penilaian->id}}/export"
                        class="btn btn-sm btn-success fw-semibold"><i class="ph-microsoft-excel-logo"></i>&nbsp; EXCEL
                        EXPORT</a>
                </div>
                @endif
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table  w-100 scrollable-table table-bordered" style="">
                <thead>
                    <tr>
                        <th rowspan="2">Kelompok</th>
                        <th rowspan="2">NIM</th>
                        <th class="" style="width: 300px;" rowspan="2">Mahasiswa</th>
                        @foreach ($penilaian->role_group_penilaian as $pkp)
                        <th class="text-center" colspan="{{$penilaian->komponen_penilaian->count()}}">
                            {{$pkp->role_group->nama}}</th>
                        @endforeach
                        <th class="" rowspan="2">Nilai akhir

                            {{-- <div class="btn-group">
                                <small class="text-warning" data-bs-toggle="dropdown" data-bs-popup="tooltip"
                                    title="Apakah anda ingin membatalkan approve penilaian?"><i
                                        class="ph-warning-circle"></i></small>

                                <div class="dropdown-menu" class="w-100">
                                    <form
                                        action="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/{{$penilaian->id}}/approved"
                                        method="post">
                                        @csrf
                                        <input type="hidden" name="unapproved" value="cancel">
                                        <div class="p-1">
                                            <i class="fw-light">
                                                <small>Apakah anda yakin ingin <br> membatalkan approve nilai?</small>
                                            </i>
                                            <div class="d-flex justify-content-right">
                                                <button
                                                    class="text-primary border-0 badge bg-primary bg-opacity-10"><small>Ya</small></button>&nbsp;&nbsp;
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> --}}

                        </th>
                    </tr>
                    <tr>
                        @foreach ($penilaian->role_group_penilaian as $pgp)
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
                                        <button type="button" class="btn btn-link"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /modal with h5 -->
                        @endforeach
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                    $krs_hasil_detail_penilaian = $krs->kelompok_mahasiswa->where('deleted_at',NULL);
                    if ($pembimbing_kelompok != NULL) {
                    $krs_hasil_detail_penilaian =
                    $krs->kelompok_mahasiswa->where('deleted_at',NULL)->where('kelompok_id',$pembimbing_kelompok);
                    }
                    @endphp
                    @foreach ($krs_hasil_detail_penilaian as $kk)
                    <tr>
                        <td class="fw-semibold"><small>{{$kk->nama_kelompok}}</small></td>
                        <td><small>{{$kk->nim}}</small></td>
                        {{-- <td><small>{{$kk->kelompok_mahasiswa}}</small></td> --}}
                        @foreach ($kk->kelompok_mahasiswa->where('nim',$kk->nim) as $kkm)
                        @php
                        $total_nilai = 0;
                        @endphp
                        <td><small>{{$kkm->mahasiswa->user->nama}}</small></td>
                        @foreach ($penilaian->role_group_penilaian as $pgp)
                        @if ($penilaian->komponen_penilaian->count() > 0)

                        @foreach ($penilaian->komponen_penilaian as $pkp)
                        @php
                        $nilai_komponen_mahasiswa = $pkp->detail_nilai_mahasiswa()
                        ->where('nilai_mahasiswas.kelompok_id',$kk->kelompok_id)
                        ->where('komponen_id', $pkp->id)
                        ->where('nim', $kkm->mahasiswa->nim)
                        ->where('role_kelompoks.role_group_id', $pgp->role_group->id)
                        ->where('approved_status', true);
                        @endphp

                        <td>
                            @if ( $nilai_komponen_mahasiswa->first() != NULL)
                            @php
                            $total_nilai += $nilai_komponen_mahasiswa->first()->nilai * ($pkp->bobot / 100);
                            @endphp
                            {{ $nilai_komponen_mahasiswa->first()->nilai / ($pkp->bobot / 100) }}
                            @else
                            -
                            @endif
                        </td>

                        @endforeach
                        @else
                        <td><small></small><i>nilai belum tersedia</i></td>
                        @endif
                        @endforeach
                        <td class="fw-semibold">
                            <a data-bs-toggle="modal" data-bs-target="#kelompok_nilai_{{$kk->id}}" class="text-primary"
                                href="">{{number_format( $penilaian->nilai_mahasiswa($kkm->mahasiswa->nim,
                                $kk->id)->where('approved_status',true)->sum('nilai'), 2, '.', '')}}</a>

                            {{-- <small class="text-warning" data-bs-popup="tooltip"
                                title="Apakah anda ingin membatalkan approve penilaian?"><i
                                    class="ph-warning-circle"></i></small> --}}


                            {{-- <form
                                action="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/{{$penilaian->id}}/approved"
                                method="post">
                                @csrf
                                <input type="hidden" name="unapproved" value="cancel">
                                <div class="p-1">
                                    <i class="fw-light">
                                        <small>Apakah anda yakin ingin <br> membatalkan approve nilai?</small>
                                    </i>
                                    <div class="d-flex justify-content-right">
                                        <button
                                            class="text-primary border-0 badge bg-primary bg-opacity-10"><small>Ya</small></button>&nbsp;&nbsp;
                                    </div>
                                </div>
                            </form> --}}
                            {{-- asdasd --}}

                        </td>
                        @endforeach
                    </tr>

                    <!-- Delete Modal -->
                    <div id="kelompok_nilai_{{$kk->id}}" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="text-justify">
                                        Apakah anda yakin ingin mengunapprove nilai pada kelompok <span
                                            class="fw-semibold text-secondary">{{$kk->nama_kelompok}}</span>?
                                    </div>
                                    <div>
                                        <form method="post"
                                            action="/kelompok/{{$kk->id}}/penilaian/{{$penilaian->id}}/approved">
                                            @csrf
                                            <input type="hidden" name="unapproved" value="cancel">
                                            <select class="form-control" name="role_group_id" id=""
                                                placeholder="Pilih role penilaian..." required>
                                                <option value="">Pilih role</option>
                                                @foreach ($penilaian->role_group_penilaian as $prp)
                                                <option value="{{$prp->role_group->id}}">{{$prp->role_group->nama}}
                                                </option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="submit" class="btn btn-primary">Ya</button>
                                    </form>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Delete Modal -->

                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">

        </div>
    </div>


    <div class="col-xl-4">

    </div>

</div>

@endsection