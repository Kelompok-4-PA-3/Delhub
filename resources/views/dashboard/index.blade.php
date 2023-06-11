@extends('main')

@section('title')
    <title>Dashboard</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    {{-- <script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script> --}}
@endpush

@section('breadscrumb')
    <span class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Dashboard</span>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-7">

            <!-- Traffic sources -->
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Dashboard</h5>
                    <div class="ms-auto mt-1">
                        <form action="/home" method="get">
                            <div class="d-flex">
                                <select name="kategori_proyek" id="filter-kategori" class="form-control form-control-sm">
                                    <option value="">Pilih kategori proyek</option>
                                    @foreach ($kategori_proyek as $kp)
                                        <option value="{{ $kp->id }}">{{ $kp->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body pb-0">
                    <div class="project-list">

                        @role('dosen')
                            @if (Auth::user()->dosen->all_role_kelompok->count() > 0)
                                <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide p-1">PEKERJAAN SAYA</div>
                                @foreach (Auth::user()->dosen->all_role_kelompok as $role)
                                    @if ($role->role_group->role_kategori->krs != null)
                                        @if (strtolower($role->role_group->nama) != 'koordinator' && $role->role_group->role_kategori->krs->config->active)
                                            <div
                                                class="p-1 dosen_job_list pekerjaan{{ $role->kelompok->krs->kategori ? $role->kelompok->krs->kategori->kategori->id : '' }}">
                                                id="">
                                                <div class="d-flex mb-2">
                                                    <a href="#"
                                                        class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
                                                        <i class="ph-chalkboard-teacher"></i>
                                                    </a>
                                                    <div>
                                                        <div class="fw-semibold">
                                                            <a
                                                                href="/kelompok/{{ $role->kelompok->id }}">{{ $role->kelompok->nama_kelompok }}</a>
                                                        </div>
                                                        <span class="text-muted">{{ $role->role_group->nama }}</span>
                                                        {{-- <span>{{$role->kelompok->krs->kategori->kategori->nama}}</span> --}}
                                                    </div>
                                                </div>
                                                <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                <div class="mb-3">
                                    <small class="text-muted">Anda tidak belum memiliki pekerjaan saat ini!</small>
                                </div>
                            @endif
                        @endrole

                        @role('mahasiswa')
                            @if (Auth::user()->mahasiswa->kelompok_mahasiswas->count() > 0)
                                @foreach (Auth::user()->mahasiswa->kelompok_mahasiswas as $km)
                                    @if ($km->kelompok->krs->config->active)
                                        <div class="p-1">
                                            <div class="d-flex mb-2">
                                                <a href="#"
                                                    class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
                                                    <i class="ph-users-three"></i>
                                                </a>
                                                <div>
                                                    <div class="fw-semibold">
                                                        <a href="/kelompok/{{ $km->kelompok->id }}}">
                                                            {{ $km->kelompok->nama_kelompok }}</a>
                                                    </div>
                                                    <span class="text-muted">{{ $km->kelompok->krs->kategori->nama_mk }}</span>
                                                </div>
                                            </div>
                                            <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="mb-3">
                                    <small class="text-muted">Anda tidak belum memiliki pekerjaan saat ini!</small>
                                </div>
                            @endif
                        @endrole

                        {{-- @foreach ($krs as $k)
                    <div class="p-1">
                        <div class="d-flex mb-2">
                            <a href="#" class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                                <i class="ph-notepad"></i>
                            </a>
                            <div>
                                <div class="fw-semibold">
                                    <a href="/dashboard/{{$k->id}}">{{$k->kategori->nama_mk}}</a>
                                </div>
                                <span class="text-muted">{{$k->dosen->user->nama}}</span>
                            </div>
                        </div>
                        <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                    </div>
                    @endforeach --}}

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

        </div>
    </div>

    <script>
        //   $('#'+'Tugas AKhir').css('padding', '20px');

        $('#filter-kategori').change(function() {
            var selectedValue = $(this).val();
            console.log(selectedValue);
            $('.dosen_job_list').hide();
            if (selectedValue == '') {
                $('.dosen_job_list').show();
            } else {
                $('.pekerjaan' + selectedValue).show();
            }
        });
    </script>

@endsection
