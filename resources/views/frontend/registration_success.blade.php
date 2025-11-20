@extends('frontend.layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ static_asset('assets/css/registration.css') }}">

    <div class="py-5 mt-5 py-lg-5 mt-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-wizard p-4 bg-white shadow rounded text-center ">
                        <img src="{{ static_asset('assets/img/success-img.png') }}" style="max-width: 150px;" alt="">
                        <h1 class="mt-5" style="font-weight: 600; color: #ee2098;"><strong>{{ $registration->name }},
                            </strong> आपका रजिस्ट्रेशन सफलता पूर्वक हो गया है!</h1>
                        <br>
                        <h4>आपका रजिस्ट्रेशन नंबर है : <strong>#DJSGF-{{ 100 + $registration->id }}</strong><br> <br>
                            कृपया यह नंबर अपने पास सुरक्षित रखे.</h4><br>
                        <h4>रजिस्ट्रेशन दिनांक :
                            <strong>{{ \Carbon\Carbon::parse($registration->created_at)->format('d-m-Y H:i:s') }}</strong><br>
                            <br>
                        </h4>
                        <h4 style="font-weight: 500; color: red;padding-top:5px; font-size: 16px;margin:20px 0">
                            सभी
                            यूजर को लॉगिन डिटेल
                            परिचय सम्मेलन
                            के बाद रजिस्टर
                            मोबाइल नंबर पर भेजे जाएँगे</h4>

                        <a href="/" class="btn btn-next width mt-3"
                            style="background-color: rgb(240, 53, 162); border: none; color: white;">Back To Home</a>
                        <!-- <p>Thank you for registering. Your Registration ID is: <strong>{{ $registration->id }}</strong></p>
                                                                    <p>Name: {{ $registration->name }}</p>
                                                                    <p>Email: {{ $registration->email }}</p> -->

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection