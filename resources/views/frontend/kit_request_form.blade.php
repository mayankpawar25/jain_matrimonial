@extends('frontend.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ static_asset('assets/css/registration.css') }}">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



<!-- resources/views/form.blade.php -->
<div class="     mt-2  ">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 mt-5">
                <img src="{{ static_asset('assets/img/modal-bnr.png') }}" class="w-100 mb-3" alt="">

            </div>
        </div>
    </div>
</div>
<div class="py-3  py-lg-5  ">
    <div class="containter">
        <form action="{{ route('kit.submit') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-wizard p-4 bg-white shadow rounded">
                    <h3 class="text-center mb-2 mt-4" style="font-weight: bold;  line-height: 1.5;">
                        @foreach($users as $user)
                        {{ $user->name }} <br>
                        <input type="hidden" name="user_ids[]" value="{{ $user->id }}">
                        @endforeach
                        <br>
                        दिगंबर जैन सोशल ग्रुप फेडरेशन ‘परिणय पुष्प ‘ में आपका स्वागत है. <br>आपका प्रत्याशी क्रमांक :
                        @foreach($users as $user)
                        #{{ $user->id }}
                        @if(!$loop->last)
                        ,
                        @endif
                        @endforeach
                        है,
                    </h3>
                    <div class="text-center">
                        <button class="btn btn-primary mt-3" type="submit">किट प्राप्त की गई !</button>
                    </div>
                </div>
                <div style="clear: both;"></div>

            </div>
        </form>
    </div>
</div>

@endsection