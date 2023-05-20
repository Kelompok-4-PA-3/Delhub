		<!-- Page header -->
        <div class="page-header page-header-light shadow">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        @if(isset($title))
                            {!! $title !!}
                        @else
                            Dashboards
                        @endif
                         {{-- <span class="fw-normal">Dashboards</span> --}}
                    </h4>

                    <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

                <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                    {{-- <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                        <div class="dropdown w-100 w-sm-auto">
                            <a href="#" class="d-flex align-items-center text-body lh-1 dropdown-toggle py-sm-2" data-bs-toggle="dropdown" data-bs-display="static">
                                <img src="https://demo.interface.club/limitless/demo/template/assets/images/brands/tesla.svg" class="w-32px h-32px me-2" alt="">
                                <div class="me-auto me-lg-1">
                                    <div class="fs-sm text-muted mb-1">Customer</div>
                                    <div class="fw-semibold">Tesla Motors Inc</div>
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-lg-end w-100 w-lg-auto wmin-300 wmin-sm-350 pt-0">
                                <div class="d-flex align-items-center p-3">
                                    <h6 class="fw-semibold mb-0">Customers</h6>
                                    <a href="#" class="ms-auto">
                                        View all
                                        <i class="ph-arrow-circle-right ms-1"></i>
                                    </a>
                                </div>
                                <a href="#" class="dropdown-item active py-2">
                                    <img src="https://demo.interface.club/limitless/demo/template/assets/images/brands/tesla.svg" class="w-32px h-32px me-2" alt="">
                                    <div>
                                        <div class="fw-semibold">Tesla Motors Inc</div>
                                        <div class="fs-sm text-muted">42 users</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item py-2">
                                    <img src="https://demo.interface.club/limitless/demo/template/assets/images/brands/debijenkorf.svg" class="w-32px h-32px me-2" alt="">
                                    <div>
                                        <div class="fw-semibold">De Bijenkorf</div>
                                        <div class="fs-sm text-muted">49 users</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item py-2">
                                    <img src="https://demo.interface.club/limitless/demo/template/assets/images/brands/klm.svg" class="w-32px h-32px me-2" alt="">
                                    <div>
                                        <div class="fw-semibold">Royal Dutch Airlines</div>
                                        <div class="fs-sm text-muted">18 users</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item py-2">
                                    <img src="https://demo.interface.club/limitless/demo/template/assets/images/brands/shell.svg" class="w-32px h-32px me-2" alt="">
                                    <div>
                                        <div class="fw-semibold">Royal Dutch Shell</div>
                                        <div class="fs-sm text-muted">54 users</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item py-2">
                                    <img src="https://demo.interface.club/limitless/demo/template/assets/images/brands/bp.svg" class="w-32px h-32px me-2" alt="">
                                    <div>
                                        <div class="fw-semibold">BP plc</div>
                                        <div class="fs-sm text-muted">23 users</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="vr d-none d-sm-block flex-shrink-0 my-2 mx-3"></div>

                        <div class="d-inline-flex mt-3 mt-sm-0">
                            <a href="#" class="status-indicator-container ms-1">
                                <img src="../../../assets/images/demo/users/face24.jpg" class="w-32px h-32px rounded-pill" alt="">
                                <span class="status-indicator bg-warning"></span>
                            </a>
                            <a href="#" class="status-indicator-container ms-1">
                                <img src="../../../assets/images/demo/users/face1.jpg" class="w-32px h-32px rounded-pill" alt="">
                                <span class="status-indicator bg-success"></span>
                            </a>
                            <a href="#" class="status-indicator-container ms-1">
                                <img src="../../../assets/images/demo/users/face3.jpg" class="w-32px h-32px rounded-pill" alt="">
                                <span class="status-indicator bg-danger"></span>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-icon w-32px h-32px rounded-pill ms-3">
                                <i class="ph-plus"></i>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="page-header-content d-lg-flex border-top">
                <div class="d-flex">
                    
                    <div class="page-header-content border-top py-2">
                    	<div class="breadcrumb breadcrumb-arrows">
                            @yield('breadscrumb')
                    	</div>
                    </div>

                    {{-- <div class="py-2">
                        @yield('breadscrumb')
                    </div> --}}

                    {{-- <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a> --}}
                </div>

                {{-- <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
                    <div class="d-lg-flex mb-2 mb-lg-0">
                        <a href="#" class="d-flex align-items-center text-body py-2">
                            <i class="ph-lifebuoy me-2"></i>
                            Support
                        </a>

                        <div class="dropdown ms-lg-3">
                            <a href="#" class="d-flex align-items-center text-body dropdown-toggle py-2" data-bs-toggle="dropdown">
                                <i class="ph-gear me-2"></i>
                                <span class="flex-1">Settings</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end w-100 w-lg-auto">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-shield-warning me-2"></i>
                                    Account security
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-chart-bar me-2"></i>
                                    Analytics
                                </a>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-lock-key me-2"></i>
                                    Privacy
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                    <i class="ph-gear me-2"></i>
                                    All settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <!-- /page header -->
