<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item {{ $activePage == 'dashboard' ? 'selected' : '' }}"> <a class="sidebar-link sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span class="hide-menu">Dasbor</span></a></li>
                {{-- if admin and kasir --}}
                <li class="list-divider"></li>
                @if(Auth::user()->level == 'admin' || Auth::user()->level == 'kasir')
                <li class="nav-small-cap"><span class="hide-menu">Transaksi</span></li>

                <li class="sidebar-item {{ $activePage == 'transaksi' ? 'selected' : '' }}"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calendar-check"></i><span class="hide-menu"> Transaksi </span></a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item">
                            <a href="{{ route('transaksi.index') }}" class="sidebar-link {{ $miniMenu == 'transaksi' ? 'active' : '' }}">
                                <span class="hide-menu"> Belum Bayar</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('transaksi.done.index') }}" class="sidebar-link {{ $miniMenu == 'transaksi_selesai' ? 'active' : '' }}">
                                <span class="hide-menu"> Dibayar</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->level != 'kasir')
                <li class="sidebar-item {{ $activePage == 'pengeluaran' ? 'selected' : '' }}"> <a class="sidebar-link sidebar-link" href="{{ route('pengeluaran.index') }}" aria-expanded="false"><i class="fas fa-archive"></i><span class="hide-menu">Pengeluaran
                        </span></a>
                </li>
                @endif

                {{-- <li class="sidebar-item {{ $activePage == 'transaksi' ? 'selected' : '' }}"> <a class="sidebar-link" href="{{ route('transaksi.index') }}" aria-expanded="false"><i class="fas fa-pallet"></i><span class="hide-menu">Transakasi
                        </span></a>
                </li> --}}

                @if(Auth::user()->level == 'admin' || Auth::user()->level == 'kasir')
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Lainya</span></li>
                <li class="sidebar-item {{ $activePage == 'member' ? 'selected' : '' }}"> <a class="sidebar-link sidebar-link" href="{{ route('member.index') }}" aria-expanded="false"><i class="fas fa-user"></i><span class="hide-menu">Pelanggan
                        </span></a>
                </li>
                {{-- only admin --}}
                @if(Auth::user()->level == "admin")
                <li class="sidebar-item {{ $activePage == 'outlet' ? 'selected' : '' }}"> <a class="sidebar-link sidebar-link" href="{{ route('outlet.index') }}" aria-expanded="false"><i class="fas fa-hospital-alt"></i><span class="hide-menu">Toko
                        </span></a>
                </li>
                <li class="sidebar-item {{ $activePage == 'paket' ? 'selected' : '' }}"> <a class="sidebar-link sidebar-link" href="{{ route('paket.index') }}" aria-expanded="false"><i class="fas fa-shopping-cart"></i><span class="hide-menu">Paket
                        </span></a>
                </li>
                <li class="sidebar-item {{ $activePage == 'jenis' ? 'selected' : '' }}"> <a class="sidebar-link sidebar-link" href="{{ route('jenis.index') }}" aria-expanded="false"><i class="fas fa-archive"></i><span class="hide-menu">Jenis
                        </span></a>
                </li>
                
                {{-- <li class="sidebar-item {{ $activePage == 'pengguna' ? 'selected' : '' }}"> <a class="sidebar-link sidebar-link" href="{{ route('user.index') }}" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Pengguna
                        </span></a>
                </li> --}}
                <li class="sidebar-item {{ $activePage == 'pengguna' ? 'selected' : '' }}"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-users"></i><span
                            class="hide-menu"> Pengguna </span></a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item">
                            <a href="{{ route('user.index') }}" class="sidebar-link {{ $miniMenu == 'outlet' ? 'active' : '' }}">
                                <span class="hide-menu"> Petugas</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('admin.index') }}" class="sidebar-link {{ $miniMenu == 'admin' ? 'active' : '' }}">
                                <span class="hide-menu"> Admin</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                {{-- end only admin --}}
                @endif
                {{-- end only admin and kasir --}}
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Laporan</span></li>
                <li class="sidebar-item {{ $activePage == 'laporan' ? 'selected' : '' }}"> <a class="sidebar-link sidebar-link" href="/laporan" aria-expanded="false"><i class="far fa-file-archive"></i><span class="hide-menu">Laporan
                        </span></a>
                </li>
                <li class="list-divider"></li>
                {{-- only admin --}}
                <li class="nav-small-cap"><span class="hide-menu">Ekstra</span></li>
                @if(Auth::user()->level == "admin")
                <li class="sidebar-item {{ $activePage == 'riwayat' ? 'selected' : '' }}">
                    <a class="sidebar-link sidebar-link" href="{{ route('log.index') }}" aria-expanded="false">
                        <i class="fas fa-history"></i>
                        <span class="hide-menu">Riwayat</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item {{ $activePage == 'sampah' ? 'selected' : '' }}">
                    <a class="sidebar-link sidebar-link" href="{{ route('trash.index') }}" aria-expanded="false">
                        <i class="fas fa-trash"></i>
                        <span class="hide-menu">Sampah
                        </span>
                    </a>
                </li> --}}
                <li class="sidebar-item {{ $activePage == 'trash' ? 'selected' : '' }}"> <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-trash"></i><span
                            class="hide-menu"> Sampah </span></a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line">
                        <li class="sidebar-item">
                            <a href="{{ route('outlet.softDelete.index') }}" class="sidebar-link {{ $miniMenu == 'outlet' ? 'active' : '' }}">
                                <span class="hide-menu"> Toko</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('jenis.softDelete.index') }}" class="sidebar-link {{ $miniMenu == 'outlet' ? 'active' : '' }}">
                                <span class="hide-menu"> Jenis</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('paket.softDelete.index') }}" class="sidebar-link {{ $miniMenu == 'paket' ? 'active' : '' }}">
                                <span class="hide-menu"> Paket</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('member.softDelete.index') }}" class="sidebar-link {{ $miniMenu == 'paket' ? 'active' : '' }}">
                                <span class="hide-menu"> Member</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('transaksi.softDelete.index') }}" class="sidebar-link {{ $miniMenu == 'transaksi' ? 'active' : '' }}">
                                <span class="hide-menu"> Transaksi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('pengeluaran.softDelete.index') }}" class="sidebar-link {{ $miniMenu == 'pengeluaran' ? 'active' : '' }}">
                                <span class="hide-menu"> Pengeluaran</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                @endif
                <li class="sidebar-item {{ $activePage == 'tentang' ? 'selected' : '' }}">
                    <a class="sidebar-link sidebar-link" href="{{ route('tentang.index') }}" aria-expanded="false">
                        <i class="fas fa-exclamation"></i>
                        <span class="hide-menu">Tentang</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
