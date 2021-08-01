@extends('layouts.app', ['class' => 'bg-silver'])

@section('content')
    <div class="header bg-green py-7 py-lg-5">
    </div>

    <div class="container mt--10 pb-5">
        <div class="header-body text-center mt-9 mb-7">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-black">{{ __('Welcome!') }}</h1>
                    <h2 class="text-black">{{ __('to') }}</h2>
                    <h1 class="text-black">{{ __('Hidroponik App') }}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
