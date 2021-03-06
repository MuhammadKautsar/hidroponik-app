<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-green" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/logo putih.png" class="navbar-brand-img" alt="...">
        </a>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/logo hitam.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            {{-- <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input name="search" type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form> --}}
            <!-- Navigation -->
            <ul class="navbar-nav">
                @if (auth()->user()->level=="admin" || auth()->user()->level=="superadmin")
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('home') ? 'active' : '' }} text-white" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-black"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/produk') ? 'active' : '' }} text-white" href="{{ route('produks') }}">
                        <i class="fa fa-leaf text-black"></i> {{ __('Produk') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('admin/pesanan') ? 'active' : '' }} text-white" href="{{ route('pesanan') }}">
                        <i class="fa fa-shopping-bag text-black"></i> {{ __('Pesanan') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/promo') ? 'active' : '' }} text-white" href="{{ route('promos') }}">
                      <i class="ni ni-tag text-black"></i>
                      <span class="nav-link-text">Promo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/pengguna') ? 'active' : '' }} text-white" href="{{ route('users') }}">
                      <i class="ni ni-single-02 text-black"></i>
                      <span class="nav-link-text">Pengguna</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/laporan') ? 'active' : '' }} text-white" href="{{ route('reports') }}">
                        <i class="ni ni-single-copy-04 text-black"></i> {{ __('Keluhan') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/ulasan') ? 'active' : '' }} text-white" href="{{ route('umpanbalik') }}">
                        <i class="ni ni-chat-round text-black"></i> {{ __('Ulasan') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/lokasi') ? 'active' : '' }} text-white" href="{{ route('location') }}">
                        <i class="bi bi-geo-alt-fill"></i> {{ __('Lokasi') }}
                    </a>
                </li>
                @elseif (auth()->user()->level=="penjual")
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('home') ? 'active' : '' }} text-white" href="{{ route('home') }}">
                        <i class="ni ni-shop text-black"></i> {{ __('Beranda') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('produk') ? 'active' : '' }} text-white" href="{{ route('products') }}">
                        <i class="fa fa-leaf text-black"></i> {{ __('Produk') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('pesanan') ? 'active' : '' }} text-white" href="{{ route('orders') }}">
                        <i class="fa fa-shopping-bag text-black"></i> {{ __('Pesanan') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('ulasan') ? 'active' : '' }} text-white" href="{{ route('feedbacks') }}">
                        <i class="ni ni-chat-round text-black"></i> {{ __('Ulasan') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('aturan') ? 'active' : '' }} text-white" href="/aturan">
                        <i class="bi bi-exclamation-diamond-fill"></i> {{ __('Aturan') }}
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <!-- Footer -->
        {{-- <a class="navbar-brand pb-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/Group 6890.png" class="navbar-brand-img" alt="...">
        </a> --}}
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ auth()->user()->getProfileImage() }}">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
