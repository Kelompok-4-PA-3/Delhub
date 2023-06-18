@extends('main')

@section('title')
    <title>
        {{ $kelompok->nama_kelompok }}</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/ui/fab.min.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/ui/prism.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/extra_fab.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush


@section('breadscrumb')
    <style>
        .submission-card {
            /* box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
                             */
            /* box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px; */
            /* background-color: aliceblue; */
            background-color: white;
            transition: 0, 3s;
            cursor: pointer;
        }

        .submission-card:hover {
            background-color: rgb(233, 245, 255);
        }

        .upload_btn {
            transition: 0.5s;
        }

        .upload_btn:hover {
            transform: scale(1.3);
        }
    </style>
    @role('dosen')
        @if (Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk || Auth::user()->dosen->nidn == $kelompok->krs->dosen_mk_2)
            <a href="/koordinator/myproject" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
            <a href="/koordinator/proyeksaya/{{ $kelompok->krs->id }}" class="breadcrumb-item py-2">
                {{ $kelompok->krs->kategori->nama_singkat }}</a>
        @endif
    @endrole
    @role('admin')
        @if (Auth::user()->dosen == null)
            <a href="/koordinator/proyeksaya/{{ $kelompok->krs->id }}" class="breadcrumb-item py-2">
                {{ $kelompok->krs->kategori->nama_singkat }}</a>
        @endif
    @endrole
    @role('mahasiswa')
        <a href="/home" class="breadcrumb-item py-2"> Home</a>
    @endrole
    <span class="breadcrumb-item active py-2">{{ $kelompok->nama_kelompok }}</span>
@endsection

