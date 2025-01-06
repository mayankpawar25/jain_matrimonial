@extends('frontend.layouts.app')
@section('content')

<div class="py-6">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-md-8 mx-auto">
                <div class="bg-white rounded shadow-sm p-4 text-left">
                    <h1 class="h3 fw-600">{{ translate('Login with OTP') }}</h1>
                    <p class="mb-4 opacity-60">
                        @if (addon_activation('otp_system'))
                            {{translate('Enter your email address or phone number to recieve your Otp.')}}
                        @else
                            {{translate('Enter your email address to recieve your Otp.')}}
                        @endif
                    </p>
                    <form method="POST" action="{{ route('password.verify_otp') }}">
                        @csrf
                        <div class="form-group">
                            @if (addon_activation('otp_system'))
                                <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="{{ translate('Email or Phone') }}">
                            @else
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                            @endif

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary btn-block" type="submit">
                                {{ ('Send OTP') }}
                            </button>
                        </div>
                    </form>
                    <hr/>
                    <div class="mt-3 d-flex justify-content-center" style=" color:#0f0f0f !important;">
                        <a href="{{ route('home') }}" class="text-reset opacity-60">{{translate('Back to Dashboard')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
