@extends('main')

@section('title')
    <title>Manajemen Poin Regulasis</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="../../../assets/js/vendor/editors/ckeditor/ckeditor_classic.js"></script>
	<script src="../../../assets/demo/pages/editor_ckeditor_classic.js"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <link href="../../../assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">

@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Komponen Penilaian {{$title}}</h5>
            <div class="ms-auto d-flex">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#tambah_komponen_penilaian"><i class="ph-plus-circle"></i>&nbsp; TAMBAH KOMPONEN PENILAIAN</a>
                </label>
            </div>
        </div>

        <div class="card-body pb-0">

            @if (session()->has('success'))
                <div class="alert alert-success alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-success text-white">
                        <i class="ph-check-circle"></i>
                    </span>
                    <span class="fw-semibold">Berhasil!</span> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif(session()->has('failed'))
                <div class="alert alert-danger alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-danger text-white">
                        <i class="ph-check-circle"></i>
                    </span>
                    <span class="fw-semibold">Gagal!</span> {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- /individual column searching (text inputs) -->
            <table class="table datatable-users w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Komponen Penilaian</th>
                        <th>Bobot</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Komponen Penilaian</th>
                        <th>Bobot</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($komponen as $kp)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{!! $kp->komponen_penilaian !!}</td>
                            <td class="text-center">{{ $kp->bobot }} %</td>
                            <td class="text-center">
                               @if ($kp->is_verified)
                                    <span class="badge p-2 bg-success rounded-pill bg-opacity-10 text-success">sudah diverifikasi</span>
                             @else
                                    <span class="badge p-2 bg-danger rounded-pill bg-opacity-10 text-danger">belum diverifikasi</span>
                             @endif
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah"
                                        data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $kp->id }}">
                                        <i class="ph-pen"></i>
                                    </a>
                                    <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                        data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $kp->id }}">
                                        <i class="ph-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div id="modal_hapus{{ $kp->id }}" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-xs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Apakah anda yakin ingin menghapus data <span
                                            class="fw-semibold">{{ $kp->nama }}</span> ?
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <form action="/poin_regulasi/{{$poin_regulasi->id}}/{{$kp->id}}/delete" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Ya</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Delete Modal -->

                        <!-- Sticky footer -->
                          <!-- Large panel -->
                            <div id="form-edit{{$kp->id}}" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title fw-semibold">Edit Komponen Penilaian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>

                                <div class="offcanvas-body p-2">
                                    <form action="/poin_regulasi/{{$poin_regulasi->id}}/{{$kp->id}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <div class="mt-2">
                                                    <label class="form-label">Komponen Penilaian</label>
                                                    {{-- <input type="hidden" value="" name=""> --}}
                                                    <textarea class="form-control" id="ckeditor_classic_edit{{$kp->id}}" name="komponen_penilaian" placeholder="Masukkan komponen penilaian anda disini..." required>{{old('komponen_penilaian',$kp->komponen_penilaian)}}</textarea>
                                                    @error('komponen_penilaian')
                                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mt-2">
                                                    <label class="form-label">Komponen Penilaian</label>
                                                    <div class="form-control-feedback form-control-feedback-end mb-3">
                                                        <input type="number" class="form-control" value="{{old('bobot',$kp->bobot)}}" name="bobot" placeholder="Masukkan bobot penilaian anda disini..." step="0.01" min="0" max="100">
                                                        <div class="form-control-feedback-icon">
                                                            <i class="ph-percent ph-sm"></i>
                                                        </div>
                                                    </div>
                                                    @error('komponen_penilaian')
                                                        <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                {{-- <div class="form-control-feedback form-control-feedback-end mb-3">
                                                    <input type="text" class="form-control" placeholder="Right icon, input default">
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-at"></i>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="border-top p-3">
                                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <!-- /large panel -->
                        <!-- /sticky footer -->
                        

                        <script>
                            // Initialize first editor instance with custom configuration options
                            CKEDITOR.replace('ckeditor_classic_edit{{$kp->id}}', {
                                toolbar: 'Basic'
                            });
                        </script>

                    @endforeach
                </tbody>
            </table>
            <br>
            @if ($komponen->where('is_verified',false)->count())
                <div style="position:relative">
                    <div class="d-flex p-1">
                        <form action="/poin_regulasi/{{$poin_regulasi->id}}/komponen_penilaian/verifikasi" class="ms-auto" method="post">
                            @csrf
                            <button class=" btn btn-sm btn-success" type="submit"><i class="ph-upload"></i>&nbsp;<i class="fw-semibold"> VERIFIKASI SELURUH KOMPONEN PENILAIAN</i> &nbsp;<span class="bg-danger px-1 fw-semibold">{{$komponen->where('is_verified',false)->count()}}</span></butt>
                        </form>
                    </div>
                </div>
            @endif
            <br>
        </div>
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>


    <!-- Large panel -->
	<div id="tambah_komponen_penilaian" class="offcanvas offcanvas-end offcanvas-size-lg" tabindex="-1">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title fw-semibold">Tambah Komponen Penilaian</h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>

		<div class="offcanvas-body p-2">
            <form action="/poin_regulasi/{{$poin_regulasi->id}}/komponen_penilaian" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="mt-2">
                            <label class="form-label">Komponen Penilaian</label>
                            {{-- <input type="hidden" value="" name=""> --}}
                            <textarea class="form-control" id="ckeditor_classic_empty" name="komponen_penilaian" placeholder="Masukkan komponen penilaian anda disini..."></textarea>
                            @error('komponen_penilaian')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Komponen Penilaian</label>
                            <div class="form-control-feedback form-control-feedback-end mb-3">
                                <input type="number" class="form-control" name="bobot" placeholder="Masukkan bobot penilaian anda disini..." step="0.01" min="0" max="100">
                                <div class="form-control-feedback-icon">
                                    <i class="ph-percent ph-sm"></i>
                                </div>
                                
                            </div>
                            @error('komponen_penilaian')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="form-control-feedback form-control-feedback-end mb-3">
                            <input type="text" class="form-control" placeholder="Right icon, input default">
                            <div class="form-control-feedback-icon">
                                <i class="ph-at"></i>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="border-top p-3">
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </div>
            </form>
		</div>
	</div>
	<!-- /large panel -->
    {{-- <style>
        .verification-area{
            top: 80;
            right: 20;
            position: absolute;
            position: fixed
        }

        .verification-button{
            background-color: #F1C40F;
            width: 50px;
            height: 50px;
            border-radius: 100%;
            box-shadow: rgba(244, 230, 40, 0.745) 0px 4px 6px -1px, rgba(255, 196, 32, 0.06) 0px 2px 4px -1px;
            transition: 0.3s;
        }

        .verification-button:hover{ 
            transform: scale(1.05);
        }
    </style>
    <div class="verification-area d-flex">
       <div class="card p-1 mt-1 me-1">
            <i>Terdapat beberapa komponen penilaian yang belum diverifikasi,<br> silahkan verifikasi ulang komponen penilaian agar dapat digunakan pada penilaian</i>
       </div>
       <div class="verification-button"  data-bs-popup="tooltip" title="Terdapat beberapa komponen penilaian yang belum diverifikasi, silahkan verifikasi ulang komponen penilaian agar dapat digunakan pada penilaian">
            <h1 class="text-center"> <button class="bg-transparent border-0 fw-bold">!</button></h1>
       </div>
    </div> --}}

    @if($komponen->where('is_verified', false)->count() > 0)
     <!-- Top panel -->
	<div id="panel_top" class="offcanvas offcanvas-top show" tabindex="-1">
		<div class="offcanvas-body">
            <div>
                <h3>Pemberitahuan : </h3>
            </div>
			<div class="d-lg-flex">
				<span class="flex-lg-1 me-lg-3">
                    Sepertinya terdapat komponen penilaian yang belum diverifikasi atau telah dihapus, silahkan verifikasi ulang seluruh komponen penilaian agar dapat digunakan pada fitur penilaian.
                    <br><i>Note : Pastikan jumlah seluruh bobot tepat 100%</i>
                </span>
                {{-- <i>Note : Pastikan jumlah seluruh bobot tepat 100%</i> --}}
				<div class="ms-lg-auto mt-3 mt-lg-auto mb-lg-auto flex-nowrap">
                     <form action="/poin_regulasi/{{$poin_regulasi->id}}/komponen_penilaian/verifikasi" class="ms-auto" method="post">
                            @csrf
                            <button class=" btn btn-sm btn-success" type="submit"><i class="ph-upload"></i>&nbsp;<i class="fw-semibold"> VERIFIKASI </i> &nbsp;<span class="bg-danger px-1 fw-semibold">{{$komponen->where('is_verified',false)->count()}}</span></button>
					        <button type="button" class="btn btn-link ms-2" data-bs-dismiss="offcanvas">Nanti</button>
                    </form>
				</div>
			</div>
		</div>
	</div>
	<!-- /top panel -->
    @endif
   
@endsection
