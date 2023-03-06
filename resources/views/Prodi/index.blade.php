@extends('main')

@section('content')

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<!-- Theme JS files -->
	<script src="../../../assets/js/jquery/jquery.min.js"></script>
	<script src="../../../assets/js/vendor/tables/datatables/datatables.min.js"></script>
	<script src="../../../assets/demo/pages/datatables_api.js"></script>
	<!-- /theme JS files -->
    <style type="text/css">
    #f{
        float:right;
        margin:5px
    }
  </style>
</head>
<body>
	<!-- Individual column searching (selects) -->
    <div class="card">
						<div class="card-header">
							<h5 class="mb-0">Kelola Program Studi</h5>
						</div>
                        <div>
                        <br>
                        <a href="{{ route('prodi.create') }}" class="btn btn-md btn-primary mb-3" id="f">TAMBAH PRODI</a>
                        </div>
						<table class="table datatable-column-search-selects">
							<thead>
								<tr>
					                <th>NO</th>
					                <th>PROGRAM STUDI</th>
					                <th>FAKULTAS</th>
					                <th>STATUS</th>
					                <th>KET</th>
					            </tr>
								<tr class="filters">
                                    <th>NO</th>
					                <th>PROGRAM STUDI</th>
					                <th>FAKULTAS</th>
					                <th>STATUS</th>
					                <th></th>
					            </tr>
							</thead>

							<tbody>
                            @forelse ($prodis as $prodi)
								<tr>
					                <td>{{ $loop->iteration }}</td>
					                <td>{{ $prodi->nama }}</td>
					                <td>{!! $prodi->fakultas->nama !!}</td>
					                <td>{!! $prodi->status !!}</td>
                                    <td class="text-center">
										<div class="d-inline-flex">
											<div class="dropdown">
												<a href="#" class="text-body" data-bs-toggle="dropdown">
													<i class="ph-list"></i>
												</a>

												<div class="dropdown-menu dropdown-menu-end">
													<a href="#" class="dropdown-item">
														<i class="ph-file-pdf me-2"></i>
														Export to .pdf
													</a>
													<a href="#" class="dropdown-item">
														<i class="ph-file-csv me-2"></i>
														Export to .csv
													</a>
													<a href="#" class="dropdown-item">
														<i class="ph-file-doc me-2"></i>
														Export to .doc
													</a>
												</div>
											</div>
										</div>
									</td>
					                <td></td>

					            </tr>
                                @empty

                                @endforelse
							</tbody>
						</table>
					</div>
                    <!-- /individual column searching (selects) -->
</div>
</body>

<!-- Mirrored from demo.interface.club/limitless/demo/template/html/layout_1/full/datatable_api.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 07 Feb 2023 02:58:01 GMT -->
</html>

@endsection
