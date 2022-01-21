@extends('layouts.app', ['class' => 'bg-silver'])

@section('content')
    @include('layouts.headers.cards')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{ __('Verifikasi Alamat Email Anda') }}</small>
                        </div>
                        <div>
                            @if (session('resent'))
                                <div class="alert alert-light" role="alert">
                                    {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                                </div>
                            @endif

                            {{ __('Sebelum melanjutkan, harap periksa email Anda untuk tautan verifikasi.') }}

                            @if (Route::has('verification.resend'))
                                {{ __('Jika Anda tidak menerima email, klik tombol di bawah ini.') }}
                                <form method="POST" action="{{ route('verification.resend') }}" class="text-center mt-4">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Mengirim ulang email verifikasi</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
