<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <!-- Logo icon -->
                <a href="{{ route('dashboard') }}">
                    <b class="logo-icon">
                        <!-- Dark Logo icon -->
                        <img src="{{ asset ('img/rsz_1aplous-logo.png') }}" alt="homepage" class="dark-logo" />
                        <!-- Light Logo icon -->
                        {{-- <img src="{{ asset ('img/rsz_1aplous-logo.png') }}" /> --}}
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                        <span style="color: black;">APLOU <sup>s</sup></span>
                    </span>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                <!-- Notification -->
                <li class="nav-item dropdown">
                    @if(Auth::user()->level == 'admin')
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)" id="bell" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span><i class="fa fas fa-history"></i></span>
                        {{-- <span class="badge badge-primary notify-no rounded-circle">5</span> --}}
                    </a>
                    @endif
                    <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                        <ul class="list-style-none">
                            @foreach(\App\Log::take(5)->get() as $q)
                            <li>
                                <div class="message-center notifications position-relative">
                                    <!-- Message -->
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h6 class="message-title mb-0 mt-1">{{ $q->user->tbUser->nama}}</h6> <span class="font-12 text-nowrap d-block text-muted">{{ $q->msg }}</span>
                                            <span class="font-12 text-nowrap d-block text-muted">{{ $q->created_at }}</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            @endforeach
                            <li>
                                <a class="nav-link pt-3 text-center text-dark" href="{{ route('log.index') }}">
                                    <b>Lihat Semua Riwayat</b>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- End Notification -->
                <!-- ============================================================== -->
                <!-- create new -->
                <!-- ============================================================== -->
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ml-2 d-none d-lg-inline-block"><span class="text-dark">
                            {{ Auth::user()->tbUser->nama}}
                        </span> <i data-feather="chevron-down" class="svg-icon"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" id="logout-btn">
                                <i data-feather="power" class="svg-icon mr-2 ml-1"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
