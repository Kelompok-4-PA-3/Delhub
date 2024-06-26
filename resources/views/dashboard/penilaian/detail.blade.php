@extends('main')

@section('title')
    <title>
        Penilaian {{ $penilaian->nama_poin }}</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/extra_fab.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script src="{{ asset('/assets/js/vendor/editors/ckeditor/ckeditor_classic.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/editor_ckeditor_classic.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/extra_sweetalert.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css"
        rel="stylesheet" />
    <script>
        $.fn.poshytip = {
            defaults: null
        }
    </script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js">
    </script>
@endpush


@section('breadscrumb')
    @role('dosen')
        @if (Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk || Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk_2)
            <a href="/koordinator/myproject" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
            <a href="/koordinator/proyeksaya/{{ $kelompok->krs->id }}" class="breadcrumb-item py-2">
                {{ $kelompok->krs->kategori->nama_singkat }}</a>
        @endif
    @endrole
    <a href="/kelompok/{{ $kelompok->id }}" class="breadcrumb-item py-2"> {{ $kelompok->nama_kelompok }}</a>
    <a href="/kelompok/{{ $kelompok->id }}/penilaian/role/{{ $role_dosen->id }}"
        class="breadcrumb-item py-2">{{ $role_dosen->role_group->nama }}</a>
    <span class="breadcrumb-item active py-2">{{ $penilaian->nama_poin }}</span>
@endsection

@section('content')
    <style>
        .editableform {
            background: white;
            box-shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;
            padding: 9px;
            padding-left: 11px;
            padding-right: 11px;
            border-radius: 3px;
        }

        .editable-buttons button {
            padding: 1px;
            padding-left: 6px;
            padding-right: 6px;
            border: 0;
            border-radius: 5px;
            font-size: 8px;
            font-weight: light;
        }

        .editable-submit {
            background-color: rgb(9, 87, 231);
            color: white;
        }

        .editable-cancel {
            background-color: rgb(230, 48, 20);
            color: white;
        }

        .input-mini {
            border: 0;
            padding: 1px;
            max-width: 50px;
        }

        .input-mini:focus {
            outline: none;
            border: none;
            max-width: 75px;
            /* background-color: black; */
        }
    </style>

    <div class="row">

        <div class="mb-2">
            <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                <li class="nav-item"><a href="/kelompok/{{ $kelompok->id }}" class="nav-link"> <i
                            class="ph-squares-four"></i>
                        &nbsp; Kelompok</a></li>
                <li class="nav-item"><a href="/kelompok/{{ $kelompok->id }}/artefak" class="nav-link"> <i
                            class="ph-folders"></i> &nbsp; Artefak</a></li>
                <li class="nav-item"><a href="/kelompok/{{ $kelompok->id }}/orang" class="nav-link"> <i
                            class="ph-users"></i>
                        &nbsp; Orang</a></li>
                @role('dosen')
                    <li class="nav-item">
                        <a href="" class="nav-link btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="ph-notebook"></i> &nbsp; Penilaian</a>
                        <div class="dropdown-menu">
                            @foreach (Auth::user()->dosen->role_kelompok->where('kelompok_id', $kelompok->id) as $myrole)
                                @if ($myrole->role_group != null)
                                    <div class="list-group">
                                        <div class="d-flex">
                                            <a @if ($myrole->is_verified) href="/kelompok/{{ $kelompok->id }}/penilaian/role/{{ $myrole->id }}" @endif
                                                class="dropdown-item"><i class="ph-notebook"></i>
                                                &nbsp;{{ $myrole->role_group->nama }}
                                                &nbsp; @if (!$myrole->is_verified)
                                                    <i class="ph-warning-circle text-warning" style="cursor:pointer;"
                                                        data-bs-popup="tooltip" title="Role anda belum diverfikasi"></i>
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </li>
                @endrole
                @role('dosen')
                    @if ($kelompok->krs->dosen_mk == Auth::user()->dosen->nim || $kelompok->krs->dosen_mk_2 == Auth::user()->dosen->nim)
                        <li class="nav-item active">
                            <a href="/kelompok/{{ $kelompok->id }}/penilaian/koordinator" class="nav-link btn btn-primary"><i
                                    class="ph-notebook"></i> &nbsp; Hasil Penilaian</a>
                        </li>
                    @endif
                @endrole
            </ul>
        </div>
        <div class="col-xl-12">
            {{-- <table>

        </table> --}}
            <div class="card">
                <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                    @php
                        $status_nilai = true;
                        if (
                            $penilaian
                                ->nilai_mahasiswa_kelompok($kelompok->id)
                                ->where('role_dosen_kelompok_id', $role_dosen->id)
                                ->where('approved_status', false)
                                ->count() > 0 ||
                            $penilaian
                                ->nilai_mahasiswa_kelompok($kelompok->id)
                                ->where('role_dosen_kelompok_id', $role_dosen->id)
                                ->count() < 1
                        ) {
                            $status_nilai = false;
                        }
                    @endphp {{-- {{$penilaian->nilai_mahasiswa_kelompok($kelompok->id)->wher
                    e('role_dosen_kelompok_id',$role_dosen->id)}} --}}
                    <h5 class="py-sm-2 my-sm-1">Penilaian {{ $penilaian->nama_poin }}</h5><br>
                    <div class="mt-2 mt-sm-0 ms-sm-auto">
                        @if (!$status_nilai)
                            <span class="bg-warning text-warning bg-opacity-10 p-2 px-2 rounded-pill">
                                <i class="ph-warning-circle"></i> NILAI BELUM DIAPPROVED
                            </span>
                        @else
                            <span class="bg-success text-success bg-opacity-10 p-2 px-2 rounded-pill">
                                <i class="ph-check-circle"></i> NILAI SUDAH DIAPPROVED
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <div>
                        <b class="text-muted me-2">Note : </b>
                        @if (!$status_nilai)
                            <i class="fs-sm me-2"><i class="ph-warning-circle text-info"></i> Klik kolom table untuk
                                memasukkan
                                nilai mahasiswa</i>
                        @else
                            <i class="fs-sm"><i class="ph-warning text-warning"></i> Jika nilai sudah diapprove anda tidak
                                dapat
                                lagi menginputkan nilai</i>
                        @endif
                    </div>
                    <table class="table datatable-hasil-nilai w-100 scrollable-table table-bordered ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                @foreach ($penilaian->komponen_penilaian as $pkp)
                                    <th>
                                        <a href="" data-bs-toggle="modal"
                                            data-bs-target="#detail_komponen_{{ $pkp->id }}">
                                            N{{ $loop->iteration }}
                                        </a><br>
                                        <small class="fw-light">{{ $pkp->bobot }} %</small>
                                    </th>

                                    <!-- Modal with h5 -->
                                    <div id="detail_komponen_{{ $pkp->id }}" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog modal-xs">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Penilaian {{ $penilaian->nama_poin }}</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="row">
                                                        <small class="fw-bold">Komponen penilaian : </small>
                                                        <p>{!! $pkp->nama_komponen !!}</p>
                                                        <hr>
                                                        <small class="fw-bold">Bobot : </small>
                                                        <p>{!! $pkp->bobot !!} %</p>
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

                                <th class="{{ $status_nilai ? '' : 'bg-warning bg-opacity-10 text-warning' }}">
                                    Nilai
                                    <div>
                                        @if (!$status_nilai)
                                            {{-- <form
                                        action="/kelompok/{{$kelompok->id}}/penilaian/role/{{$role_dosen->id}}/{{$penilaian->id}}/approved"
                                        method="post">
                                        @csrf
                                        @if ($penilaian->nilai_mahasiswa_kelompok($kelompok->id)->count() > 0) --}}
                                            <button type="button" class="badge border-0 bg-success mt-1 fw-light "
                                                data-bs-toggle="modal" data-bs-target="#approve_nilai">
                                                approve
                                            </button>
                                            {{-- @endif
                                    </form> --}}
                                        @else
                                            <small class="text-success"><i class="ph-checks"></i> approved</small>

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
                                                        <small>Apakah anda yakin ingin <br> membatalkan approve
                                                            nilai?</small>
                                                    </i>
                                                    <div class="d-flex justify-content-right">
                                                        <button
                                                            class="text-primary border-0 badge bg-primary bg-opacity-10"><small>Ya</small></button>&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div> --}}
                                        @endif
                                    </div>
                                </th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                            <tr>
                                <th></th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                @foreach ($penilaian->komponen_penilaian as $item)
                                    <th>N{{ $loop->iteration }}</th>
                                @endforeach
                                <th class="{{ !$status_nilai ? 'bg-warning bg-opacity-10 text-warning' : '' }}">
                                    <div>
                                        <a href="" class="btn btn-sm btn-primary"><i class="ph-arrows-clockwise"></i>
                                            &nbsp;Calculate</a>
                                    </div>
                                </th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelompok->kelompok_mahasiswas as $kkm)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kkm->mahasiswa->nim }}</td>
                                    <td>{{ $kkm->mahasiswa->user->nama }}</td>
                                    @if ($penilaian->komponen_penilaian->count() > 0)
                                        @php
                                            $nilai_akhir = 0;
                                        @endphp
                                        @foreach ($penilaian->komponen_penilaian as $pkp)
                                            <td class="{{ !$status_nilai ? 'add_nilai text-primary' : '' }}"
                                                data-name="komponen" data-pkp_id="{{ $pkp->id }}"
                                                data-mahasiswa={{ $kkm->mahasiswa->nim }} data-type="number"
                                                data-max="100" data-min="0"
                                                @if ($status_nilai) data-bs-popup="popover"
                                title="Tidak dapat menginputkan nilai !"
                                data-bs-content="Anda dapat menginformasi koordinator untuk unapprove nilai anda
                                sekarang" @endif
                                                style="cursor:pointer;">

                                                @php
                                                    $nilai_komponen_mahasiswa = $pkp
                                                        ->detail_nilai_mahasiswa()
                                                        ->where('nilai_mahasiswas.kelompok_id', $kelompok->id)
                                                        ->where('komponen_id', $pkp->id)
                                                        ->where('nim', $kkm->mahasiswa->nim)
                                                        ->where('role_dosen_kelompok_id', $role_dosen->id);
                                                @endphp

                                                @if ($nilai_komponen_mahasiswa->first() != null)
                                                    {{ $nilai_komponen_mahasiswa->first()->nilai / ($pkp->bobot / 100) }}
                                                    @php
                                                        $nilai_akhir += $nilai_komponen_mahasiswa->first()->nilai;
                                                    @endphp
                                                @endif

                                                {{-- @if ($status_nilai)
                                </span>
                                @endif --}}
                                                {{-- <button data-bs-popup="popover" title="Popover title"
                                    data-bs-content="And here's some amazing content. It's very engaging. Right?">

                                </button> --}}
                                            </td>
                                        @endforeach
                                    @endif
                                    <td
                                        class="{{ !$status_nilai ? 'bg-warning bg-opacity-10 text-warning' : '' }} fw-semibold">
                                        {{ $nilai_akhir }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- <div class="border rounded p-2 p-lg-4 mb-4"> --}}

        {{-- </div> --}}


        <script type="text/javascript">
            $.fn.editable.defaults.mode = 'inline';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $('.add_nilai').editable({
                url: "/kelompok/{{ $kelompok->id }}/penilaian/role/{{ $role_dosen->id }}/{{ $penilaian->id }}/komponen/store",
                type: 'number',
                pk: function() {
                    return $(this).data('pkp_id');
                },
                mahasiswa: function() {
                    return $(this).data('mahasiswa');
                },
                name: 'komponen',
                title: 'Enter Field',
                // url: function(params) {
                //     // var rkp_id = $(this).data('rkp_id');
                //     return "/kelompok/{{ $kelompok->id }}/penilaian/role_kelompok/{{ $role_dosen->id }}/{{ $penilaian->id }}/komponen/store";
                // },
                params: function(params) {
                    params.mahasiswa = $(this).editable().data(
                        'mahasiswa'); // add the new attribute to the AJAX request
                    return params;
                },
                showbuttons: false,
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

        <!-- Delete Modal -->
        <div id="approve_nilai" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-xs">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        Apakah anda yakin ingin approve nilai ini? nilai yang telah diapprove tidak dapat diubah kembali
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <form
                            action="/kelompok/{{ $kelompok->id }}/penilaian/role/{{ $role_dosen->id }}/{{ $penilaian->id }}/approved"
                            method="post">
                            @csrf
                            @if ($penilaian->nilai_mahasiswa_kelompok($kelompok->id)->count() > 0)
                                <button type="submit" class="btn btn-primary">Ya</button>
                            @endif
                        </form>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Modal -->



    @endsection
