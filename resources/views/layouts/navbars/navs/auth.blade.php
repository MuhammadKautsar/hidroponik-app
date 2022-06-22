<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-black text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('Dashboard') }}</a>

        @php
            $stok = App\Models\Produk::where('penjual_id', '=', Auth::user()->id)->where('stok', '<', '1')->get();
            $order = App\Models\Order::where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Belum')->orderBy('created_at', 'desc')->get();
            $laporan = App\Models\Report::orderBy('created_at', 'desc')->get();
        @endphp

        <li class="nav-item dropdown d-none d-md-flex ml-lg-auto">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-bell-55"></i>
                @if (auth()->user()->level=="superadmin" || auth()->user()->level=="admin")
                    @if ($laporan->count() > 0)
                        <div class="badge badge-danger">{{count($laporan)}}</div>
                    @endif
                @else
                    @if ($order->count() > 0 || $stok->count() > 0)
                        <div class="badge badge-danger">{{count($order)+count($stok)}}</div>
                    @endif
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
                @if (auth()->user()->level=="superadmin" || auth()->user()->level=="admin")
                    @if ($laporan->count() < 1)
                    <div class="px-3 py-3">
                        <h6 class="text-sm text-muted m-0">Tidak ada notifikasi.</h6>
                    </div>
                    @endif
                @else
                    @if ($order->count() < 1 && $stok->count() < 1)
                    <div class="px-3 py-3">
                        <h6 class="text-sm text-muted m-0">Tidak ada notifikasi.</h6>
                    </div>
                    @endif
                @endif
                {{-- <div class="px-3 py-3">
                    @if (auth()->user()->level=="superadmin" || auth()->user()->level=="admin")
                    <h6 class="text-sm text-muted m-0">Kamu memiliki <strong class="text-dark">{{count($laporan)}}</strong> notifikasi.</h6>
                    @else
                    <h6 class="text-sm text-muted m-0">Kamu memiliki <strong class="text-dark">{{count($order)+count($stok)}}</strong> notifikasi.</h6>
                    @endif
                </div> --}}
                @foreach ($order as $od)
                <div class="list-group list-group-flush">
                    <a href="{{ route('orders') }}" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                            <div class="col-auto">
                            {{-- <img alt="Image placeholder" src="$od->getProfileImage()" class="avatar rounded-circle"> --}}
                            <i class="fa fa-shopping-bag"></i>
                            </div>
                            <div class="col ml--3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-sm mb-0">Ada pesanan baru dari <strong class="text-dark">{{$od->pembeli->nama_lengkap}}</strong>, silahkan diperiksa</p>

                                    </div>
                                    <div class="text-right text-muted">
                                        <small>{{ $od->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                @foreach ($stok as $st)
                <div class="list-group list-group-flush">
                    <a href="{{ route('products') }}" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                            <div class="col-auto">
                            {{-- <img alt="Image placeholder" src="$st->getProfileImage()" class="avatar rounded-circle"> --}}
                            <i class="fa fa-leaf"></i>
                            </div>
                            <div class="col ml--3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-sm mb-0">Produk <strong class="text-dark">{{$st->nama}}</strong> stoknya sudah habis, silahkan diupdate</p>

                                    </div>
                                    <div class="text-right text-muted">
                                        <small>{{ $st->updated_at->diffForHumans() }}</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                @if (auth()->user()->level=="superadmin" || auth()->user()->level=="admin")
                    @foreach ($laporan as $lp)
                    <div class="list-group list-group-flush">
                        <a href="{{ route('reports') }}" class="list-group-item list-group-item-action">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                {{-- <img alt="Image placeholder" src="$lp->getProfileImage()" class="avatar rounded-circle"> --}}
                                <i class="ni ni-single-copy-04"></i>
                                </div>
                                <div class="col ml--3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-sm mb-0">Ada keluhan baru dari <strong class="text-dark">{{$lp->pembeli->nama_lengkap}}</strong>, silahkan diperiksa</p>

                                        </div>
                                        <div class="text-right text-muted">
                                            <small>{{ $lp->updated_at->diffForHumans() }}</small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                @endif
                {{-- <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a> --}}
                {{-- <div class="px-3 py-3">
                    <h6 class="text-sm text-muted m-0">Kamu memiliki <strong class="text-primary">13</strong> notifikasi.</h6>
                </div> --}}
            </div>
        </li>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ auth()->user()->getProfileImage() }}">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm text-dark font-weight-bold">{{ auth()->user()->nama_lengkap }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Profil') }}</span>
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
