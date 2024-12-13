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
        <div class="row">
            <div class="form-wizard p-4 bg-white shadow rounded">
                <h1 class="text-center mb-2" style="font-weight: bold; color: #ee2098;">अपनी जानकारी यहाँ डाले</h1>
                <!-- <p class="text-center "><strong>* कृपया फॉर्म हिंदी में भरे</strong> </p> -->
                <!-- Success Message Display -->
                <form action="{{ route('attendance.submit') }}" method="POST">
                    @csrf
                    <label for="mobile_number">Mobile Number:</label>
                    <input class="form-control" type="text" id="mobile_number" name="mobile_number"
                        value="{{ old('mobile_number') }}" required>

                    @error('mobile_number')
                    <p style="color: red;">{{ $message }}</p>
                    @enderror

                    @if(session('success'))
                    <p style="color: green;">{{ session('success') }}</p>
                    @endif
                    @if(session('info'))
                    <p style="color: blue;">{{ session('info') }}</p>
                    @endif
                    @if(session('error'))
                    <p style="color: red;">{{ session('error') }}</p>
                    @endif

                    <button class="btn btn-primary mt-3" style="float: right;" type="submit">Submit</button>
                </form>

                
                <div style="clear: both;"></div>
                <hr>

                <h3 class="text-center mb-2 mt-4" style="font-weight: bold;  line-height: 1.5;">किसी भी प्रकार की
                    जानकारी हेतु निम्न मोबाइल नंबरो पर संपर्क करें </h3>
                <h4 class="text-center"><a href="tel:+916232324246">62323 24246</a>, <a href="tel:+919425348014">94253
                        48014</a>, <a href="tel:+9194250 22806">94250 22806</a>, <a href="tel:+919926008080">99260
                        08080</a></h4>

            </div>

        </div>
       
    </div>

</div>

