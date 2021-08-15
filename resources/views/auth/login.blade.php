@extends('layouts.app', ['class' => 'bg-silver'])

@section('content')
<div class="header bg-green py-7 py-lg-5">
</div>

<div class="container mt--10 pb-5">
    <div class="header-body text-center mt-9 mb-7">
        <div class="row justify-content-center">
            {{-- <div class="col-lg-5 col-md-6">
                <h1 class="text-black">{{ __('Welcome!') }}</h1>
                <h2 class="text-black">{{ __('to') }}</h2>
                <h1 class="text-black">{{ __('Hidroponik App') }}</h1>
            </div> --}}
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>
                                    Sign in with these credentials:
                            </small>
                        </div>

                        @if (session('error'))
                            <span class="text-danger"> {{session('error')}} </span>
                        @endif

                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" value="admin@argon.com" required autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" value="secret" required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success my-4">{{ __('Sign in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-dark">
                                <small>{{ __('Forgot password?') }}</small>
                            </a>
                        @endif
                    </div>
                    {{-- <div class="col-6 text-right">
                        <a href="{{ route('register') }}" class="text-dark">
                            <small>{{ __('Create new account') }}</small>
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            
        </div>
    </div> --}}
@endsection
