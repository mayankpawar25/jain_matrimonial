@extends('frontend.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ static_asset('assets/css/registration.css') }}">

<script src="{{ static_asset('assets/js/keyboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
.calendar-container {
            position: relative;
            display: inline-block;
        }
        .calendar-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        </style>


<!-- resources/views/form.blade.php -->
<div class="d-flex align-items-center justify-content-center bg-light" style="min-height: 100vh;">
    <div class="form-wizard p-4 bg-white shadow rounded">
        <h1 class="text-center mb-2" style="font-weight: bold; color: #ee2098;">अपनी जानकारी यहाँ डाले</h1>

        <form action="{{ route('form.resgistration_store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Step 1 -->
            <div class="form-step active" id="step-1">
                <h5 class="form-label" style="font-weight: bold; color: #000000;">प्रत्याशी की जानकारी</h5>

                <!-- Form Fields -->
                <div class="mb-3">
                    <label for="name" class="form-label">प्रत्यशी का नाम</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="email" class="form-label">ईमेल आईडी</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mobile" class="form-label">मोबाइल नंबर</label>
                        <input type="tel" class="form-control" pattern="[0-9]{10}" name="mobile" id="mobile" placeholder="" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">मांगलिक</label>
                        <div class="d-flex justify-content-start form-control">
                            <div class="form-check mr-3">
                                <input class="form-check-input " type="radio" name="marriage" id="yes" value="yes">
                                <label class="form-check-label " for="yes">हा</label>
                            </div>
                            <div class="form-check mr-3">
                                <input class="form-check-input" type="radio" name="marriage" id="no" value="no">
                                <label class="form-check-label" for="no">नहीं</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="marriage" id="maybe" value="aanshik">
                                <label class="form-check-label" for="maybe">आंशिक</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="mb-3 calendar-container">
                            <label for="doc_date" class="form-label">जन्म तिथि</label>
                            <input type="text" class="form-control" name="doc_date" id="doc_date" placeholder="dd-mm-yyyy" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="time" class="form-label">समय</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                    <div class="col-md-4">
                        <label for="ampm" class="form-label">AM/PM</label>
                        <select class="form-select form-control" id="ampm">
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="placeOfBirth" class="form-label">जन्म स्थान</label>
                        <input type="text" class="form-control" id="placeOfBirth" name="place_of_birth" required>
                    </div>
                    <div class="col-md-3">
                        <label for="state" class="form-label">राज्य</label>
                        <input type="text" class="form-control" id="state" name="state" required>
                    </div>
                    <div class="col-md-3">
                        <label for="gotraSelf" class="form-label">गोत्र स्व</label>
                        <input type="text" class="form-control" id="gotraSelf" name="gotra_self" required>
                    </div>
                    <div class="col-md-3">
                        <label for="gotraMama" class="form-label">गोत्र मामा</label>
                        <input type="text" class="form-control" id="gotraMama" name="gotra_mama" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="caste" class="form-label">जाति</label>
                        <input type="text" class="form-control" id="caste" name="cast" required>
                    </div>
                    <div class="col-md-6">
                        <label for="subCaste" class="form-label">उपजाति</label>
                        <input type="text" class="form-control" id="subCaste" name="subcaste" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="weight" class="form-label">वज़न</label>
                        <input type="number" class="form-control" id="weight" name="weight" required>
                    </div>
                    <div class="col-md-3">
                        <label for="height" class="form-label">ऊंचाई</label>
                        <input type="number" class="form-control" id="height" name="height" required>
                    </div>
                    <div class="col-md-3">
                        <label for="complexion" class="form-label">वर्ण</label>
                        <input type="text" class="form-control" id="complexion" name="complexion" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">श्रेणी</label>
                        <select class="form-select form-control" id="category" name="category" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-9">
                        <label for="residence" class="form-label">निवास</label>
                        <input type="text" class="form-control" id="residence" placeholder="house" name="residence" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">शारीरिक दोष</label>
                        <div class="d-flex form-control justify-content-start">
                            <div class="form-check mr-3">
                                <input class="form-check-input" type="radio" name="dosh" id="dosh-yes" value="yes">
                                <label class="form-check-label" for="dosh-yes">हा</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="dosh" id="dosh-no" value="no">
                                <label class="form-check-label" for="dosh-no">नहीं</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="education" class="form-label">शिक्षा</label>
                        <input type="text" class="form-control" id="education" name="education" required>
                    </div>
                    <div class="col-md-3">
                        <label for="occupation" class="form-label">व्यवसाय</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" required>
                    </div>
                    <div class="col-md-3">
                        <label for="name_of_org" class="form-label">सस्थान का नाम</label required>
                        <input type="text" class="form-control" id="name_of_org" name="name_of_org">
                    </div>
                    <div class="col-md-3">
                        <label for="annual_income" class="form-label">वार्षिक आय</label>
                        <input type="text" class="form-control" id="annual_income" name="annual_income">
                    </div>
                </div>
                <button type="button" class="btn btn-next width"
                    style="width: 100%; background-color: rgb(240, 53, 162); border: none; color: white;"
                    onclick="showStep(2)">आगे</button>


            </div>

            <!-- Step 2 -->
            <div class="form-step" id="step-2">
                <h5 style="font-weight: bold; color: #000000;">पारिवारिक विवरण</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="fathername" class="form-label">पिता का नाम</label>
                        <input type="text" class="form-control" id="fatherName" name="" required>
                    </div>
                    <div class="col-md-3">
                        <label for="mob" class="form-label">मोबाइल नंबर</label>
                        <input type="tel" class="form-control" id="mob" pattern="[0-9]{10}" name="father_mobile" required>
                    </div>
                    <div class="col-md-3">
                        <label for="work" class="form-label">व्यवसाय</label>
                        <input type="text" class="form-control" id="work" name="father_occupation" required>
                    </div>
                    <div class="col-md-3">
                        <label for="father_income" class="form-label">वार्षिक आय</label>
                        <input type="text" class="form-control" id="income" name="father_income">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="mothername" class="form-label">माँ का नाम</label>
                        <input type="text" class="form-control" id="mothername" required>
                    </div>
                    <div class="col-md-3">
                        <label for="mob2" class="form-label">मोबाइल नंबर</label>
                        <input type="tel" class="form-control" pattern="[0-9]{10}" name="mother_mobile" id="mob2" required>
                    </div>
                    <div class="col-md-3">
                        <label for="work2" class="form-label">व्यवसाय</label>
                        <input type="text" class="form-control" id="work2" name="mobile_occupation">
                    </div>
                    <div class="col-md-3">
                        <label for="income2" class="form-label">वार्षिक आय</label>
                        <input type="text" class="form-control" id="income2" name="mother_income">
                    </div>
                    
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <label for="addres" class="form-label">स्थायी पता</label>
                        <input type="text" class="form-control" id="addres" name="permanent_address" placeholder="">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="sibling" class="form-label">भाई /बहन का विवरण</label>
                        <input type="text" class="form-control" id="sibling" name="sibling" placeholder="">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="married-brother" class="form-label">विवाहित भाई</label>
                        <input type="text" class="form-control" id="married-brother" name="married_brother">
                    </div>
                    <div class="col-md-3">
                        <label for="unmarried-brother" class="form-label">अविवाहित भाई</label>
                        <input type="text" class="form-control" id="unmarried-brother" name="unmarried_brother">
                    </div>
                    <div class="col-md-3">
                        <label for="married-sister" class="form-label">विवाहित बहन</label>
                        <input type="text" class="form-control" id="married-sister" name="married_sister">
                    </div>
                    <div class="col-md-3">
                        <label for="unmarried-sister" class="form-label">अविवाहित बहन</label>
                        <input type="text" class="form-control" id="unmarried-sister" name="unmarried_sister">
                    </div>
                    
                    
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <label for="contact" class="form-label">सम्पर्क सूत्र</label>
                        <input type="text" class="form-control" id="contact" placeholder="" name="contact" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <label for="social-group" class="form-label">सोशल ग्रुप से सम्बन्धता हे? तो ग्रूप का नाम</label>
                        <input type="text" class="form-control" id="social-group" name="social_group" placeholder="">
                    </div>
                </div>

                <div class="container my-5">
                    <label for="payment" class="form-label">
                        फोटो अपलोड</label>
                    <div class="custom-upload-box">
                        <input type="file" accept="image/*" class="form-control" id="image-input" name="profile_picture">
                        <div class="custom-upload-icon">

                            <svg height="50" width="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 3v12"></path>
                                <path d="M6 9l6-6 6 6"></path>
                                <path d="M6 21h12a2 2 0 0 0 2-2v-6H4v6a2 2 0 0 0 2 2z"></path>
                            </svg>
                        </div>
                        <img id="preview-image" src="#" alt="Image Preview"
                            style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
                    </div>
                </div>





                <div class="container my-5">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="payment" class="form-label">
                                भुगतान रसीद</label>
                            <div class="upload-box">
                                <input type="file" accept="image/*" class="form-control" id="image-inputs"  name="payment_picture">
                                <div class="upload-icon">

                                    <svg height="50" width="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 3v12"></path>
                                        <path d="M6 9l6-6 6 6"></path>
                                        <path d="M6 21h12a2 2 0 0 0 2-2v-6H4v6a2 2 0 0 0 2 2z"></path>
                                    </svg>
                                </div>
                                <img id="preview-images" src="#" alt="Image Previews"
                                    style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="custom-input-row">
                                <div class="form-group mb-3">
                                    <label for="payment" class="form-label">भुगतान</label>
                                    <select class="form-select form-control" id="payment" name="payment_type">
                                        <option value="">-</option>
                                        <option value="General Listing">General Listing</option>
                                        <option value="Half-Page Listing">Half-Page Listing</option>
                                        <option value="Full-Page Listing">Full-Page Listing</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="total-payment" class="form-label">कुल भुगतान</label>
                                    <input type="number" class="form-control" id="total-payment" name="total_payment" readonly>
                                </div>
                            </div>
                            <div class="custom-input-row">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="courier" class="form-label">कूरियर द्वारा स्मारिका</label>
                                        <input type="text" class="form-control" id="courier" readonly>
                                        <div class="form-check mt-2">
                                            <input type="checkbox" class="form-check-input" id="courier-checkbox" name="is_courier">
                                            <label class="form-check-label" for="courier-checkbox">चेक करें</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="payment-mode" class="form-label">पेमेंट मॉड</label>
                                        <input type="text" class="form-control" id="payment-mode" name="payment_mode" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="payment" class="form-label">क्यू आर संहिता</label>
                            <div class="custom-qr-code">
                                <img src="{{ static_asset('assets/img/payment_qr.jpg') }}" alt="QR Code"
                                    id="custom-qr-code-image">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Additional Fields <img src="assets/img/shared%20image.jpg" alt="Description of image"> -->

                <div class="row mb-6">
                    <div class="col-md-6 d-flex justify-content-center">
                        <button type="button" class="btn btn-primary"
                            style="width: 100%; background-color: rgb(156, 153, 155); border: none; color: white;"
                            onclick="showStep(1)">पीछे</button>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary"
                            style="width: 100%; background-color: rgb(240, 53, 162); border: none; color: white;">जमा
                            करें</button>
                    </div>
                </div>
            </div>
        </form>
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
    //for image upload
    document.getElementById('image-input').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('preview-image');

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block'; // Show the image preview
            };

            reader.readAsDataURL(file);
        } else {
            previewImage.src = '#'; // Reset image src if no file is selected
            previewImage.style.display = 'none'; // Hide the image preview
        }
    });


    // seconf image 

    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('image-inputs');
        const previewImage = document.getElementById('preview-images');

        imageInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block'; // Show the image
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.src = '#';
                previewImage.style.display = 'none'; // Hide the image if no file is selected
            }
        });
    });



    // Handle payment selection
    document.addEventListener('DOMContentLoaded', () => {
        const paymentSelect = document.getElementById('payment');
        const totalPaymentInput = document.getElementById('total-payment');
        const courierInput = document.getElementById('courier');
        const courierCheckbox = document.getElementById('courier-checkbox');

        function updateTotalPayment() {
            let paymentValue = paymentSelect.value;
            let paymentAmount = 0;
            let courierAmount = courierCheckbox.checked ? 150 : 0;

            switch (paymentValue) {
                case 'General Listing':
                    paymentAmount = 800;
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

            totalPaymentInput.value = paymentAmount + courierAmount;
        }

        paymentSelect.addEventListener('change', updateTotalPayment);

        courierCheckbox.addEventListener('change', () => {
            courierInput.value = courierCheckbox.checked ? '150' : '';
            updateTotalPayment();
        });

        // Initial update to handle the default state
        updateTotalPayment();
    });



    // Show the step and validate fields
    function showStep(step) {
        // Validate required fields in step 1 before proceeding
        if (step === 2) {
            const step1Fields = document.querySelectorAll('#step-1 [required]');
            let isValid = true;

            // Loop through required fields in Step 1
            step1Fields.forEach((field) => {
                if (!field.value) {
                    isValid = false;
                    field.classList.add('is-invalid'); // Highlight invalid field
                } else {
                    field.classList.remove('is-invalid'); // Remove highlight if valid
                }
            });

            // Prevent moving to Step 2 if any required field is not filled
            if (!isValid) {
                // alert('Please fill all required fields in Step 1 before proceeding.');
                return;
            }
        }

        // If all required fields are filled, proceed to the next step
        document.querySelectorAll('.form-step').forEach((el) => {
            el.classList.remove('active');
        });
        document.getElementById(`step-${step}`).classList.add('active');
    }
</script>

@endsection