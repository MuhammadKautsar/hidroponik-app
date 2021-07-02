@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
                <div class="col-xl-4 col-lg-6">
                    <a href="{{ route('products') }}">
                    <div class="card card-stats mb-4 mb-xl-6">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="card-title text-bold ml-3 mt-2">Pesanan baru</h3>
                                </div>
                            </div>
                            <p class="mt-3 mb-3 text-muted text-sm">
                                <span class="h2 font-weight-bold ml-3">#</span>
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
                                <span class="h2 font-weight-bold ml-3">#</span>
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
                                    <h3 class="card-title text-bold ml-3 mt-2">Pesanan dikirim</h3>
                                </div>
                            </div>
                            <p class="mt-3 mb-3 text-muted text-sm">
                                <span class="h2 font-weight-bold ml-3">#</span>
                            </p>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <a href="{{ route('pasarmurah') }}">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="card-title text-bold ml-3 mt-2">Pesanan selesai</h3>
                                </div>
                            </div>
                            <p class="mt-3 mb-3 text-muted text-sm">
                                <span class="h2 font-weight-bold ml-3">#</span>
                            </p>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <a href="{{ route('sellers') }}">
                    <div class="card card-stats mb-4 mb-xl-6">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="card-title text-bold ml-3 mt-2">Pesanan dibatalkan</h3>
                                </div>
                            </div>
                            <p class="mt-3 mb-3 text-muted text-sm">
                                <span class="h2 font-weight-bold ml-3">#</span>
                            </p>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <a href="{{ route('buyers') }}">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="card-title text-bold ml-3 mt-2">Ulasan baru</h3>
                                </div>
                            </div>
                            <p class="mt-3 mb-3 text-muted text-sm">
                                <span class="h2 font-weight-bold ml-3">#</span>
                            </p>
                        </div>
                    </div>
                    </a>
                </div>
            </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush