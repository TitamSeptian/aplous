<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="APlikasi Loundry Basis website">
    <meta name="author" content="TItam Septian XII RPL 2">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset ('assets/images/favicon.png') }}">
    <title>APLOUS - {{ $titlePage }}</title>
    <!-- Custom CSS -->
    {{-- <link href="{{ asset ('vendor/assets/extra-libs/c3/c3.min.css' ) }}" rel="stylesheet">
    <link href="{{ asset ('vendor/assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset ('vendor/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/> --}}
	@stack('css')
    <!-- Custom CSS -->
    <link href="{{ asset ('vendor/dist/css/style.min.css') }}" rel="stylesheet">
    {{-- data tables --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    {{-- select 2 --}}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('partials.pcs.navbar')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('partials.pcs.sidebar')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @yield('content')
                <footer class="footer text-center text-muted"></footer>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Modal + Alert Modal -->
    <!-- ============================================================== -->
    @include('partials.modals.modal')
    @include('partials.modals.alert')
    <!-- ============================================================== -->
    <!-- End Modal + Alert Modal -->
    <!-- ============================================================== -->

    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('vendor/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="{{ asset('vendor/dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('vendor/dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('vendor/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('vendor/dist/js/custom.min.js') }}"></script>
    {{-- data tables --}}
    <script src="{{ asset('vendor/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    {{-- swal --}}
    <script src="{{ asset('vendor/assets/extra-libs/swal/sweetalert2.all.js') }}"></script>
    {{-- This page JavaScript --}} 
    {{--<script src="{{ asset('vendor/assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('vendor/assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ asset('vendor/assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('vendor/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('vendor/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('vendor/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/dist/js/pages/dashboards/dashboard1.min.js') }}"></script> --}}
    @stack('js')
    <script src="{{ asset('js/lock/lock.js') }}"></script>
</body>

</html>