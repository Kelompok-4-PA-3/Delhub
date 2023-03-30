<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('title')

    <!-- Global stylesheets -->
    <link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery/jquery.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    {{-- select js --}}
    @stack('select_js')

    {{-- datatables.js --}}
    @stack('datatable_js')

    <script src="{{asset('/assets/js/vendor/ui/prism.min.js')}}"></script>


    <script src="{{ asset('assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/demo/pages/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"
        integrity="sha256-t0FDfwj/WoMHIBbmFfuOtZv1wtA977QCfsFR3p1K4No=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/method.js') }}"></script>
    <!-- Theme JS files -->


</head>

<body>

    @include('layout.navbar')

    <!-- Page content -->
    <div class="page-content">

        <!-- Main  Sidebar -->
        @include('layout.sidebar')

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                @include('layout.header')

                <!-- Content area -->
                <div class="content">

                    @yield('content')
                    
                </div>
                <!-- /content area -->


                <!-- Footer -->
                <div class="navbar navbar-sm navbar-footer border-top">
                    <div class="container-fluid">
                        <span>&copy; 2022 <a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328">Delhub</a> | Kelompok 4 PA III D4 TRPL 20</span>
                    </div>
                </div>
                <!-- /footer -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

       @yield('right-sidebar')

    </div>
    <!-- /page content -->
    


    <!-- Notifications -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
        <div class="offcanvas-header py-0">
            <h5 class="offcanvas-title py-3">Activity</h5>
            <button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill"
                data-bs-dismiss="offcanvas">
                <i class="ph-x"></i>
            </button>
        </div>

        <div class="offcanvas-body p-0">
            <div class="bg-light fw-medium py-2 px-3">New notifications</div>
            <div class="p-3">
                @if(Auth::user()->dosen()->count() > 0)
                {{-- {{auth()->user()->dosen->kelompok}} --}}
                @foreach(auth()->user()->dosen->kelompok as $dk)
                    {{-- {{$dk->bimbingan}} --}}
                    @foreach($dk->bimbingan as $dkb)
                       @if($dkb->status == 'waiting')
                           <div class="d-flex align-items-start mb-3">
                            <div class="flex-fill">
                                <a href="#" class="fw-semibold">{{$dk->nama_kelompok}}</a> Telah merequest bimbingan untuk anda untuk keperluan "{{$dkb->description}}"
        
                                <div class="my-2">
                                    <a href="/bimbingan/status/approved/{{$dk->id}}" class="btn btn-success btn-sm me-1">
                                        <i class="ph-checks ph-sm me-1"></i>
                                        Approve
                                    </a>
                                    <a href="/kelompok/{{$dk->id}}" class="btn btn-light btn-sm">
                                        Review
                                    </a>
                                </div>
        
                                <div class="fs-sm text-muted mt-1">{{\Carbon\Carbon::parse($dkb->created_at)->diffForHumans()}}</div>
                            </div>
                        </div>
                       @endif
                    @endforeach
                @endforeach
                @endif
            </div>

            {{-- <div class="bg-light fw-medium py-2 px-3">Older notifications</div> --}}
        </div>
    </div>
    <!-- /notifications -->


    <!-- Demo config -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="demo_config">
        <div class="position-absolute top-50 end-100 visible">
            <button type="button" class="btn btn-primary btn-icon translate-middle-y rounded-end-0"
                data-bs-toggle="offcanvas" data-bs-target="#demo_config">
                <i class="ph-gear"></i>
            </button>
        </div>

        <div class="offcanvas-header border-bottom py-0">
            <h5 class="offcanvas-title py-3">Demo configuration</h5>
            <button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill"
                data-bs-dismiss="offcanvas">
                <i class="ph-x"></i>
            </button>
        </div>

        <div class="offcanvas-body">
            <div class="fw-semibold mb-2">Color mode</div>
            <div class="list-group mb-3">
                <label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
                    <div class="d-flex flex-fill my-1">
                        <div class="form-check-label d-flex me-2">
                            <i class="ph-sun ph-lg me-3"></i>
                            <div>
                                <span class="fw-bold">Light theme</span>
                                <div class="fs-sm text-muted">Set light theme or reset to default</div>
                            </div>
                        </div>
                        <input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme"
                            value="light" checked>
                    </div>
                </label>

                <label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
                    <div class="d-flex flex-fill my-1">
                        <div class="form-check-label d-flex me-2">
                            <i class="ph-moon ph-lg me-3"></i>
                            <div>
                                <span class="fw-bold">Dark theme</span>
                                <div class="fs-sm text-muted">Switch to dark theme</div>
                            </div>
                        </div>
                        <input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme"
                            value="dark">
                    </div>
                </label>

                <label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-0">
                    <div class="d-flex flex-fill my-1">
                        <div class="form-check-label d-flex me-2">
                            <i class="ph-translate ph-lg me-3"></i>
                            <div>
                                <span class="fw-bold">Auto theme</span>
                                <div class="fs-sm text-muted">Set theme based on system mode</div>
                            </div>
                        </div>
                        <input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme"
                            value="auto">
                    </div>
                </label>
            </div>

            <div class="fw-semibold mb-2">Direction</div>
            <div class="list-group mb-3">
                <label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-0">
                    <div class="d-flex flex-fill my-1">
                        <div class="form-check-label d-flex me-2">
                            <i class="ph-translate ph-lg me-3"></i>
                            <div>
                                <span class="fw-bold">RTL direction</span>
                                <div class="text-muted">Toggle between LTR and RTL</div>
                            </div>
                        </div>
                        <input type="checkbox" name="layout-direction" value="rtl"
                            class="form-check-input cursor-pointer m-0 ms-auto">
                    </div>
                </label>
            </div>

            <div class="fw-semibold mb-2">Layouts</div>
            <div class="row">
                <div class="col-12">
                    <a href="index.html" class="d-block mb-3">
                        <img src="../../../../../assets/images/layouts/layout_1.png"
                            class="img-fluid img-thumbnail bg-primary bg-opacity-20 border-primary" alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="https://demo.interface.club/limitless/demo/template/html/layout_2/full/index.html"
                        class="d-block mb-3">
                        <img src="../../../../../assets/images/layouts/layout_2.png" class="img-fluid img-thumbnail"
                            alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="https://demo.interface.club/limitless/demo/template/html/layout_3/full/index.html"
                        class="d-block mb-3">
                        <img src="../../../../../assets/images/layouts/layout_3.png" class="img-fluid img-thumbnail"
                            alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="https://demo.interface.club/limitless/demo/template/html/layout_4/full/index.html"
                        class="d-block mb-3">
                        <img src="../../../../../assets/images/layouts/layout_4.png" class="img-fluid img-thumbnail"
                            alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="https://demo.interface.club/limitless/demo/template/html/layout_5/full/index.html"
                        class="d-block mb-3">
                        <img src="../../../../../assets/images/layouts/layout_5.png" class="img-fluid img-thumbnail"
                            alt="">
                    </a>
                </div>
                <div class="col-12">
                    <a href="https://demo.interface.club/limitless/demo/template/html/layout_6/full/index.html"
                        class="d-block">
                        <img src="../../../../../assets/images/layouts/layout_6.png" class="img-fluid img-thumbnail"
                            alt="">
                    </a>
                </div>
            </div>
        </div>

        <div class="border-top text-center py-2 px-3">
            <a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov"
                class="btn btn-yellow fw-semibold w-100 my-1" target="_blank">
                <i class="ph-shopping-cart me-2"></i>
                Purchase Limitless
            </a>
        </div>
    </div>
    <!-- /demo config -->

</body>
