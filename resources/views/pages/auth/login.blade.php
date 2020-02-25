<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Aplikasi Loundry Berbasis Web (APLOUS)">
    <meta name="author" content="Titam Septian - XII RPL 2">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Aplous - Login</title>
    <!-- Custom CSS -->
    <link href="{{ asset('vendor/dist/css/style.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader" id="preload">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url({{ asset('vendor/assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
            <div class="auth-box row">
                <div class="col-lg-6 col-md-5 modal-bg-img" style="background-image: url({{asset('img/aplous.png') }});">
                </div>
                <div class="col-lg-6 col-md-7 bg-white">
                    <div class="p-3 mb-4">
                        <div class="text-center">
                            <img src="{{ asset('vendor/assets/images/big/icon.png') }}" alt="wrapkit">
                        </div>
                        <h2 class="mt-3 text-center">Masuk</h2>
                        {{-- <p class="text-center">Enter your email address and password to access admin panel.</p> --}}
                        <form class="mt-4" method="POST" action="{{ route('postLogin') }}" id="formLogin">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group uname">
                                        <label class="text-dark" for="uname">Username</label>
                                        <input class="form-control" id="uname" name="uname" type="text" placeholder="masukan username" autofocus autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group pwd">
                                        <label class="text-dark" for="pwd">Password</label>
                                        <input class="form-control" id="pwd" name="pwd" type="password" placeholder="masukan password">
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-block btn-dark">Masuk</button>
                                </div>
                                {{-- <div class="col-lg-12 text-center mt-5">
                                    Don't have an account? <a href="#" class="text-danger">Sign Up</a>
                                </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('vendor/assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('vendor/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $(".preloader ").fadeOut();
    </script>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>