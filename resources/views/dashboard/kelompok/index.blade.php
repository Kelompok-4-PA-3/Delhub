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
    <script src="../../../assets/js/vendor/ui/fab.min.js"></script>
	<script src="../../../assets/js/vendor/ui/prism.min.js"></script>
	<script src="../../../assets/demo/pages/extra_fab.js"></script>
    {{-- <script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script> --}}
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="row">

        <div class="mb-2">
            <ul class="nav nav-tabs nav-tabs-highlight nav-justified wmin-lg-100 me-lg-3 mb-3 mb-lg-0">
                <li class="nav-item"><a href="dash" class="nav-link {{ (request()->is('/kelompok')) ? 'active' : '' }}"> <i class="ph-squares-four"></i> &nbsp; Kelompok</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Artefak</a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="ph-folders"></i> &nbsp; Manajemen</a></li>
                <li class="nav-item"><a href="#" class="nav-link {{ (request()->is('/kelompok/orang')) ? 'active' : '' }}"> <i class="ph-folders"></i> &nbsp; Tugas</a></li>
                <li class="nav-item"><a href="/kelompok" class="nav-link  active"> <i class="ph-users"></i> &nbsp; Orang</a></li>
            </ul>
        </div>

        <div class="card">
            <table class="table datatable-people"">
                <thead class="">
                    <tr class="">
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
                    <td><div class="container"><input type="checkbox" class="form-check-input"></div></td>
                    <td>
                        <div class="d-flex">
                            <div class="px-2">
                                <img src="../../../assets/images/demo/users/face11.jpg" class="w-32px h-32px rounded-pill" alt="">
                            </div>
                           <div>
                                <a class="fw-semibold" href="">Rizki Okto S</a><br>
                                <small class="text-muted">Leader</small>
                           </div>
                        </div>
                    </td>
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
                   </tr>
                </tbody>
            </table>
        </div>

		<table class="table datatable-basic">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Job Title</th>
					<th>DOB</th>
					<th>Status</th>
					<th class="text-center">Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Marth</td>
					<td><a href="#">Enright</a></td>
					<td>Traffic Court Referee</td>
					<td>22 Jun 1972</td>
					<td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Jackelyn</td>
					<td>Weible</td>
					<td><a href="#">Airline Transport Pilot</a></td>
					<td>3 Oct 1981</td>
					<td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Aura</td>
					<td>Hard</td>
					<td>Business Services Sales Representative</td>
					<td>19 Apr 1969</td>
					<td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Nathalie</td>
					<td><a href="#">Pretty</a></td>
					<td>Drywall Stripper</td>
					<td>13 Dec 1977</td>
					<td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Sharan</td>
					<td>Leland</td>
					<td>Aviation Tactical Readiness Officer</td>
					<td>30 Dec 1991</td>
					<td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Maxine</td>
					<td><a href="#">Woldt</a></td>
					<td><a href="#">Business Services Sales Representative</a></td>
					<td>17 Oct 1987</td>
					<td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Sylvia</td>
					<td><a href="#">Mcgaughy</a></td>
					<td>Hemodialysis Technician</td>
					<td>11 Nov 1983</td>
					<td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Lizzee</td>
					<td><a href="#">Goodlow</a></td>
					<td>Technical Services Librarian</td>
					<td>1 Nov 1961</td>
					<td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Kennedy</td>
					<td>Haley</td>
					<td>Senior Marketing Designer</td>
					<td>18 Dec 1960</td>
					<td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Chantal</td>
					<td><a href="#">Nailor</a></td>
					<td>Technical Services Librarian</td>
					<td>10 Jan 1980</td>
					<td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Delma</td>
					<td>Bonds</td>
					<td>Lead Brand Manager</td>
					<td>21 Dec 1968</td>
					<td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Roland</td>
					<td>Salmos</td>
					<td><a href="#">Senior Program Developer</a></td>
					<td>5 Jun 1986</td>
					<td><span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Coy</td>
					<td>Wollard</td>
					<td>Customer Service Operator</td>
					<td>12 Oct 1982</td>
					<td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Maxwell</td>
					<td>Maben</td>
					<td>Regional Representative</td>
					<td>25 Feb 1988</td>
					<td><span class="badge bg-danger bg-opacity-10 text-danger">Suspended</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
				<tr>
					<td>Cicely</td>
					<td>Sigler</td>
					<td><a href="#">Senior Research Officer</a></td>
					<td>15 Mar 1960</td>
					<td><span class="badge bg-info bg-opacity-10 text-info">Pending</span></td>
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
										<i class="ph-file-xls me-2"></i>
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
				</tr>
			</tbody>
		</table>

    </div>

@endsection

@section('right-sidebar')
 <!-- Right sidebar -->
		<div class="sidebar sidebar-end sidebar-expand-lg sidebar-collapsed">

			<!-- Expand button -->
			<button type="button" class="btn btn-sidebar-expand sidebar-control sidebar-end-toggle h-100">
				<i class="ph-caret-left"></i>
			</button>
			<!-- /expand button -->


			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- Header -->
				<div class="sidebar-section sidebar-section-body d-flex align-items-center pb-2">
					<h5 class="mb-0">Sidebar</h5>
					<div class="ms-auto">
						<button type="button" class="btn btn-light border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-end-toggle d-none d-lg-inline-flex">
							<i class="ph-arrows-left-right"></i>
						</button>

						<button type="button" class="btn btn-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-end-toggle d-lg-none">
							<i class="ph-x"></i>
						</button>
					</div>
				</div>
				<!-- /header -->

				<!-- Sub navigation -->
				<div class="sidebar-section">
					<div class="sidebar-section-header border-bottom">
						<span class="fw-semibold">Navigation</span>
						<div class="ms-auto">
	                		<a href="#sidebar-navigation" class="text-reset" data-bs-toggle="collapse">
								<i class="ph-caret-down collapsible-indicator"></i>
	                		</a>
	                	</div>
					</div>

					<div class="collapse show" id="sidebar-navigation">
						<ul class="nav nav-sidebar mt-2" data-nav-type="accordion">
							<li class="nav-item-header opacity-50">Actions</li>
							<li class="nav-item">
                                <div class="btn-group">
                                    <a href="#" class="nav-link" data-bs-toggle="dropdown">
                                        <i class="ph-users-three me-2"></i>
                                        Buat kelompok
                                    </a>
                                </div>

							</li>
							<li class="nav-item">
								<a href="/kelompok" class="nav-link">
									<i class="ph-plus-circle me-2"></i>
									Create task
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="ph-circles-three-plus me-2"></i>
									Create project
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="ph-pencil me-2"></i>
									Edit task list
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="ph-user-plus me-2"></i>
									Assign users
									<span class="badge bg-primary rounded-pill ms-auto">94 online</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- /sub navigation -->


				<!-- Online users -->
				<div class="sidebar-section">
					<div class="sidebar-section-header border-bottom">
						<span class="fw-semibold">Mahasiswa</span>
						<div class="ms-auto">
	                		<a href="#sidebar-users" class="text-reset" data-bs-toggle="collapse">
								<i class="ph-caret-down collapsible-indicator"></i>
	                		</a>
	                	</div>
					</div>

					<div class="collapse show" id="sidebar-users">
						<div class="sidebar-section-body">
						</div>
					</div>
				</div>
				<!-- /online users -->

			</div>
			<!-- /sidebar content -->

		</div>
		<!-- /right sidebar -->

		<script>
			var element = document.querySelector('.dataTables_scrollBody');
			console.log(element)
        </script>


		
@endsection