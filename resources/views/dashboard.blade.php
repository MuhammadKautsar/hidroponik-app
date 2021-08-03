@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        @if (auth()->user()->level=="admin")
        <div class="row">
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('products') }}">
                <div class="card card-stats mb-4 mb-xl-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Produk</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="ni ni-basket"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_produk }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Pesanan</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                                    <i class="ni ni-cart"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_pesanan }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('promos') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Promo</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="ni ni-tag"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_promo }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            {{-- <div class="col-xl-4 col-lg-6">
                <a href="{{ route('pasar_murah') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Pasar Murah</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-red text-white rounded-circle shadow">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">1</span>
                        </p>
                    </div>
                </div>
                </a>
            </div> --}}
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('sellers') }}">
                <div class="card card-stats mb-4 mb-xl-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Pengguna</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_user }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            {{-- <div class="col-xl-4 col-lg-6">
                <a href="{{ route('buyers') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Pembeli</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-teal text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_user }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div> --}}
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('reports') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Laporan</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-light text-white rounded-circle shadow">
                                    <i class="ni ni-single-copy-04"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_laporan }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('feedbacks') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Ulasan</h5>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-teal text-white rounded-circle shadow">
                                    <i class="ni ni-chat-round"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_ulasan }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
        </div>
        @endif
        @if (auth()->user()->level=="user")
        <div class="row">
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold ml-3 mt-2">Pesanan baru</h3>
                            </div>
                        </div>
                        <p class="mt-3 mb-3 text-muted text-sm">
                            <span class="h2 font-weight-bold ml-3">{{ $belum }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold ml-3 mt-2">Pesanan diproses</h3>
                            </div>
                        </div>
                        <p class="mt-3 mb-3 text-muted text-sm">
                            <span class="h2 font-weight-bold ml-3">{{ $diproses }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold ml-3 mt-2">Pesanan dikirim</h3>
                            </div>
                        </div>
                        <p class="mt-3 mb-3 text-muted text-sm">
                            <span class="h2 font-weight-bold ml-3">{{ $dikirim }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold ml-3 mt-2">Pesanan selesai</h3>
                            </div>
                        </div>
                        <p class="mt-3 mb-3 text-muted text-sm">
                            <span class="h2 font-weight-bold ml-3">{{ $selesai }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold ml-3 mt-2">Pesanan dibatalkan</h3>
                            </div>
                        </div>
                        <p class="mt-3 mb-3 text-muted text-sm">
                            <span class="h2 font-weight-bold ml-3">{{ $batal }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6">
                <a href="{{ route('feedbacks') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold ml-3 mt-2">Ulasan baru</h3>
                            </div>
                        </div>
                        <p class="mt-3 mb-3 text-muted text-sm">
                            <span class="h2 font-weight-bold ml-3">{{ $ulasan }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
        </div>
        @endif
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush