@extends('frontend.layouts.app')

@section('content')
<div class="py-6">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-6 col-md-8 mx-auto">
                <div class="bg-white rounded shadow-sm p-4 text-left">
                    <h1 class="h3 fw-600">{{ translate('Verify OTP') }}</h1>
                    <p class="mb-4 opacity-60">{{translate('Enter OTP for successful login.')}} </p>
                    <form method="POST" action="{{ route('password.otpLogin') }}">
                        @csrf

                        <input type="hidden" name="phone" value="{{ old('phone', $phone) }}"/>
                        <div class="form-group">
                            <input id="code" type="number"  maxlength="6" minlength="6"  oninput="if(this.value.length > 6) this.value = this.value.slice(0, 6);" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" value="" placeholder="Code" required autofocus>

                            @if ($errors->has('code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ translate('Login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