<script>
    // Show the step
    // function showStep(step) {
    //     document.querySelectorAll('.form-step').forEach((el) => {
    //         el.classList.remove('active');
    //     });
    //     document.getElementById(`step-${step}`).classList.add('active');
    // }

    //date
    flatpickr("#doc_date", {
        dateFormat: "d-m-Y",
        allowInput: true, // Allows manual input as well
    });

    // Function to open the date picker programmatically
    function openDatePicker() {
        const datePicker = document.querySelector("#doc_date")._flatpickr;
        if (datePicker) {
            datePicker.open();
        }
    }


    // Handling for 'फोटो अपलोड' section
    // const imageInputPhoto = document.getElementById('image-input');
    // const previewImagePhoto = document.getElementById('preview-image');
    // const removeButtonPhoto = document.getElementById('remove-image');

    // imageInputPhoto.addEventListener('change', function(event) {
    //     const file = event.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function(e) {
    //             previewImagePhoto.src = e.target.result;
    //             previewImagePhoto.style.display = 'block'; // Show the image
    //             removeButtonPhoto.style.display = 'inline-block'; // Show the remove button
    //         };
    //         reader.readAsDataURL(file);
    //         imageInputPhoto.disabled = true; // Disable the input field after upload
    //     }
    // });

    // removeButtonPhoto.addEventListener('click', function() {
    //     previewImagePhoto.src = '#';
    //     previewImagePhoto.style.display = 'none';
    //     imageInputPhoto.value = '';
    //     imageInputPhoto.disabled = false;
    //     removeButtonPhoto.style.display = 'none';
    // });


    // // second image payment upload

    // document.addEventListener('DOMContentLoaded', function() {
    //     const imageInput = document.getElementById('image-inputs');
    //     const previewImage = document.getElementById('preview-images');
    //     const removeButton = document.getElementById('remove-images'); // Select the remove button

    //     imageInput.addEventListener('change', function(event) {
    //         const file = event.target.files[0];
    //         if (file) {
    //             const reader = new FileReader();
    //             reader.onload = function(e) {
    //                 previewImage.src = e.target.result;
    //                 previewImage.style.display = 'block'; // Show the image
    //                 removeButton.style.display = 'inline-block'; // Show the remove button (cross icon)
    //             };
    //             reader.readAsDataURL(file);

    //             // Disable the input field after an image is uploaded
    //             imageInput.disabled = true;
    //         } else {
    //             previewImage.src = '#';
    //             previewImage.style.display = 'none'; // Hide the image if no file is selected
    //             removeButton.style.display = 'none'; // Hide the remove button
    //         }
    //     });

    //     // Add functionality for the remove button (cross icon)
    //     removeButton.addEventListener('click', function() {
    //         // Clear the image preview
    //         previewImage.src = '#';
    //         previewImage.style.display = 'none';

    //         // Enable the file input again
    //         imageInput.value = ''; // Reset the file input value
    //         imageInput.disabled = false; // Enable the file input

    //         // Hide the remove button
    //         removeButton.style.display = 'none';
    //     });
    // });


    // updated script
    // Handling for 'फोटो अपलोड' section
    // const imageInputPhoto = document.getElementById('image-input');
    // const previewImagePhoto = document.getElementById('preview-image');
    // const removeButtonPhoto = document.getElementById('remove-image');

    // imageInputPhoto.addEventListener('change', function (event) {
    //     const file = event.target.files[0];
    //     if (file) {
    //         const reader = new FileReader();
    //         reader.onload = function (e) {
    //             previewImagePhoto.src = e.target.result;
    //             previewImagePhoto.style.display = 'block'; // Show the image
    //             removeButtonPhoto.style.display = 'inline-block'; // Show the remove button
    //         };
    //         reader.readAsDataURL(file);
    //     } else {
    //         // Reset the preview if no file is selected
    //         resetPreview(previewImagePhoto, removeButtonPhoto);
    //     }
    // });

    // // Remove button functionality for 'फोटो अपलोड' section
    // removeButtonPhoto.addEventListener('click', function () {
    //     resetPreview(previewImagePhoto, removeButtonPhoto);
    //     imageInputPhoto.value = ''; // Reset the file input value
    // });

    // // Function to reset image preview and remove button display
    // function resetPreview(previewImage, removeButton) {
    //     previewImage.src = '#'; // Reset the image source
    //     previewImage.style.display = 'none'; // Hide the image
    //     removeButton.style.display = 'none'; // Hide the remove button
    // }


    const paymentSelect = document.getElementById('payment');
    const extraImageBox2 = document.getElementById('extra-image-box-2');
    const extraImageBox3 = document.getElementById('extra-image-box-3');

    function setupImageInput(inputId, previewId, removeButtonId) {
        const imageInput = document.getElementById(inputId);
        const previewImage = document.getElementById(previewId);
        const removeButton = document.getElementById(removeButtonId);

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    removeButton.style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            } else {
                resetPreview(previewImage, removeButton);
            }
        });

        removeButton.addEventListener('click', function() {
            resetPreview(previewImage, removeButton);
            imageInput.value = '';
        });
    }

    function resetPreview(previewImage, removeButton) {
        previewImage.src = '#';
        previewImage.style.display = 'none';
        removeButton.style.display = 'none';
    }

    // Initialize image input handlers
    setupImageInput('image-input-1', 'preview-image-1', 'remove-image-1');
    setupImageInput('image-input-2', 'preview-image-2', 'remove-image-2');
    setupImageInput('image-input-3', 'preview-image-3', 'remove-image-3');

    // Show/Hide additional image inputs based on selected listing type
    paymentSelect.addEventListener('change', function() {
        if (paymentSelect.value !== 'General Listing') {
            extraImageBox2.style.display = 'flex';
            extraImageBox3.style.display = 'flex';
        } else {
            extraImageBox2.style.display = 'none';
            extraImageBox3.style.display = 'none';
            resetPreview(document.getElementById('preview-image-2'), document.getElementById('remove-image-2'));
            resetPreview(document.getElementById('preview-image-3'), document.getElementById('remove-image-3'));
        }
    });

    // Second image payment upload
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image-inputs');
        const previewImage = document.getElementById('preview-images');
        const removeButton = document.getElementById('remove-images');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block'; // Show the image
                    removeButton.style.display = 'inline-block'; // Show the remove button
                };
                reader.readAsDataURL(file);
            } else {
                // Reset the preview if no file is selected
                resetPreview(previewImage, removeButton);
            }
        });

        // Remove button functionality for payment image upload
        removeButton.addEventListener('click', function() {
            resetPreview(previewImage, removeButton);
            imageInput.value = ''; // Reset the file input value
        });
    });


    // Handle payment selection
    document.addEventListener('DOMContentLoaded', () => {
        const paymentSelect = document.getElementById('payment');
        const totalPaymentInput = document.getElementById('total-payment');
        const courierInput = document.getElementById('courier_details');
        const courierCheckbox = document.getElementById('courier-checkbox');

        // Function to update the total payment
        function updateTotalPayment() {
            let paymentValue = paymentSelect.value;
            let paymentAmount = 0;
            let courierAmount = courierCheckbox.checked ? 150 : 0;

            switch (paymentValue) {
                case 'General Listing':
                    paymentAmount = 900;
                    break;
                case 'Half-Page Listing':
                    paymentAmount = 4000;
                    break;
                case 'Full-Page Listing':
                    paymentAmount = 8000;
                    break;
                default:
                    paymentAmount = 0;
            }

            // Update the total payment and courier fields
            totalPaymentInput.value = paymentAmount + courierAmount;
            courierInput.value = courierCheckbox.checked ? '150' : '';
        }

        // Event listeners to trigger the update function on changes
        paymentSelect.addEventListener('change', updateTotalPayment);
        courierCheckbox.addEventListener('change', updateTotalPayment);

        // Initial update to handle the default state
        updateTotalPayment();
    });



    // Show the step and validate fields
    function showStep(step) {
        // Validate required fields in step 1 before proceeding
        if (step === 2) {
            const step1Fields = document.querySelectorAll('#step-1 [required]');
            let isValid = true;
            let firstInvalidField = null;

            // Loop through required fields in Step 1
            step1Fields.forEach((field) => {
                if (!field.value) {
                    isValid = false;
                    field.classList.add('is-invalid'); // Highlight invalid field
                    if (!firstInvalidField) {
                        firstInvalidField = field; // Capture the first invalid field
                    }
                } else {
                    field.classList.remove('is-invalid'); // Remove highlight if valid
                }

                // Additional validation for specific field types
                if (field.type === 'email') {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailPattern.test(field.value)) {
                        isValid = false;
                        field.classList.add('is-invalid'); // Highlight invalid email
                        if (!firstInvalidField) {
                            firstInvalidField = field; // Capture the first invalid email field
                        }
                    } else {
                        field.classList.remove('is-invalid');
                    }
                }

                if (field.type === 'tel') {
                    const mobilePattern = /^(?:\+?[0-9]{1,3})?0?[0-9]{10}$/;
                    if (!mobilePattern.test(field.value)) {
                        isValid = false;
                        field.classList.add('is-invalid'); // Highlight invalid mobile number
                        if (!firstInvalidField) {
                            firstInvalidField = field; // Capture the first invalid email field
                        }
                    } else {
                        field.classList.remove('is-invalid');
                    }
                }

                if (field.type === 'number') {
                    if (field.value <= 0) {
                        isValid = false;
                        field.classList.add('is-invalid'); // Highlight invalid number
                        if (!firstInvalidField) {
                            firstInvalidField = field; // Capture the first invalid email field
                        }
                    } else {
                        field.classList.remove('is-invalid');
                    }
                }

                // Specific validation for height-feet and height-inches fields
                if (field.id === 'height-feet') {
                    const feetValue = parseInt(field.value, 10);
                    if (feetValue < 0 || feetValue > 7) { // Maximum 7 feet
                        isValid = false;
                        field.classList.add('is-invalid'); // Highlight invalid feet input
                        if (!firstInvalidField) {
                            firstInvalidField = field; // Capture the first invalid field
                        }
                    } else {
                        field.classList.remove('is-invalid');
                    }
                }

                // if (field.id === 'height-inches') {

                //     const inches = parseFloat(field.value);
                //     if(typeof inches === 'number'){
                //         if(inches % 1 === 0 || inches.toString().match(/^\d+(\.\d{1,2})?$/)){
                //             if (inches < 0 || inches > 11.99) { // Maximum 11 inches
                //                 isValid = false;
                //                 field.classList.add('is-invalid'); // Highlight invalid inches input
                //                 if (!firstInvalidField) {
                //                     firstInvalidField = field; // Capture the first invalid field
                //                 }
                //             } else {
                //                 field.classList.remove('is-invalid');
                //             }
                //         } else{
                //             // float
                //             isValid = false;
                //             field.classList.add('is-invalid'); 
                //         }
                //     }

                // }
            });

            // Prevent moving to Step 2 if any required field is not filled
            if (!isValid && firstInvalidField) {
                firstInvalidField.focus();
                return;
            }
        }

        // If all required fields are filled, proceed to the next step
        document.querySelectorAll('.form-step').forEach((el) => {
            el.classList.remove('active');
        });
        document.getElementById(`step-${step}`).classList.add('active');

        // Focus on the first input field of the new step
        const firstInputInStep = document.querySelector(`#step-${step} input`);
        if (firstInputInStep) {
            firstInputInStep.focus();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('registration-form');
        const submitButton = document.getElementById('submitButton');
        const loader = document.getElementById('loader');
        const buttonText = document.getElementById('buttonText');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Disable the submit button and show the loader
            submitButton.disabled = true; // Disable the button
            loader.style.display = 'inline-block'; // Show the loader
            buttonText.style.display = 'none'; // Hide the button text

            setTimeout(() => {
                form.submit();
            }, 300);
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('bank_transfer_div').style.display = 'none';
        document.getElementById('payment_mode').addEventListener('change', function() {
            var paymentMode = this.value;

            // Hide both divs initially
            document.getElementById('qr_code_div').style.display = 'none';
            document.getElementById('bank_transfer_div').style.display = 'none';

            // Show the relevant div based on the selected payment mode
            if (paymentMode === 'qr_code') {
                document.getElementById('qr_code_div').style.display = 'block';
            } else if (paymentMode === 'bank_transfer') {
                document.getElementById('bank_transfer_div').style.display = 'block';
            }
        });
    });
</script>

@endsection