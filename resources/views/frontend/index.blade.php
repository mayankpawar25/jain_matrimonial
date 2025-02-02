<!-- custom modal -->
<!-- <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                    
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">
                
                <img src="{{ static_asset('assets/img/modal-bnr.png') }}" class="w-100 mb-3" alt="">
                <h4>आपकी रुचि के लिए धन्यवाद! पंजीकरण अब बंद हो चुके हैं। हम आपको 15 दिसंबर 2024 को परिचय सम्मेलन में स्वागत करने के लिए उत्सुक हैं।</h4>
                <a href="{{ route('form.resgistration') }}" class="btn btn-primary">Register Now</a>
            </div>
            
        </div>
    </div>
</div> -->

@extends('frontend.layouts.app')
<style>
    .samiti-text h4 {
  color: var(--primary);
}
.samiti-text .card {
  min-height: 96px;
  padding: 16px 8px 0px 8px;
} 
</style>
@section('content')

    <!-- Homepage Slider Section -->
    @if (get_setting('show_homepage_slider') == 'on' && get_setting('home_slider_images') != null)
    @if (Auth::check() && auth()->user()->user_type == 'member')
        <section class="position-relative overflow-hidden min-vh-100 d-flex home-slider-area slider-top-setting-login ">
        @else
        <section class="position-relative overflow-hidden min-vh-100 d-flex home-slider-area slider-top-setting-normal">
        @endif
            @php 
                $slider_images = json_decode(get_setting('home_slider_images'), true);  
                $slider_images_small = json_decode(get_setting('home_slider_images_small'), true);  
            @endphp
            <div class="absolute-full">
                <div class="aiz-carousel aiz-carousel-full h-100 d-none {{ get_setting('home_slider_images_small') != null ? 'd-md-block' : 'd-block' }}" data-fade='true' data-infinite='true' data-autoplay='true'>
                    @foreach ($slider_images as $key => $slider_image)
                        <img class="img-fit" src="{{ uploaded_asset($slider_image) }}">
                    @endforeach
                </div>
                @if (get_setting('home_slider_images_small') != null)
                    <div class="aiz-carousel aiz-carousel-full h-100 d-md-none" data-fade='true' data-infinite='true' data-autoplay='true'>
                        @foreach ($slider_images_small as $key => $slider_image)
                            <img class="img-fit" src="{{ uploaded_asset($slider_image) }}">
                        @endforeach
                    </div>
                @endif
                <div class="absolute-full bg-white opacity-0 d-md-none"></div>
            </div>
            <div class="container position-relative d-flex flex-column">
                <div class="row pt-11 pb-8 my-auto align-items-center">
                    <div class="col-xl-5 col-lg-6 my-4">
                        <div class="text-dark home-slider-text">
                            {!! get_setting('home_slider_text') !!}
                        </div>
                    </div>
                    @if (!Auth::check() && get_setting('show_homepage_slider_registration') == 'on')
                        <div class="offset-xxl-2 offset-xl-1 col-lg-6 col-xxl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4 text-center">
                                        <h2 class="h3 text-primary mb-0">{{ translate('Create Your Account') }}</h2>
                                        <p>{{ translate('Fill out the form to get started') }}.</p>
                                    </div>
                                    <form class="form-default" id="reg-form" role="form"
                                        action="{{ route('register') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="on_behalf">{{ translate('On Behalf') }}</label>
                                                    @php $on_behalves = \App\Models\OnBehalf::all(); @endphp
                                                    <select
                                                        class="form-control aiz-selectpicker @error('on_behalf') is-invalid @enderror"
                                                        name="on_behalf" required>
                                                        @foreach ($on_behalves as $on_behalf)
                                                            <option value="{{ $on_behalf->id }}">{{ $on_behalf->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('on_behalf')
                                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="name">{{ translate('First Name') }}</label>
                                                    <input type="text"
                                                        class="form-control @error('first_name') is-invalid @enderror"
                                                        name="first_name" id="first_name"
                                                        placeholder="{{ translate('First Name') }}" required>
                                                    @error('first_name')
                                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="name">{{ translate('Last Name') }}</label>
                                                    <input type="text"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        name="last_name" id="last_name"
                                                        placeholder="{{ translate('Last Name') }}" required>
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="gender">{{ translate('Gender') }}</label>
                                                    <select
                                                        class="form-control aiz-selectpicker @error('gender') is-invalid @enderror"
                                                        name="gender" required>
                                                        <option value="1">{{ translate('Male') }}</option>
                                                        <option value="2">{{ translate('Female') }}</option>
                                                    </select>
                                                    @error('gender')
                                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="name">{{ translate('Date Of Birth') }}</label>
                                                    <input type="text"
                                                        class="form-control aiz-date-range @error('date_of_birth') is-invalid @enderror"
                                                        name="date_of_birth" id="date_of_birth"
                                                        placeholder="{{ translate('Date Of Birth') }}" data-single="true"
                                                        data-show-dropdown="true" data-max-date="{{ get_max_date() }}"
                                                        autocomplete="off" required>
                                                    @error('date_of_birth')
                                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        @if (addon_activation('otp_system'))
                                            <div>
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <label class="form-label"
                                                        for="email">{{ translate('Email / Phone') }}</label>
                                                    <button class="btn btn-link p-0 opacity-50 text-reset fs-12"
                                                        type="button"
                                                        onclick="toggleEmailPhone(this)">{{ translate('Use Email Instead') }}</button>
                                                </div>
                                                <div class="form-group phone-form-group mb-1">
                                                    <input type="tel" id="phone-code"
                                                        class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                        value="{{ old('phone') }}" placeholder="" name="phone"
                                                        autocomplete="off">
                                                </div>

                                                <input type="hidden" name="country_code" value="">

                                                <div class="form-group email-form-group mb-1 d-none">
                                                    <input type="email"
                                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        value="{{ old('email') }}"
                                                        placeholder="{{ translate('Email') }}" name="email"
                                                        autocomplete="off">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label"
                                                            for="email">{{ translate('Email address') }}</label>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" id="signinSrEmail"
                                                            placeholder="{{ translate('Email Address') }}">
                                                        @error('email')
                                                            <span class="invalid-feedback"
                                                                role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="password">{{ translate('Password') }}</label>
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" placeholder="********" aria-label="********"
                                                        required>
                                                    <small>{{ translate('Minimun 8 characters') }}</small>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label"
                                                        for="password-confirm">{{ translate('Confirm password') }}</label>
                                                    <input type="password" class="form-control"
                                                        name="password_confirmation" placeholder="********" required>
                                                    <small>{{ translate('Minimun 8 characters') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        @if (addon_activation('referral_system'))
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label"
                                                            for="email">{{ translate('Referral Code') }}</label>
                                                        <input type="text"
                                                            class="form-control{{ $errors->has('referral_code') ? ' is-invalid' : '' }}"
                                                            value="{{ old('referral_code') }}"
                                                            placeholder="{{ translate('Referral Code') }}"
                                                            name="referral_code">
                                                        @if ($errors->has('referral_code'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('referral_code') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (get_setting('google_recaptcha_activation') == 1)
                                            <div class="form-group">
                                                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                                @error('g-recaptcha-response')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" name="checkbox_example_1" required>
                                                <span class=opacity-60>{{ translate('By signing up you agree to our') }}
                                                    <a href="{{ env('APP_URL') . '/terms-conditions' }}"
                                                        target="_blank">{{ translate('terms and conditions') }}.</a>
                                                </span>
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                        @error('checkbox_example_1')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror

                                        <div class="">
                                            <button type="submit"
                                                class="btn btn-block btn-primary">{{ translate('Create Account') }}</button>
                                        </div>
                                        @if (get_setting('google_login_activation') == 1 || get_setting('facebook_login_activation') == 1 || get_setting('twitter_login_activation') == 1 || get_setting('apple_login_activation') == 1)
                                            <div class="mt-4">
                                                <div class="separator mb-3">
                                                    <span class="bg-white px-3">{{ translate('Or Join With') }}</span>
                                                </div>
                                                <ul class="list-inline social colored text-center">
                                                    @if (get_setting('facebook_login_activation') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                                                class="facebook"
                                                                title="{{ translate('Facebook') }}"><i
                                                                    class="lab la-facebook-f"></i></a>
                                                        </li>
                                                    @endif
                                                    @if (get_setting('google_login_activation') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                                                class="google"
                                                                title="{{ translate('Google') }}"><i
                                                                    class="lab la-google"></i></a>
                                                        </li>
                                                    @endif
                                                    @if (get_setting('twitter_login_activation') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                                                class="twitter"
                                                                title="{{ translate('Twitter') }}"><i
                                                                    class="lab la-twitter"></i></a>
                                                        </li>
                                                    @endif
                                                    @if (get_setting('apple_login_activation') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'apple']) }}"
                                                                class="apple"
                                                                title="{{ translate('Apple') }}"><i
                                                                    class="lab la-apple"></i></a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- search  -->
               
            </div>
        </section>
    @endif

    @if (Auth::check() && Auth::user()->user_type == 'member')
                    <div class="p-4 bg-white rounded-top border-bottom"
                        style="box-shadow: 0 -25px 50px -12px rgb(0 0 0 / 25%);">
                        <div class="row">
                            <div class="col-xl-10 mx-auto">
                                <form action="{{ route('member.listing') }}" method="get">
                                    <div class="row gutters-5">
                                        <div class="col-lg">
                                            <div class="">
                                                <label class="form-label"
                                                    for="name">{{ ('Age From') }}</label>
                                                <input type="number" name="age_from" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="">
                                                <label class="form-label" for="name">{{ ('To') }}</label>
                                                <input type="number" name="age_to" class="form-control">
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg">
                                            <div class="">
                                                <label class="form-label"
                                                    for="name">{{ translate('Religion') }}</label>
                                                @php $religions = \App\Models\Religion::all(); @endphp
                                                <select name="religion_id" id="religion_id"
                                                    class="form-control aiz-selectpicker" data-live-search="true"
                                                    data-container="body">
                                                    <option value="">{{ translate('Choose One') }}</option>
                                                    @foreach ($religions as $religion)
                                                        <option value="{{ $religion->id }}"> {{ $religion->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="">
                                                <label class="form-label"
                                                    for="name">{{ ('Mother Tongue') }}</label>
                                                @php $mother_tongues = \App\Models\MemberLanguage::all(); @endphp
                                                <select name="mother_tongue" class="form-control aiz-selectpicker"
                                                    data-live-search="true" data-container="body">
                                                    <option value="">{{ translate('Select One') }}</option>
                                                    @foreach ($mother_tongues as $mother_tongue_select)
                                                        <option value="{{ $mother_tongue_select->id }}">
                                                            {{ $mother_tongue_select->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-lg mt-1">
                                            <button type="submit"
                                                class="btn btn-block btn-primary mt-4">{{ translate('Search') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

    <section class="pt-7 bg-white">
        <div class="container samiti-text text-center">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-xxl-12 mx-auto">
                
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="card">
                        <h4>शिरोमणि संरक्षक</h4>
                        <h5><strong>श्रीमती पुष्पा प्रदीप जी कासलीवाल</strong></h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="card"><h4>राष्ट्रीय अध्यक्ष</h4>
                        <h5><strong>राकेश विनायका </strong></h5></div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="card">
                        <h4>राष्ट्रीय महासचिव</h4>
                        <h5><strong>विपुल बाँझल</strong></h5>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="card">
                        <h4>राष्ट्रीय कोषाध्यक्ष</h4>
                        <h5><strong>अतुल बिलाला </strong></h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4  mb-2">
                    <div class="card">
                        <h4>मुख्य सूत्रधार</h4>
                        <h5><strong>यशकमल अजमेरा - जयपुर</strong></h5>
                        </div>
                    </div>
                    <div class="col-md-4  mb-2">
                    <div class="card">
                        <h4>सूत्रधार</h4>
                        <h5><strong>जे. के. जैन - कोटा</strong></h5>
                        </div>
                    </div>
                    <div class="col-md-4  mb-2">
                    <div class="card">
                        <h4>सूत्रधार</h4>
                        <h5><strong>ममता जैन - रायपुर</strong></h5>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-12 textcenter">
                        <h4>मुख्य संयोजक </h4>
                    </div>
                    <div class="col-md-3  mb-2">
                    <div class="card">
                        <h5><strong>प्रदीप गंगवाल - इंदौर: <br>98260-30053</strong></h5>
                        </div>
                    </div>
                    <div class="col-md-3  mb-2">
                    <div class="card">
                        <h5><strong>राजीव गिरधरवाल - भोपाल: <br>88717-13822</strong></h5>
                        </div>
                    </div>
                    <div class="col-md-3  mb-2">
                    <div class="card">
                        <h5><strong>प्रशांत जैन - जबलपुर: <br>94250-22806    </strong></h5>
                        </div>
                    </div>
                    <div class="col-md-3  mb-2">
                    <div class="card">
                        <h5><strong>संजय पापड़ीवाल - इंदौर: <br> 94253-48014</strong></h5>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
    <!-- premium member Section -->
    @if (get_setting('show_premium_member_section') == 'on')
        <section class="pt-7 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3 text-dark">{{ get_setting('premium_member_section_title') }}</h2>
                            <p class="fw-400 fs-16 opacity-60">{{ get_setting('premium_member_section_sub_title') }}</p>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="4" data-lg-items="4"
                    data-md-items="3" data-sm-items="2" data-xs-items="1" data-dots='true' data-infinite='true'>
                    @foreach ($premium_members as $key => $member)
                        <div class="carousel-box">
                            @include('frontend.inc.member_box_1',['member'=>$member])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    <!-- Banner section 1 -->
    @if (get_setting('show_home_banner1_section') == 'on' && get_setting('home_banner1_images') != null)
        <section class="pt-7 bg-white">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                    @foreach ($banner_1_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3">
                                <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}"
                                    class="d-block text-reset">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($banner_1_imags[$key]) }}"
                                        alt="{{ env('APP_NAME') }}" class="img-fluid lazyload w-100">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- How It Works Section -->
    @if (get_setting('show_how_it_works_section') == 'on' && get_setting('how_it_works_steps_titles') != null)
        <section class="py-7 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3">{{ get_setting('how_it_works_title') }}</h2>
                            <p class="fw-400 fs-16 opacity-60">{{ get_setting('how_it_works_sub_title') }}</p>
                        </div>
                    </div>
                </div>
                <div class="row gutters-10">
                    @php
                        $how_it_works_steps_titles = json_decode(get_setting('how_it_works_steps_titles'));
                        $step = 1;
                    @endphp
                    @foreach ($how_it_works_steps_titles as $key => $how_it_works_steps_title)
                        <div class="col-lg">
                            <div class="border p-3 mb-3">
                                <div class=" row align-items-center">
                                    <div class="col-7">
                                        <div class="text-primary fw-600 h1">{{ $step++ }}</div>
                                        <div class="text-secondary fs-20 mb-2 fw-600">{{ $how_it_works_steps_title }}
                                        </div>
                                        <div class="fs-15 opacity-60">
                                            {{ json_decode(get_setting('how_it_works_steps_sub_titles'), true)[$key] }}
                                        </div>
                                    </div>
                                    <div class="mt-3 col-5 text-right">
                                        <img src="{{ uploaded_asset(json_decode(get_setting('how_it_works_steps_icons'), true)[$key]) }}"
                                            class="img-fluid h-80px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- <div class="text-center"><a href="{{ route('form.resgistration') }}" class="btn btn-primary">Register Now</a></div> -->
            <div class="container info-text22">
                <div class="row">
                    <div class="col-md-8 offset-md-2 ">
                    <h2 class="fw-600 mb-3 text-dark text-center mt-5 ">आवश्यक जानकारी / निर्देश</h2>
                        <ul>
                            <li>पूर्ण भरे हुए फार्म नीचे दर्शाए गए कार्यालयों पर रविवार को छोड़कर कार्यालय के समय प्रातः 10 से सायं 5 बजे तक दिनांक 1 दिसंबर 2024 तक जमा हो सकेंगे।
                                <br>
                                <strong>इंदौर कार्यालय पता:</strong> मनीष जैन 63, रीगल चौराहा, कीर्ति स्तम्भ इंदौर - 452001  (म. प्र.), मो. 9926008080<br>
                                <strong>जयपुर कार्यालय पता:</strong> पारस कुमार जैन, भट्टारक जी की नसियाँ, नारायण सिंह सर्किल, जयपुर (राजस्थान) मो. 8233200009<br>
                                <strong>जबलपुर कार्यालय पता:</strong> प्रशान्त जैन, महावीर मेडिको, शॉप नं. 5, डी. एन. जैन मार्केट, गोल बाजार, जबलपुर - 482002 (म.प्र.) मो. 9425022806<br>
                                <strong>भोपाल कार्यालय पता:</strong> राजीव  गिरधरवाल, शॉप नं 4 शालीमार काम्प्लेक्स, स्टेट बैंक चौराहा, सुल्तानिया रोड भोपाल मो. 8871713822<br>
                                <strong>उज्जैन कार्यालय पता:</strong> जम्बू धवल (धवल पापड़ ), 26/3 धवलधरा, निजातपुरा उज्जैन  (म.प्र.) मो. 9479513338  <br>
                                <strong>कोटा कार्यालय पता:</strong> श्री जे.  के. जैन   , 4A6, तलवंडी मेन रोड, कोटा, मो. 7977063207<br>
                                <strong>उत्तरप्रदेश कार्यालय पता:</strong> अलोक जैन उत्तरप्रदेश (झाँसी),  मो. 9415073930  <br>
                               <strong> रायपुर (छ.ग.) कार्यालय पता:</strong> ममता जैन रायपुर  (छ. ग.), मो. 9827160774
                                
                            </li>
                            <li>
                            इंदौर से समारोह में आने वाले प्रतिभागियों हेतु आवास व्यवस्था पूर्व सूचना पर शुल्क सहित उपलब्ध रहेगी।
                            </li>
                           <li>प्रत्याशी का विवरण उपलब्ध कराई गई सूचना के आधार पर प्रकाशित किया जाएगा, किसी भी प्रकार की गलत सूचना व तथ्यों के लिए आयोजक संस्था जिम्मेदार नहीं होगी।</li>
                           <li>कार्यक्रम में प्रत्याशी की उपलब्धता के अनुसार मंच पर परिचय प्रस्तुत करने हेतु अभिभावक सहित उपस्थिति की अनुमति होगी। प्रत्याशी की अनुपस्थिति में अभिभावक भी मंच पर परिचय दे सकेंगे </li>
                           <!-- <li>सभी प्रतिभागियों को नाम के साथ मंच पर बुलाया जाएगा।</li> -->
                           <li>अन्य सम्बंधित जानकारियां समय - समय पर प्रेषित की जाती रहेगी एवं  वेबसाइट पर उपलब्ध रहेगी।</li>
                           <li>आयोजक को आयोजन में किसी भी प्रकार के परिवर्तन का सम्पूर्ण अधिक सुरक्षित है । </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Trusted by Millions Section -->
    @if (get_setting('show_trusted_by_millions_section') == 'on')
        <section class="bg-center bg-cover min-vh-100 py-7 text-white d-flex align-items-center bg-fixed"
            style="background-image: url('{{ uploaded_asset(get_setting('trusted_by_millions_background_image')) }}')">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 mx-auto">
                        <div class="text-center pb-12">
                            <h2 class="fw-600">{{ get_setting('trusted_by_millions_title') }}</h2>
                            <div class="fs-16 fw-400">{{ get_setting('trusted_by_millions_sub_title') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        $homepage_best_features = json_decode(get_setting('homepage_best_features'));
                    @endphp
                    @if (!empty($homepage_best_features))
                        @foreach ($homepage_best_features as $key => $homepage_best_feature)
                            <div class="col-lg">
                                <div class="border rounded position-relative z-1 border-gray-600 overflow-hidden mt-4">
                                    <div class="absolute-full bg-dark opacity-60 z--1"></div>
                                    <div class="px-4 py-5 d-flex align-items-center justify-content-center">
                                        <img src="{{ uploaded_asset(json_decode(get_setting('homepage_best_features_icons'), true)[$key]) }}"
                                            class="img-fluid h-20px">
                                        <span class="fs-17 ml-2">{{ $homepage_best_feature }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- New Member Section -->
    @if (get_setting('show_new_member_section') == 'on')
        <section class="py-7 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3 text-dark">{{ get_setting('new_member_section_title') }}</h2>
                            <p class="fw-400 fs-16 opacity-60">{{ get_setting('new_member_section_sub_title') }}</p>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="4" data-lg-items="4"
                    data-md-items="3" data-sm-items="2" data-xs-items="1" data-dots='true' data-infinite='true'>
                    @foreach ($new_members as $key => $member)
                        <div class="carousel-box">
                            @include('frontend.inc.member_box_1',['member'=>$member])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- happy Story Section -->
    @if (get_setting('show_happy_story_section') == 'on')
        <section class="py-7 bg-dark text-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3">Happy Stories</h2>
                        </div>
                    </div>
                </div>
                <div
                    class="card-columns column-gap-10 card-columns-xxl-4 card-columns-lg-3 card-columns-md-2 card-columns-1">
                    @php
                        $happy_stories = \App\Models\HappyStory::where('approved', '1')
                            ->latest()
                            ->limit(get_setting('max_happy_story_show_homepage'))
                            ->get();
                    @endphp
                    @foreach ($happy_stories as $key => $happy_story)
                        @php
                            $photo = explode(',', $happy_story->photos);
                        @endphp
                        <div class="card border-gray-800 overflow-hidden mb-2">
                            <a href="{{ route('story_details', $happy_story->id) }}"
                                class="text-reset d-block position-relative">
                                <img src="{{ uploaded_asset($photo[0]) }}" class="img-fluid">
                                <div class="absolute-bottom-left p-3">
                                    <div class="position-relative z-1 p-3">
                                        <div class="absolute-full z--1 bg-dark opacity-60"></div>
                                        <div class="text-primary text-truncate">
                                            {{ $happy_story->user->first_name . ' & ' . $happy_story->partner_name }}</div>
                                        <h2 class="h5 mb-0 fs-14 fw-400 lh-1-5 text-truncate-3">
                                            {{ $happy_story->title }}
                                        </h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('happy_stories') }}" class="btn btn-primary">{{ translate('View More') }}</a>
                </div>
            </div>
        </section>
    @endif

    @if (get_setting('show_homapege_package_section') == 'on')
        <section class="py-7 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center pb-6">
                            <h2 class="fw-600 text-dark">{{ get_setting('homepage_package_section_title') }}</h2>
                            <div class="fs-16 fw-400">{{ get_setting('homepage_package_section_sub_title') }}</div>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel" data-items="4" data-xl-items="3" data-md-items="2" data-sm-items="1"
                    data-dots='true' data-infinite='true' data-autoplay='true'>
                    @foreach (\App\Models\Package::where('active', '1')->get() as $key => $package)
                        <div class="carousel-box">
                            <div class="overflow-hidden shadow-none mb-3 border-right">
                                <div class="card-body">
                                    <div class="text-center mb-4 mt-3">
                                        <img class="mw-100 mx-auto mb-4" src="{{ uploaded_asset($package->image) }}"
                                            height="130">
                                        <h5 class="mb-3 h5 fw-600">{{ $package->name }}</h5>
                                    </div>
                                    <ul class="list-group list-group-raw fs-15 mb-5">
                                        <li class="list-group-item py-2">
                                            <i class="las la-check text-success mr-2"></i>
                                            {{ $package->express_interest }} {{ translate('Express Interests') }}
                                        </li>
                                        <li class="list-group-item py-2">
                                            <i class="las la-check text-success mr-2"></i>
                                            {{ $package->photo_gallery }} {{ translate('Gallery Photo Upload') }}
                                        </li>
                                        <li class="list-group-item py-2">
                                            <i class="las la-check text-success mr-2"></i>
                                            {{ $package->contact }} {{ translate('Contact Info View') }}
                                        </li>
                                        <li class="list-group-item py-2 text-line-through">
                                            @if ($package->auto_profile_match == 0)
                                                <i class="las la-times text-danger mr-2"></i>
                                                <del
                                                    class="opacity-60">{{ translate('Show Auto Profile Match') }}</del>
                                            @else
                                                <i class="las la-check text-success mr-2"></i>
                                                {{ translate('Show Auto Profile Match') }}
                                            @endif
                                        </li>
                                    </ul>
                                    <div class="mb-5 text-dark text-center">
                                        @if ($package->id == 1)
                                            <span class="display-4 fw-600 lh-1 mb-0">{{ translate('Free') }}</span>
                                        @else
                                            <span
                                                class="display-4 fw-600 lh-1 mb-0">{{ single_price($package->price) }}</span>
                                        @endif
                                        <span class="text-secondary d-block">{{ $package->validity }}
                                            {{ translate('Days') }}</span>
                                    </div>
                                    <div class="text-center mb-3">
                                        @if ($package->id != 1)
                                            @if (Auth::check())
                                                <a href="{{ route('package_payment_methods', encrypt($package->id)) }}"
                                                    type="submit"
                                                    class="btn btn-primary">{{ translate('Purchase This Package') }}</a>
                                            @else
                                                <button type="submit" onclick="loginModal()"
                                                    class="btn btn-primary">{{ translate('Purchase This Package') }}</button>
                                            @endif
                                        @else
                                            <a href="javascript:void(0);"
                                                class="btn btn-light"><del>{{ translate('Purchase This Package') }}</del></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @if (get_setting('show_homepage_review_section') == 'on' && get_setting('homepage_reviews') != null)
        <section class="py-7 bg-cover bg-center text-white"
            style="background-image: url('{{ uploaded_asset(get_setting('homepage_review_section_background_image')) }}');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-9 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3">{{ get_setting('homepage_review_section_title') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-10 mx-auto">
                        <div class="aiz-carousel large-arrow" data-items="1" data-arrows='true' data-infinite='true'
                            data-autoplay='true'>
                            @foreach (json_decode(get_setting('homepage_reviews')) as $key => $review)
                                <div class="carousel-box">
                                    <div class="text-center px-lg-9">
                                        <img src="{{ uploaded_asset(json_decode(get_setting('homepage_reviewers_images'), true)[$key]) }}"
                                            class="size-180px img-fit mx-auto rounded-circle border border-white border-width-5 shadow-lg mb-5">
                                        <div class="fs-18 fw-300 font-italic">{{ $review }}</div>
                                        <i class="las la-quote-right la-10x text-dark opacity-30"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (get_setting('show_blog_section') == 'on')
        <section class="py-7 bg-white text-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3 text-dark">{{ get_setting('blog_section_title') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel gutters-10" data-items="4" data-xl-items="3" data-md-items="2" data-sm-items="1"
                    data-arrows='true'>
                    @php
                        $blogs = \App\Models\Blog::query()
                            ->where('status', 1)
                            ->latest()
                            ->limit(get_setting('max_blog_show_homepage'))
                            ->get();
                    @endphp
                    @foreach ($blogs as $key => $blog)
                        <div class="caorusel-box p-1">
                            <div class="card mb-3 overflow-hidden shadow-sm text-dark">
                                <a href="{{ route('blog.details', $blog->slug) }}" class="text-reset d-block">
                                    <img src="{{ uploaded_asset($blog->banner) }}" alt="{{ $blog->title }}"
                                        class="h-200px img-fit">
                                </a>
                                <div class="p-4">
                                    <h2 class="fs-18 fw-600 mb-1">
                                        <a href="{{ route('blog.details', $blog->slug) }}" class="text-reset">
                                            {{ $blog->title }}
                                        </a>
                                    </h2>
                                    @if ($blog->category != null)
                                        <div class="mb-2 opacity-50">
                                            <i>{{ $blog->category->category_name }}</i>
                                        </div>
                                    @endif
                                    <p class="opacity-70 mb-4">{{ $blog->short_description }}</p>
                                    <a href="{{ route('blog.details', $blog->slug) }}"
                                        class="btn btn-soft-primary">{{ translate('View More') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('blog') }}" class="btn btn-primary">{{ translate('View More') }}</a>
                </div>
            </div>
        </section>
    @endif

@endsection

@section('modal')
    @include('modals.login_modal')
    @include('modals.package_update_alert_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function loginModal() {
           // $('#LoginModal').modal();
        }

        function package_update_alert() {
            $('.package_update_alert_modal').modal('show');
        }
    </script>
    @if(get_setting('google_recaptcha_activation') == 1)
        @include('partials.recaptcha')
    @endif
    @if(addon_activation('otp_system'))
        @include('partials.emailOrPhone')
    @endif
@endsection
