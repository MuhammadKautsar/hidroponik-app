@extends('layouts.app', ['class' => 'bg-silver'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <h2>
                                    Informasi :
                            </h2>
                        </div>
                        <div class="text-center text-muted mb-4">
                            <small>
                                Bagi Yang Ingin Mendaftar Menjadi Penjual di Aplikasi AgriHub, Silahkan Hubungi Admin di nomor :
                                <br>
                                1. 081234567890
                                2. 085212345678
                                <br>
                                Atau kirim email ke :
                                <br>
                                1. juli@gmail.com
                                2. fahri@gmail.com
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