@section('content')
    {{-- @dd($kelompok) --}}

    <div class="mb-2">
        <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
            <li class="nav-item"><a href="/kelompok/{{$kelompok->id}}" class="nav-link"> <i class="ph-squares-four"></i> &nbsp;
                    Kelompok</a></li>
            <li class="nav-item"><a href="/kelompok/{{ $kelompok->id }}/artefak" class="nav-link active"> <i
                        class="ph-folders"></i> &nbsp; Artefak</a></li>
            <li class="nav-item"><a href="/kelompok/{{ $kelompok->id }}/orang" class="nav-link"> <i class="ph-users"></i>
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
                    <li class="nav-item">
                        <a href="/kelompok/{{ $kelompok->id }}/penilaian/koordinator" class="nav-link btn btn-primary"><i
                                class="ph-notebook"></i> &nbsp; Hasil Penilaian</a>
                    </li>
                @endif
            @endrole
        </ul>
    </div>

    <div class="card">
        <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
            <h5 class="py-sm-2 my-sm-1">Manajemen Artefak</h5>
        </div>
        <div class="card-body mb-5">
            <div class="row w-100 container">
                @foreach ($submission as $s)
                    <div class="col-lg-4 col-md-6 p-2">
                        <div class="submission-card p-2 border border-2 rounded">
                            <div class="d-flex">
                                <div>
                                    <a href="" class="fw-semibold text-primary"><i class="ph-folder"></i>
                                        {{ $s->deskripsi }}</a>
                                    @php
                                        $artefak_status = 'Not submitted';
                                        $artefak = $s->artefak_kelompok
                                            ->where('kelompoks_id', $kelompok->id)
                                            ->where('submission_id', $s->id)
                                            ->first();
                                    @endphp
                                    @if ($artefak != null)
                                        @php
                                            $artefak_status = 'submitted';
                                        @endphp
                                        <div class="text-success fs-sm"><small><i class="ph-checks"></i> Submitted</small>
                                        </div>
                                    @else
                                        <div class="text-warning fs-sm">
                                            <small>{{ str_replace('sebelumnya', 'lagi', Carbon\Carbon::now()->diffForHumans($s->deadline)) }}</small>
                                        </div>
                                    @endif
                                </div>
                                <div class="ms-auto">
                                    <a href="#"
                                        class="navbar-nav-link navbar-nav-link-icon bg-primary bg-opacity-10 rounded-pill p-2 upload_btn"
                                        data-bs-toggle="modal" data-bs-target="#modal_artefak{{ $s->id }}">
                                        <i
                                            class="{{ $artefak != null ? 'ph-warning-circle' : 'ph-upload' }} fs-sm fw-semibold text-primary"></i>
                                        {{-- <span
                                    class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">2</span>
                                --}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profil photo modal -->
                    <div id="modal_artefak{{ $s->id }}" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="ph-warning-circle text-info"></i>&nbsp;Submission
                                        Artefak
                                        {{ $s->deskripsi }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div>
                                        <table class="table fs-sm fw-semibold">
                                            <tr>
                                                <td colspan="3">
                                                    <h5>Submission status</h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="40">Deskripsi</td>
                                                <td>{{ $s->deskripsi }}</td>
                                            </tr>
                                            <tr>
                                                <td>Deadline</td>
                                                <td>{{ $s->deadline }}</td>
                                            </tr>
                                            @php
                                                if ($artefak) {
                                                    if (
                                                        \Carbon\Carbon::parse($s->deadline) >
                                                        \Carbon\Carbon::parse(
                                                            $artefak
                                                                ? $s->artefak_kelompok
                                                                    ->where('kelompoks_id', $kelompok->id)
                                                                    ->where('submission_id', $s->id)
                                                                    ->first()->created_at
                                                                : Carbon\Carbon::now(),
                                                        )
                                                    ) {
                                                        $ontime = true;
                                                    } else {
                                                        $ontime = null;
                                                    }
                                                }
                                            @endphp
                                            @if ($artefak)
                                                <tr>'
                                                    <td>Waktu submit</td>
                                                    <td>{{ \Carbon\Carbon::parse(
                                                        $artefak ? $s->artefak_kelompok->where('kelompoks_id', $kelompok->id)->first()->created_at : '',
                                                    ) }}
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>Status</td>
                                                    <td
                                                        class="{{ $ontime ? 'text-success bg-success bg-opacity-10' : 'text-danger bg-danger bg-opacity-10' }}">
                                                        @if ($ontime)
                                                            Tepat waktu
                                                        @else

                                                            Terlambat
                                                            @php
                                                            $terlambat =
                                                            Carbon\Carbon::parse($artefak->created_at)->diff(Carbon\Carbon::parse($s->deadline));
                                                            @endphp
                                                            <small>({{ $terlambat->days . ' Hari ' }}
                                                                {{ $terlambat->h . ' jam ' }}
                                                                {{ $terlambat->i . ' menit ' }}
                                                                {{ $terlambat->s . ' detik ' }})</small>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Dokumen</td>
                                                    <td class="bg-primary bg-opacity-10 ">
                                                        <a href="{{ asset('storage/artefaks/' . $artefak->folder . '/' . $artefak->file) }}"
                                                            download><i class="ph-file"></i> {{ $artefak->file }}</a>
                                                    </td>
                                                </tr>
                                            @endif

                                        </table>
                                    </div><br>
                                    {{-- <form action="/artefak/file/temporary/store" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file">
                                <button class="submit">submit</button>
                            </form> --}}
                                    @role('mahasiswa')
                                        @if (!$artefak)
                                            <form action="/kelompok/{{ $kelompok->id }}/artefak/{{ $s->id }}"
                                                method="post" class="{{ $s->id }}" id="form-file"
                                                enctype="multipart/form-data">
                                                @csrf
                                                {{-- /users/{{Auth::user()->id}}/profile/image --}}
                                                {{-- <input type="hidden" name="submission_id" value="{{$}}">
                                <input type="hidden"> --}}

                                                <input type="file" name="file" class="input_file">
                                        @endif
                                    @endrole

                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    @role('mahasiswa')
                                        @if (!$artefak)
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                            </form>
                                        @else
                                            <div class="nav-item">
                                                <button href="" class="btn btn-danger dropdown-toggle"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ph-trash"></i> &nbsp; Hapus submission</button>
                                                <div class="dropdown-menu">
                                                    <form
                                                        action="/kelompok/{{ $kelompok->id }}/artefak/{{ $s->id }}/{{ $artefak->id }}/delete"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{ $artefak->file }}" name="file">
                                                        <input type="hidden" value="{{ $artefak->folder }}" name="folder">
                                                        <div class="container">
                                                            <i>Apakah anda yakin ingin menghapus submission anda?</i>
                                                            <button class="badge border-0 bg-success" type="submit">
                                                                ya</button>
                                                            <button class="badge border-0 bg-secondary" type="button">
                                                                batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    @endrole

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Profil photo modal -->
                    @php
                        $ontime = '';
                    @endphp
                @endforeach

            </div>
        </div>
    </div>



    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-rename/dist/filepond-plugin-file-rename.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>


    <script>
        var submission_id = document.getElementById('form-file').className;
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileRename);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        // Get a reference to the file input element
        const inputElements = document.querySelectorAll('.input_file');
        inputElements.forEach((inputElement) => {
            const pond = FilePond.create(inputElement);

            FilePond.setOptions({
                acceptedFileTypes: ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                server: {
                    url: '{{ URL::to('/') }}/artefak/file/temporary',
                    process: '/store',
                    revert: {
                        url: '/delete',
                        method: 'POST',
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });

        })

        // Create a FilePond instance
    </script>

@endsection
