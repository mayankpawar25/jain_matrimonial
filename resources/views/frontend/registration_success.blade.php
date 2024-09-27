@extends('frontend.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ static_asset('assets/css/registration.css') }}">

<div class="py-5 mt-5 py-lg-5 mt-2">
    <div class="containter">
        <div class="row">
            <div class="form-wizard p-4 bg-white shadow rounded">
                <h1>Registration Successful!</h1>
                <p>Thank you for registering. Your Registration ID is: <strong>{{ $registration->id }}</strong></p>
                <p>Name: {{ $registration->name }}</p>
                <p>Email: {{ $registration->email }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
