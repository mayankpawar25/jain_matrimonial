@extends('frontend.layouts.app')
@section('content')
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">

                <div class="col-lg-10 mx-auto">
                    <form action="{{ route('wallet.recharge') }}" class="form-default" role="form" method="POST"
                        id="package-payment-form">
                        @csrf
                        <input type="hidden" id="payment_type" value="">

                        <div class="card shadow-none">
                            <div class="card-header p-3">
                                <h3 class="fs-16 fw-600 mb-0">
                                    {{ translate('Select a payment option') }}
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-10 col-xl-10 mx-auto">
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label">{{ translate('Amount') }}<span
                                                    class="text-danger"> *</span></label>
                                            <div class="col-md-10">
                                                <input type="text" name="amount" id="amount" class="form-control"
                                                    placeholder="{{ translate('Amount') }}" required>
                                            </div>
                                        </div>
                                        <div class="row gutters-10">
                                            @if (get_setting('paypal_payment_activation') == 1)
                                                <div class="col-4 col-md-2">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="paypal" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/payment_method/paypal.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Paypal') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('stripe_payment_activation') == 1)
                                                <div class="col-4 col-md-2">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="stripe" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/payment_method/stripe.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Stripe') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('instamojo_payment_activation') == 1)
                                                <div class="col-4 col-md-2">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="instamojo" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/payment_method/instamojo.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Instamojo') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('razorpay_payment_activation') == 1)
                                                <div class="col-4 col-md-2">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="razorpay" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/payment_method/rozarpay.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Razorpay') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('paystack_payment_activation') == 1)
                                                <div class="col-4 col-md-2">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="paystack" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/payment_method/paystack.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Paystack') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('paytm_payment_activation') == 1)
                                                <div class="col-4 col-md-2">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="paytm" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/payment_method/paytm.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Paytm') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('aamarpay_payment_activation') == 1)
                                                <div class="col-4 col-md-2">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="aamarpay" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/payment_method/aamarpay.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Aamarpay') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('sslcommerz_payment_activation') == 1)
                                                <div class="col-4 col-md-2">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="sslcommerz" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/payment_method/sslcommerz.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Sslcommerz') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif

                                            @foreach ($manual_payments as $method)
                                                <div class="col-4 col-md-2">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input type="hidden" name="manual_payment_id"
                                                            value="{{ $method->id }}">
                                                        <input value="manual_payment" class="manual_payment"
                                                            id="payment_option" type="radio"
                                                            data-method-id="{{ $method->id }}" name="payment_option"
                                                            onchange="toggleManualPaymentData({{ $method->id }})">
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ uploaded_asset($method->photo) }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ $method->heading }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    @foreach ($manual_payments as $method)
                                        <div id="manual_payment_info_{{ $method->id }}" class="d-none col-6 col-md-4">

                                            <div>@php echo $method->description @endphp</div>
                                            @if ($method->bank_info != null)
                                                <ul>
                                                    @foreach (json_decode($method->bank_info) as $key => $info)
                                                        <li style="list-style: none ">
                                                            {{ translate('Bank Name') }} -{{ $info->bank_name }}
                                                        </li>
                                                        <li style="list-style: none ">
                                                            {{ translate('Account Name') }} - {{ $info->account_name }},
                                                        </li>
                                                        <li style="list-style: none ">
                                                            {{ translate('Account Number') }} -{{ $info->account_number }}
                                                        </li>
                                                        <li style="list-style: none ">
                                                            {{ translate('Routing Number') }} -
                                                            {{ $info->routing_number }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="card mb-3 p-3 d-none w-100 manual_payment_description">
                                        <div id="manual_payment_description">

                                        </div>
                                    </div>

                                    <div class="col-md-10 mx-auto d-none" id="purchase_by_manual_payment">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>{{ translate('Transaction Id') }}<span class="text-danger">
                                                        *</span></label>
                                                <input type="text" name="transaction_id" id="transaction_id"
                                                    class="form-control" placeholder="{{ translate('Transaction Id') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>{{ translate('Payment Proof') }}<span class="text-danger">
                                                        *</span></label>
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="payment_proof" id="payment_proof"
                                                        class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label>{{ translate('Payment Details') }}</label>
                                                <textarea type="text" name="payment_details" class="form-control" rows="2"
                                                    placeholder="{{ translate('Payment Details') }}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" text-right pt-3">
                            <button type="button" onclick="package_purchase(this)"
                                class="btn btn-primary fw-600 purchase_button"
                                disabled>{{ translate('Confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function package_purchase(el) {
            $(el).prop('disabled', true);

            var amount = $("#amount").val();
            if (amount != '') {
                var payment_type = $("#payment_type").val();
                if (payment_type == 'manual_payment' && amount != '') {
                    var transaction_id = $("#transaction_id").val();
                    var payment_proof = $("#payment_proof").val();
                    if (transaction_id == '' || payment_proof == '') {
                        AIZ.plugins.notify('danger',
                            '{{ translate('Please Provide transaction id and payemnt proof.') }}');
                        $(el).prop('disabled', false);
                    } else {
                        $('#package-payment-form').submit();
                    }
                } else {
                    $('#package-payment-form').submit();
                }
            } else {
                AIZ.plugins.notify('danger', '{{ translate('Please add wallet recharge amount first.') }}');
                $(el).prop('disabled', false);
            }
        }

        // 

        $(".online_payment").click(function() {
            $('.manual_payment_description').addClass('d-none');
            $('#purchase_by_manual_payment').addClass('d-none');
            $(".purchase_button").prop('disabled', false);
            $("#payment_type").val('online_payment');
        });
        $(".manual_payment").click(function() {
            $('.manual_payment_description').removeClass('d-none');
            $(".purchase_button").prop('disabled', false);
        });

        function toggleManualPaymentData(id) {
            $('#manual_payment_description').parent().removeClass('d-none');
            $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
            $('#purchase_by_manual_payment').removeClass('d-none');
            $('.manual_payment_id').val(id)

        }
    </script>
@endsection
