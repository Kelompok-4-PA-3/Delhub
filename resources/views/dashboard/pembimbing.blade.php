@extends('main')
   
@section('title')
    <title>Manajemen Mahasiswa</title>
@endsection

@push('datatable_js')
	<script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
    {{-- <script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script> --}}
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')

	<style>
		.datatable-header {
			display: none;
		}

		.datatable-footer{
			display: none;
		}
	</style>

    <div class="row">
        <div class="col-xl-7">

            <!-- Traffic sources -->
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Daftar Kelompok</h5>
                    <div class="ms-auto">
                        <label class="form-check form-switch form-check-reverse">
                            <input type="checkbox" class="form-check-input" checked>
                            <span class="form-check-label">Live update</span>
                        </label>
                    </div>
                </div>

                <div class="card-body pb-0">
                    <div class="project-list">
						@if($kelompok->count() > 0)
						@foreach($kelompok as $k)
                        <div class="p-1">
                            <div class="d-flex mb-2">
                                <a href="#" class="bg-info bg-opacity-10 text-info lh-1 rounded-pill p-2 me-3">
                                    <i class="ph-users-four"></i>
                                </a>
                                <div>
                                    <div class="fw-semibold">
                                        <a href="/kelompok/{{$k->id}}">{{$k->nama_kelompok}}</a>
                                    </div>
									@if ($k->topik != NULL)
										<span class="text-muted" data-bs-popup="tooltip" title="{{$k->topik}}">{{ Str::limit ($k->topik, 30) }}</span>
									@else
										<small class="text-nowrap text-warning"><i class="ph-warning-circle"></i> Belum ada topik </small>
									@endif
                                </div>
                            </div>
                            <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                        </div>
						@endforeach
						@else
							<p class="text-muted text-center">Belum ada kelompok</p>
						@endif
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

