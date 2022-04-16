@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->nama_lengkap,
        // 'class' => 'col-lg-7'
    ])

    <div class="container-fluid mt--8">
        <div class="row">
            {{-- <div class="col-xl-8 order-xl-1"> --}}
            <div class="col">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Ubah Profil') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Informasi pengguna') }}</h6>

                            @if (session('status'))
                                <div class="alert alert-light alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('nama_lengkap') ? ' has-danger' : '' }}">
                                    <img src="{{ auth()->user()->getProfileImage() }}" width="150px" height="150px" class="rounded-circle mb-4"><br>
                                    <input type="file" name="profile_image">
                                </div>
                                <div class="form-group{{ $errors->has('nama_lengkap') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-nama_lengkap">{{ __('Nama') }}</label>
                                    <input type="text" name="nama_lengkap" id="input-nama_lengkap" class="form-control form-control-alternative{{ $errors->has('nama_lengkap') ? ' is-invalid' : '' }}" placeholder="{{ __('Nama') }}" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" required autofocus>

                                    @if ($errors->has('nama_lengkap'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nama_lengkap') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-username">{{ __('Username') }}</label>
                                    {{-- <span class="form-control">{{ old('username', auth()->user()->username) }}</span> --}}
                                    <input disabled type="text" name="username" id="input-username" class="form-control form-control-alternative{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Username') }}" value="{{ old('username', auth()->user()->username) }}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('nomor_hp') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-nomor_hp">{{ __('Nomor HP') }}</label>
                                    <input type="number" name="nomor_hp" id="input-nomor_hp" class="form-control form-control-alternative{{ $errors->has('nomor_hp') ? ' is-invalid' : '' }}" placeholder="{{ __('Nomor HP') }}" value="{{ old('nomor_hp', auth()->user()->nomor_hp) }}">

                                    @if ($errors->has('nomor_hp'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nomor_hp') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('alamat') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-alamat">{{ __('Alamat') }}</label>
                                    <input type="text" name="alamat" id="input-alamat" class="form-control form-control-alternative{{ $errors->has('alamat') ? ' is-invalid' : '' }}" placeholder="{{ __('Alamat') }}" value="{{ old('alamat', auth()->user()->alamat) }}">

                                    @if ($errors->has('alamat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('alamat') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Simpan') }}</button>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4" />
                        <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Password') }}</h6>

                            @if (session('password_status'))
                                <div class="alert alert-light alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-current-password">{{ __('Password Sekarang') }}</label>
                                    <input type="password" name="old_password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password Sekarang') }}" value="" required>

                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Password Baru') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password Baru') }}" value="" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Konfirmasi Password Baru') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Konfirmasi Password Baru') }}" value="" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Ubah password') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
