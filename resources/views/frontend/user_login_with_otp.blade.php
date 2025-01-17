@extends('frontend.layouts.app')
@section('content')

<div class="py-6">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-md-8 mx-auto">
                <div class="bg-white rounded shadow-sm p-4 text-left">
                    <h1 class="h3 fw-600">{{ translate('Login with OTP') }}</h1>
                    <p class="mb-4 opacity-60">
                        {{('Enter your Registered Mobile Number to recieve OTP.')}}

                    </p>
                    <form method="POST" action="{{ route('password.verify_otp') }}">
                        @csrf
                        <div class="form-group">

                            <input 
                            type="number" 
                            class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" 
                            value="{{ old('phone') }}" placeholder="{{ translate('Phone Number') }}" 
                            name="phone"  
                            maxlength="10"  
                            minlength="10"
                            oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);"
                            >

                            @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary btn-block" type="submit">
                                {{ ('Send OTP') }}
                            </button>
                        </div>
                    </form>
                    <hr />
                    <div class="mt-3 d-flex justify-content-center mb-2" style=" color:#0f0f0f !important;">
                        <a href="{{ route('home') }}" class="text-reset opacity-60">{{translate('Back to Dashboard')}}</a>
                    </div>
                    <div class="text-center">
                    <p class="text-muted mb-2 pb-2">{{ translate("or") }}</p>
                    <span>Dont have an account?<a class="mt-2 ml1" href="{{ route('register') }}">{{ translate('Create an account') }}</a></span>
                    
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection