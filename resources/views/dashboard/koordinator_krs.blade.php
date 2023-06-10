@extends('main')
   
@section('title')
    <title>Koordinator - My Course</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
    {{-- <script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script> --}}
@endpush

@section('breadscrumb')
    <span class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</span>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-7">

            <!-- Traffic sources -->
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Proyek saya </h5>
                    <div class="ms-auto">
                        <label class="form-check form-switch form-check-reverse">
                            <i class="ph-circle-wavy-warning text-primary"></i>
                            <span class="form-check-label">On going</span>
                        </label>
                    </div>
                </div>

                <div class="card-body pb-0">
                    <div class="project-list">
                        @if ($krs->count() > 0)
                            @foreach ($krs as $k)
                                @if ($k->config->active)
                                    <div class="p-1">
                                        <div class="d-flex mb-2">
                                            <a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                                                <i class="ph-notepad"></i>
                                            </a>
                                            <div>
                                                <div class="fw-semibold">
                                                    <a href="/koordinator/proyeksaya/{{$k->id}}">{{$k->kategori->nama_mk}}</a>
                                                </div>
                                                <span class="text-muted">{{$k->dosen->user->nama}} | {{$k->dosen->nidn}} </span><br>
                                                <span class="text-muted">{{$k->dosen2->user->nama}} | {{$k->dosen2->nidn}} </span>
                                            </div>
                                        </div>
                                        <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                                    </div>
                                @endif
                            @endforeach
                        @else 
                            <h3 class="text-secondary text-center">Anda belum memiliki proyek sebagai koordinator</h3>
                        @endif

                        {{-- <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-warning bg-opacity-10 text-warning lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-projector-screen-chart"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="">TA-II-D4-TRPL-20</a>
                                    </div>
                                    <span class="text-muted">Penguji - Kelompok 4</span>
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                        </div>

                        <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-users-three"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="">KP-D4TRPL-2022</a>
                                    </div>
                                    <span class="text-muted">Pembimbing - Rosa Kopeng</span>
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="total-online"></div>
                        </div> --}}
                    </div>
                </div>

                <div class="chart position-relative" id="traffic-sources"></div>
            </div>
            <!-- /traffic sources -->

        </div>

        <div class="col-xl-5">
          {{-- <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">Pengumuman</h5>
                <div class="ms-auto">
                    <label class="form-check form-switch form-check-reverse">
                        <i class="ph-circle-wavy-warning text-primary"></i>
                        <span class="form-check-label">On going</span>
                    </label>
                </div>
            </div>
          </div>
        </div> --}}
    </div>

    <div class="row">
        <div class="col-xl-7">

            <!-- Traffic sources -->
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Proyek saya</h5>
                    <div class="ms-auto">
                        <label class="form-check form-switch form-check-reverse">
                            <i class="ph-circle-wavy-check text-success"></i>
                            <span class="form-check-label">Done</span>
                        </label>
                    </div>
                </div>

                <div class="card-body pb-0">
                    <div class="project-list">
                        @if ($krs->count() > 0)
                            @foreach ($krs as $k)
                                @if (!$k->config->active)
                                    <div class="p-1">
                                        <div class="d-flex mb-2">
                                            <a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                                                <i class="ph-notepad"></i>
                                            </a>
                                            <div>
                                                <div class="fw-semibold">
                                                    <a href="/koordinator/proyeksaya/{{$k->id}}">{{$k->kategori->nama_mk}}</a>
                                                </div>
                                                <span class="text-muted">{{$k->dosen->user->nama}} | {{$k->dosen->nidn}} </span><br>
                                                <span class="text-muted">{{$k->dosen2->user->nama}} | {{$k->dosen2->nidn}} </span>
                                            </div>
                                        </div>
                                        <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                                    </div>
                                @endif
                            @endforeach
                        @else 
                            <h3 class="text-secondary text-center">Anda belum memiliki proyek sebagai koordinator</h3>
                        @endif
                        {{-- <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-notepad"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="">PA3-D4TRPL-2020</a>
                                    </div>
                                    <span class="text-muted">Koordinator</span>
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                        </div> --}}

                        {{-- <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-warning bg-opacity-10 text-warning lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-projector-screen-chart"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="">TA-II-D4-TRPL-20</a>
                                    </div>
                                    <span class="text-muted">Penguji - Kelompok 4</span>
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                        </div> --}}

                        {{-- <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-users-three"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="">KP-D4TRPL-2022</a>
                                    </div>
                                    <span class="text-muted">Pembimbing - Rosa Kopeng</span>
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="total-online"></div>
                        </div> --}}
                    </div>
                </div>
            </div>
                <div class="chart position-relative" id="traffic-sources"></div>
            </div>
            <!-- /traffic sources -->

        </div>

        <div class="col-xl-5">

        </div>
    </div>


@endsection
