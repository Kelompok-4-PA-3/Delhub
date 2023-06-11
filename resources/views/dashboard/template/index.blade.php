@extends('main')

@section('title')
<title>Template Document</title>
@endsection

@push('datatable_js')
<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
<script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
<script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{asset('/assets/demo/pages/extra_fab.js')}}"></script>
<script src="{{asset('/assets/js/vendor/uploaders/fileinput/fileinput.min.js')}}"></script>
<script src="{{asset('/assets/js/vendor/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
<script src="{{asset('/assets/demo/pages/uploader_bootstrap.js')}}"></script>
@endpush

@section('breadscrumb')
<a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2"><i class="ph-house me-2"></i>
    Koordinator</a>
<a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2">{{$krs->kategori->nama_singkat}}</a>
<span class="breadcrumb-item py-2">Template Document</span>
@endsection

@section('content')
<div class="card-body pb-0">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Template Dokumen</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a href="#" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas"
                        data-bs-target="#panel_footer"><i class="ph-plus-circle"></i>&nbsp; TAMBAH TEMPLATE DOCUMENT</a>
                </label>
            </div>
        </div>

        <div class="card-body pb-0">
            <table class="table datatable-users">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>File</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Deskripsi</th>
                        <th>File</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($document as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->deskripsi }}</td>
                        <td>
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
                            <a href="{{asset('/storage/public/file-template/'.$d->file_template)}}"
                                class="btn btn-sm bg-secondary bg-opacity-10 text-secondary rounded" download=""><i
                                    class="ph-file-doc"></i>&nbsp; {{Str::limit($d->file_template, 15)}} <span
                                    class="ms-3 fw-semibold"><i class="ph-download"></i> &nbsp;{{$size}}</span></a>
                        </td>
                        <td>
                            @if ($d->is_verified)
                            <span class="px-2 py-1 rounded bg-success bg-opacity-10 text-success fs-sm"><i
                                    class="ph-checks"></i> Diterbitkan</span>
                            @else
                            <span class="px-2 py-1 rounded bg-warning bg-opacity-10 text-warning fs-sm"><i
                                    class="ph-warning"></i> Belum diterbitkan</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah"
                                    data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $d->id }}">
                                    <i class="ph-pen"></i>
                                </a>
                                <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                    data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $d->id }}">
                                    <i class="ph-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Delete Modal -->
                    <div id="modal_hapus{{ $d->id }}" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    Apakah anda yakin ingin menghapus data <span class="fw-semibold">{{
                                        $d->file_template
                                        }}</span> ?
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <form action="/krs/{{$krs->id}}/document/{{$d->id}}/delete" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Ya</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Delete Modal -->

                    <!-- Sticky footer -->
                    <div id="form-edit{{ $d->id }}"
                        class="offcanvas offcanvas-end  {{-- @error('name_edit') show @enderror @error('guard_name_edit') show @enderror"
                        --}} tabindex="-1">
                        {{-- @if ($errors->any()) show @endif --}}
                        <div class="offcanvas-header border-bottom">
                            <h5 class="offcanvas-title fw-semibold">Edit Template Laporan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>

                        <div class="offcanvas-body">
                            <form action="/krs/{{$krs->id}}/document/{{$d->id}}/edit" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <div class="mb-2">
                                            <label class="form-label">Deskripsi</label>
                                            <input type="text" name="deskripsi"
                                                value="{{ old('deskripsi',$d->deskripsi) }}" class="form-control"
                                                required placeholder="Masukkan deskripsi disini">
                                            @error('deskripsi')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{
                                                $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Template document</label>
                                            {{-- <form action="/krs/{{$krs->id}}/document" method="post"
                                                enctype="multipart/form-data"> --}}
                                                {{-- @csrf --}}
                                                <div class="card-body">
                                                    <a href="{{asset('/storage/public/file-template/'.$d->file_template)}}"
                                                        class="btn btn-sm bg-secondary bg-opacity-10 text-secondary rounded py-1"
                                                        download=""><i class="ph-file-doc"></i>&nbsp;
                                                        {{Str::limit($d->file_template, 15)}} <span
                                                            class="ms-3 fw-semibold"><i class="ph-download"></i>
                                                            &nbsp;{{$size}}</span></a>
                                                    <input type="hidden" name="old_file" value="{{$d->file_template}}">
                                                    {{-- <p class="fw-semibold">Seret file pada area</p> --}}
                                                    <br><br>
                                                    <input type="file" class="form-control" name="file_template"
                                                        value="{{$d->file_template}}">
                                                </div>
                                                {{--
                                            </form> --}}
                                            @error('file_template')
                                            <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{
                                                $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="border-top p-3">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                        </form>
                    </div>
                    <!-- /sticky footer -->
                    @endforeach
                </tbody>
            </table>
            @if ($document->count() > 0)
            <div class="d-flex mt-2">
                <div class="ms-auto">
                    <form action="/krs/{{$krs->id}}/document/publish" enctype="multipart/form-data" method="post">
                        @csrf
                        <button class="btn btn-sm btn-success fw-semibold" type="submit"><i class="ph-upload"></i>&nbsp;
                            Terbitkan template dokumen</button>
                    </form>
                </div>
            </div>
            @endif

            <br>
        </div>
        <!-- /individual column searching (text inputs) -->


        <!-- Sticky footer -->
        <div id="panel_footer" class="offcanvas offcanvas-end  " tabindex="-1">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title fw-semibold">Tambah Template Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body">
                <form action="/krs/{{$krs->id}}/document" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="mb-2">
                                <label class="form-label">Deskripsi</label>
                                <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" class="form-control"
                                    required placeholder="Masukkan deskripsi disini">
                                @error('deskripsi')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Template document</label>
                                <div class="card-body">
                                    <p class="fw-semibold">Seret file pada area</p>
                                    <input type="file" class="file-input" name="file_template">
                                </div>
                                @error('file_template')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
            </div>
            <div class="border-top p-3">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
            </form>
        </div>
        <!-- /sticky footer -->

        <!-- /individual column searching (text inputs) -->
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>

    <div class="chart position-relative" id="traffic-sources"></div>
</div>
<!-- /traffic sources -->

@endsection