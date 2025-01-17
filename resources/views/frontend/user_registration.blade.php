@extends('frontend.layouts.app')

@section('content')
<div class="py-4 py-lg-5">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-6 col-md-8 mx-auto">
				<div class="card">
					<div class="card-body">

						<div class="mb-5 text-center">
							<h1 class="h3 text-primary mb-0">{{ translate('Create Your Account') }}</h1>
							<p>{{ translate('Fill out the form to get started') }}.</p>
						</div>
						<form class="form-default" id="reg-form" role="form" action="{{ route('registerNew') }}" enctype="multipart/form-data" method="POST">
							@csrf
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="on_behalf">{{ translate('On Behalf') }}</label>
										@php $on_behalves = \App\Models\OnBehalf::all(); @endphp
										<select class="form-control aiz-selectpicker @error('on_behalf') is-invalid @enderror" name="on_behalf" required>
											@foreach ($on_behalves as $on_behalf)
											<option value="{{$on_behalf->id}}">{{$on_behalf->name}}</option>
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
										<label class="form-label" for="name">{{ translate('First Name') }}</label>
										<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="{{translate('First Name')}}" required>
										@error('first_name')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="name">{{ translate('Last Name') }}</label>
										<input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" placeholder="{{ translate('Last Name') }}" required>
										@error('last_name')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="gender">{{ translate('Gender') }}</label>
										<select class="form-control aiz-selectpicker @error('gender') is-invalid @enderror" name="gender" required>
											<option value="1">{{translate('Male')}}</option>
											<option value="2">{{translate('Female')}}</option>
										</select>
										@error('gender')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="name">{{ translate('Date Of Birth') }}</label>
										<input type="text" class="form-control aiz-date-range @error('date_of_birth') is-invalid @enderror" name="date_of_birth" id="date_of_birth" placeholder="{{ translate('Date Of Birth') }}" data-single="true" data-show-dropdown="true" data-max-date="{{ get_max_date() }}" autocomplete="off" required>
										@error('date_of_birth')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="email">{{ translate('Email address') }}</label>
										<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="signinSrEmail" placeholder="{{ translate('Email Address') }}" required>
										@error('email')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="phone">{{ translate('Mobile number') }}</label>
										<input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="{{ translate('Mobile Number') }}" maxlength="10" minlength="10" oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);" required>
										@error('phone')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
							<h6 class="text-dark">{{ ('Please pay ₹900 using the QR code below and share your payment transaction number and receipt to successfully register on the portal.') }}</h6>
							<div class="row" style="align-items: center;">
								<div class="col-lg-6">
									<div id="qr_code_div">
										<label for="payment" class="form-label">QR Code</label>
										<div class="custom-qr-code">
											<img src="{{ static_asset('assets/img/payment_qr.jpg') }}" alt="QR Code" width="100%" height="auto"
												id="custom-qr-code-image">
										</div>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="transaction_number">{{ ('Transaction Number') }}</label>
										<input type="number" class="form-control @error('transaction_number') is-invalid @enderror" required name="transaction_number" id="transaction_number" placeholder="{{('Transaction Number') }}">
										@error('transaction_number')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>

									<label for="payment" class="form-label">Payment receipt</label>
									<div class="upload-box">
										<input type="file" accept="image/*" aria-required="true" required  class="form-control" id="image-inputs" name="transaction_receipt" required onchange="previewImage(event)">
										<button type="button" id="remove-images" class="remove-image" style="display:none;" title="Remove Image" onclick="removeImage()">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" class="bi bi-x-circle" viewBox="0 0 16 16">
												<path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.646 9.354a.5.5 0 0 1-.707 0L8 8.707l-2.939 2.939a.5.5 0 1 1-.707-.707l2.939-2.939L4.354 5.354a.5.5 0 1 1 .707-.707L8 7.293l2.939-2.939a.5.5 0 1 1 .707.707L8.707 8l2.939 2.939a.5.5 0 0 1 0 .707z"></path>
											</svg>
										</button>
										<img id="preview-images" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
										<!-- Add a cross (X) icon for removing the uploaded image -->
									</div>
								</div>

							</div>
							<!-- 
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="transaction_number">{{ ('Transaction Number') }}</label>
										<input type="number" class="form-control @error('transaction_number') is-invalid @enderror" name="transaction_number" id="transaction_number" placeholder="{{('Transaction Number') }}">
										@error('email')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>


								<div class="col-md-6 mb-3">
									<label for="payment" class="form-label">Payment receipt</label>
									<div class="upload-box">
										<input type="file" accept="image/*" class="form-control" id="image-inputs"
											name="payment_picture" required>
										<img id="preview-images" src="#" alt="Image Preview"
											style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
										
										<button type="button" id="remove-images" class="remove-image"
											style="display:none;" title="Remove Image">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red"
												class="bi bi-x-circle" viewBox="0 0 16 16">
												<path
													d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.646 9.354a.5.5 0 0 1-.707 0L8 8.707l-2.939 2.939a.5.5 0 1 1-.707-.707l2.939-2.939L4.354 5.354a.5.5 0 1 1 .707-.707L8 7.293l2.939-2.939a.5.5 0 1 1 .707.707L8.707 8l2.939 2.939a.5.5 0 0 1 0 .707z">
												</path>
											</svg>
										</button>
									</div>
								</div>
							</div> -->
							<div class="mb-3">
								<label class="aiz-checkbox">
									<input type="checkbox" name="checkbox_example_1" required>
									<span class=opacity-60>{{ translate('By signing up you agree to our')}}
										<a href="{{ env('APP_URL').'/terms-conditions' }}" target="_blank">{{ translate('terms and conditions')}}.</a>
									</span>
									<span class="aiz-square-check"></span>
								</label>
							</div>
							@error('checkbox_example_1')
							<span class="invalid-feedback" role="alert">{{ $message }}</span>
							@enderror

							<div class="mb-5">
								<button type="submit" class="btn btn-block btn-primary">{{ translate('Create Account') }}</button>
							</div>

							<div class="text-center">
								<p class="text-muted mb-0">{{ translate("Already have an account?") }}</p>
								<a href="{{ route('login') }}">{{ translate('Login to your account') }}</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

<script>
    // This function handles the image preview and removal
    function setupImageInput(inputId, previewId, removeButtonId) {
        const imageInput = document.getElementById(inputId);
        const previewImage = document.getElementById(previewId);
        const removeButton = document.getElementById(removeButtonId);

        // Handle image selection
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block'; // Show the preview image
                    removeButton.style.display = 'inline-block'; // Show the remove button
                };
                reader.readAsDataURL(file);
            } else {
                resetPreview(previewImage, removeButton);
            }
        });

        // Handle image removal
        removeButton.addEventListener('click', function() {
            resetPreview(previewImage, removeButton);
            imageInput.value = ''; // Reset the input field
        });
    }

    // Reset preview and hide the remove button
    function resetPreview(previewImage, removeButton) {
        previewImage.src = '#';
        previewImage.style.display = 'none';
        removeButton.style.display = 'none';
    }

    // Initialize image input handlers for multiple images
    document.addEventListener('DOMContentLoaded', function() {
        setupImageInput('image-inputs', 'preview-images', 'remove-images');
    });
</script>