<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ url($setting->path_logo) }}">
    <title>{{ $setting->company_name }} | {{ $menu }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    {{-- CSS Purchase Detail --}}
    @stack('css_detail')

    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
</head>
<!--end::Head-->

<!--begin::Body-->

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake"
                src="{{ $setting->path_logo ? url($setting->path_logo) : asset('admin/img/AdminLTELogo.png') }}"
                alt="AdminLTELogo" height="60" width="60" />
        </div>

        {{-- Header/Navbar --}}
        @includeIf('layouts.header')

        {{-- Sidebar --}}
        @includeIf('layouts.sidebar')

        {{-- Content --}}
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @yield('title')
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @section('breadcumb')
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                @show
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                @yield('content')
            </section>
        </div>

        {{-- Footer --}}
        @includeIf('layouts.footer')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/js/adminlte.js') }}"></script>
    <script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    {{-- Bootstrap Validator --}}
    <script src="{{ asset('admin/js/validator.min.js') }}"></script>

    {{-- Custom Scripts --}}
    <script>
        function imagePreview(selector, temp_file, width = 200) {
            $(selector).empty();
            $(selector).append(`<img src="${window.URL.createObjectURL(temp_file)}" width="${width}">`);
        }
    </script>
    @stack('scripts')
</body>
<!--end::Body-->

</html>
