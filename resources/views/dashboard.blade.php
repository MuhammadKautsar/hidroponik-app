@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--8">
        @if (auth()->user()->level=="admin" || auth()->user()->level=="superadmin")
        <div class="row">
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('produks') }}">
                <div class="card card-stats mb-4 mb-xl-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Produk</h5>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="fa fa-leaf"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_produk }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('pesanan') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Pesanan</h5>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                                    <i class="fa fa-shopping-bag"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_pesanan }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('promos') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Promo</h5>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="ni ni-tag"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_promo }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('users') }}">
                <div class="card card-stats mb-4 mb-xl-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Pengguna</h5>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_user }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('reports') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Keluhan</h5>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-red text-white rounded-circle shadow">
                                    <i class="ni ni-single-copy-04"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_laporan }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('umpanbalik') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Ulasan</h5>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-teal text-white rounded-circle shadow">
                                    <i class="ni ni-chat-round"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $jumlah_ulasan }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-5 mb-4 mb-xl-0">
                <div class="card bg-light-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="mb-0">Grafik Pesanan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-graph">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="lineChart" class="chart-canvas" style="height:90vh; width:80vw"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="mb-0">Grafik Produk</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-graph">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="barChart" class="chart-canvas" style="height:130vh; width:80vw"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="mb-0">Grafik Pengguna</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-graph">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="pieChart" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif (auth()->user()->level=="penjual")
        <div class="row">
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold mb-0">Order baru</h3>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-light text-white rounded-circle shadow">
                                    <i class="bi-plus-square"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $belum }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold mb-0">Order diproses</h3>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                                    <i class="bi-box-seam"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $diproses }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold mb-0">Order dikirim</h3>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="bi-truck"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $dikirim }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold mb-0">Order selesai</h3>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                                    <i class="bi-clipboard-check"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $selesai }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('orders') }}">
                <div class="card card-stats mb-4 mb-xl-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold mb-0">Order batal</h3>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-red text-white rounded-circle shadow">
                                    <i class="bi-x-circle"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $batal }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-2 col-lg-6">
                <a href="{{ route('feedbacks') }}">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title text-bold mb-0">Ulasan baru</h3>
                            </div>
                            <div class="mt-2 ml-5 col-auto">
                                <div class="icon icon-shape bg-teal text-white rounded-circle shadow">
                                    <i class="bi-chat"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-0 mb-0 text-muted text-sm">
                            <span class="h2 font-weight-bold mb-0">{{ $ulasan }}</span>
                        </p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-7 mb-5 mb-xl-0">
                <div class="card bg-light-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="mb-0">Grafik Pendapatan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-graph">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="salesChart" class="chart-canvas" style="height:60vh; width:80vw"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="mb-0">Grafik Pesanan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-graph">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="orderChart" class="chart-canvas" style="height:90vh; width:80vw"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @include('layouts.footers.auth')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('lineChart');
        const lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                datasets: [{
                    label: 'Pesanan Selesai',
                    data: [{{$ordersel_jan}},
                        {{$ordersel_feb}},
                        {{$ordersel_mar}},
                        {{$ordersel_apr}},
                        {{$ordersel_mei}},
                        {{$ordersel_jun}}],
                    backgroundColor: [
                        'rgb(60, 179, 113)',
                    ],
                    borderColor: [
                        'rgb(60, 179, 113)',
                    ],
                    borderWidth: 2,
                },
                {
                    label: 'Pesanan Batal',
                    data: [{{$orderbat_jan}},
                        {{$orderbat_feb}},
                        {{$orderbat_mar}},
                        {{$orderbat_apr}},
                        {{$orderbat_mei}},
                        {{$orderbat_jun}}],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                    ],
                    borderWidth: 3,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const ctz = document.getElementById('barChart');
        const barChart = new Chart(ctz, {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                datasets: [{
                    label: 'Produk Baru Perbulan',
                    data: [{{$produk_jan}},
                        {{$produk_feb}},
                        {{$produk_mar}},
                        {{$produk_apr}},
                        {{$produk_mei}},
                        {{$produk_jun}}],
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                    ],
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const ctr = document.getElementById('pieChart');
        const pieChart = new Chart(ctr, {
            type: 'pie',
            data: {
                labels: ['Admin', 'Penjual', 'Pembeli'],
                datasets: [{
                    label: 'Pengguna',
                    data: [{{$admin}}, {{$penjual}}, {{$pembeli}}],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
        });
    </script>

    <script>
        const dtx = document.getElementById('salesChart');
        const salesChart = new Chart(dtx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                datasets: [{
                    label: 'Pendapatan Perbulan',
                    data: [{{$pendapatan_jan}},
                        {{$pendapatan_feb}},
                        {{$pendapatan_mar}},
                        {{$pendapatan_apr}},
                        {{$pendapatan_mei}},
                        {{$pendapatan_jun}}],
                    backgroundColor: [
                        'rgb(54, 162, 235)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const dtz = document.getElementById('orderChart');
        const orderChart = new Chart(dtz, {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
                datasets: [{
                    label: 'Selesai',
                    data: [{{$orderselpen_jan}},
                        {{$orderselpen_feb}},
                        {{$orderselpen_mar}},
                        {{$orderselpen_apr}},
                        {{$orderselpen_mei}},
                        {{$orderselpen_jun}}],
                    backgroundColor: [
                        'rgb(60, 179, 113)',
                    ],
                },
                {
                    label: 'Batal',
                    data: [{{$orderbatpen_jan}},
                        {{$orderbatpen_feb}},
                        {{$orderbatpen_mar}},
                        {{$orderbatpen_apr}},
                        {{$orderbatpen_mei}},
                        {{$orderbatpen_jun}}],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                    ],
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
