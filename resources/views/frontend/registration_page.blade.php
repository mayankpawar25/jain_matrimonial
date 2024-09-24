@extends('frontend.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ static_asset('assets/css/registration.css') }}">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



<!-- resources/views/form.blade.php -->
<div class="py-5 mt-5 py-lg-5 mt-2">
    <div class="containter">
        <div class="row">
            <div class="form-wizard p-4 bg-white shadow rounded">
                <h1 class="text-center mb-2" style="font-weight: bold; color: #ee2098;">अपनी जानकारी यहाँ डाले</h1>
                <p class="text-center "><strong>* कृपया फॉर्म हिंदी में भरे</strong> </p>

                <form action="{{ route('form.resgistration_store') }}" method="POST" id="registration-form"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1 -->
                    <div class="form-step active" id="step-1">
                        <h5 class="form-label" style="font-weight: bold; color: #000000;">प्रत्याशी की जानकारी</h5>

                        <!-- Form Fields -->
                        <div class="mb-3">
                            <label for="name" class="form-label">प्रत्यशी का नाम</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="" required>
                        </div>
                        <div class="row ">
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">ईमेल आईडी</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder=""
                                    required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="mobile" class="form-label">मोबाइल नंबर</label>
                                <input type="tel" class="form-control" pattern="^(?:\+?[0-9]{1,3})?0?[0-9]{10}$"
                                    name="mobile" id="mobile" placeholder="" maxlength="10" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">मांगलिक</label>
                                <div class="d-flex justify-content-start form-control">
                                    <div class="form-check mr-3">
                                        <input class="form-check-input " type="radio" name="marriage" id="yes"
                                            value="yes" >
                                        <label class="form-check-label " for="yes">हाँ</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" name="marriage" id="no" value="no" >
                                        <label class="form-check-label" for="no">नहीं</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="marriage" id="maybe"
                                            value="aanshik">
                                        <label class="form-check-label" for="maybe">आंशिक</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-4 mb-3">
                                <!-- <div class="calendar-container"> -->
                                <label for="doc_date" class="form-label">जन्म तिथि</label>
                                <input type="text" class="form-control" name="doc_date" id="doc_date"
                                    placeholder="dd-mm-yyyy" required>
                                <!-- </div> -->
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="time" class="form-label">समय</label>
                                <input type="time" class="form-control" id="time" name="time" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ampm" class="form-label">नागरिकता</label>
                                <select class="form-select form-control" id="citizenship" name="citizenship" required>
                                    <option value="भारतीय">भारतीय</option>
                                    <option value="अप्रवासी भारतीय">अप्रवासी भारतीय</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <label for="place_of_birth" class="form-label">जन्म स्थान</label>
                                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="state" class="form-label">राज्य</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="gotra_self" class="form-label">गोत्र स्व</label>
                                <input type="text" class="form-control" id="gotraSelf" name="gotra_self" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="gotra_mama" class="form-label">गोत्र मामा</label>
                                <input type="text" class="form-control" id="gotraMama" name="gotra_mama" required>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-6 mb-3">
                                <label for="caste" class="form-label">जाति</label>
                                <input type="text" class="form-control" id="caste" name="caste" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subcaste" class="form-label">उपजाति</label>
                                <input type="text" class="form-control" id="subCaste" name="subcaste" required>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <label for="weight" class="form-label">वज़न</label>
                                <input type="number" class="form-control" id="weight" name="weight" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="height" class="form-label">ऊंचाई</label>
                                <input type="number" class="form-control" id="height" name="height" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="complexion" class="form-label">वर्ण</label>
                                <select class="form-select form-control" id="complexion" name="complexion" required>
                                    <option value="गोरा">गोरा</option>
                                    <option value="गेहुँआ">गेहुँआ</option>
                                    <option value="सांवला">सांवला</option>
                                    <option value="श्याम">श्याम</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">श्रेणी</label>
                                <select class="form-select form-control" id="category" name="category" required>
                                    <option value="अविवाहित">अविवाहित</option>
                                    <option value="तलाकशुदा">तलाकशुदा</option>
                                    <option value="विधवा">विधवा</option>
                                    <option value="विधुर">विधुर</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-9 mb-3">
                                <label for="residence" class="form-label">निवास</label>
                                <input type="text" class="form-control" id="residence"  name="residence" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">शारीरिक दोष</label>
                                <div class="d-flex form-control justify-content-start">
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" name="dosh" id="dosh-yes"
                                            value="yes">
                                        <label class="form-check-label" for="dosh-yes">हाँ</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="dosh" id="dosh-no"
                                            value="no">
                                        <label class="form-check-label" for="dosh-no">नहीं</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <label for="education" class="form-label">शिक्षा</label>
                                <input type="text" class="form-control" id="education" name="education" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="occupation" class="form-label">व्यवसाय</label>
                                <input type="text" class="form-control" id="occupation" name="occupation" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="name_of_org" class="form-label">सस्थान का नाम</label required>
                                <input type="text" class="form-control" id="name_of_org" name="name_of_org">
                            </div>
                            <div class="col-md-3 mb-3">
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
                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <label for="fathername" class="form-label">पिता का नाम</label>
                                <input type="text" class="form-control" id="fatherName" name="father_name" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="mob" class="form-label">मोबाइल नंबर</label>
                                <input type="tel" class="form-control" id="mob"
                                    pattern="^(?:\+?[0-9]{1,3})?0?[0-9]{10}$" name="father_mobile" maxlength="10"
                                    required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="work" class="form-label">व्यवसाय</label>
                                <input type="text" class="form-control" id="work" name="father_occupation" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="father_income" class="form-label">वार्षिक आय</label>
                                <input type="text" class="form-control" id="father_income" name="father_income">
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <label for="mothername" class="form-label">माँ का नाम</label>
                                <input type="text" class="form-control" id="mothername" name="mothername" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="mob2" class="form-label">मोबाइल नंबर</label>
                                <input type="tel" class="form-control" pattern="^(?:\+?[0-9]{1,3})?0?[0-9]{10}$"
                                    name="mother_mobile" id="mob2" maxlength="10" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="mother_occupation" class="form-label">व्यवसाय</label>
                                <input type="text" class="form-control" id="work2" name="mother_occupation">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="mother_income" class="form-label">वार्षिक आय</label>
                                <input type="text" class="form-control" id="mother_income" name="mother_income">
                            </div>

                        </div>
                        <div class="row ">
                            <div class="col-md-12 mb-3">
                                <label for="permanent_address" class="form-label">स्थायी पता</label>
                                <input type="text" class="form-control" id="addres" name="permanent_address" placeholder="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="sibling" class="form-label">भाई /बहन का विवरण</label>
                                <input type="text" class="form-control" id="sibling" name="sibling" placeholder="">
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-3 mb-3">
                                <label for="married-brother" class="form-label">विवाहित भाई</label>
                                <input type="text" class="form-control" id="married-brother" name="married_brother">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="unmarried-brother" class="form-label">अविवाहित भाई</label>
                                <input type="text" class="form-control" id="unmarried-brother" name="unmarried_brother">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="married-sister" class="form-label">विवाहित बहन</label>
                                <input type="text" class="form-control" id="married-sister" name="married_sister">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="unmarried-sister" class="form-label">अविवाहित बहन</label>
                                <input type="text" class="form-control" id="unmarried-sister" name="unmarried_sister">
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12 mb-3">
                                <label for="contact" class="form-label">सम्पर्क सूत्र</label>
                                <input type="text" class="form-control" id="contact" placeholder="" name="contact" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="social-group" class="form-label">सोशल ग्रुप से सम्बन्धता हे? तो ग्रूप का
                                    नाम</label>
                                <input type="text" class="form-control" id="social-group" name="social_group" placeholder="">
                            </div>
                        </div>

                        <div class="container my-5">
                            <label for="payment" class="form-label">फोटो अपलोड</label>
                            <div class="custom-upload-box" style="position: relative;">
                                <input type="file" accept="image/*" class="form-control" id="image-input" name="profile_picture" required>
                                <div class="custom-upload-icon">
                                    <svg height="50" width="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 3v12"></path>
                                        <path d="M6 9l6-6 6 6"></path>
                                        <path d="M6 21h12a2 2 0 0 0 2-2v-6H4v6a2 2 0 0 0 2 2z"></path>
                                    </svg>
                                </div>
                                <img id="preview-image" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: auto; margin-top: 10px;">

                                <!-- Cross (X) icon as remove button -->
                                <button id="remove-image" class="remove-image"  style="display:none;" title="Remove Image">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" class="bi bi-x-circle" viewBox="0 0 16 16">
                                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.646 9.354a.5.5 0 0 1-.707 0L8 8.707l-2.939 2.939a.5.5 0 1 1-.707-.707l2.939-2.939L4.354 5.354a.5.5 0 1 1 .707-.707L8 7.293l2.939-2.939a.5.5 0 1 1 .707.707L8.707 8l2.939 2.939a.5.5 0 0 1 0 .707z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>







                        <div class="container my-5">
                            <div class="row">


                                <div class="col-md-12 mb-3">
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
                                            <input type="number" class="form-control" id="total-payment"
                                                name="total_payment" readonly>
                                        </div>
                                    </div>
                                    <div class="row ">

                                        <div class="col-md-6 mb-3">
                                            <label for="courier_details" class="form-label">कूरियर द्वारा
                                                स्मारिका</label>
                                            <input type="text" class="form-control" id="courier_details"
                                                name="courier_details" readonly>
                                            <div class="form-check  mt-2">
                                                <input type="checkbox" class="form-check-input" id="courier-checkbox"
                                                    name="is_courier" value="1">
                                                <label class="form-check-label" for="courier-checkbox">चेक
                                                    करें</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="payment_mode" class="form-label">पेमेंट मॉड</label>
                                            <select class="form-select form-control" id="payment_mode"
                                                name="payment_mode" required>
                                                <!-- <option value="cash">Cash</option> -->
                                                <option value="qr_code">QR Code</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div id="qr_code_div">
                                        <label for="payment" class="form-label">क्यू आर संहिता</label>
                                        <div class="custom-qr-code">
                                            <img src="{{ static_asset('assets/img/payment_qr.jpg') }}" alt="QR Code"
                                                id="custom-qr-code-image">
                                        </div>
                                    </div>
                                    <div id="bank_transfer_div">
                                        <label for="payment" class="form-label">बैंक विवरण</label>
                                        <br>
                                        <label for="payment" class="form-label">बैंक : </label> बैंक ऑफ़ महाराष्ट्र
                                        <br>
                                        <label for="payment" class="form-label">अकाउण्ट नं. : </label> 60066639454
                                        <br>
                                        <label for="payment" class="form-label">IFSC Code : </label> MAHEO001765
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="payment" class="form-label">भुगतान रसीद</label>
                                    <div class="upload-box">
                                        <input type="file" accept="image/*" class="form-control" id="image-inputs" name="payment_picture" required>
                                        <div class="upload-icon">
                                            <svg height="50" width="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M12 3v12"></path>
                                                <path d="M6 9l6-6 6 6"></path>
                                                <path d="M6 21h12a2 2 0 0 0 2-2v-6H4v6a2 2 0 0 0 2 2z"></path>
                                            </svg>
                                        </div>
                                        <img id="preview-images" src="#" alt="Image Preview" style="display: none; max-width: 100%; height: auto; margin-top: 10px;">
                                        <!-- Add a cross (X) icon for removing the uploaded image -->
                                        <button id="remove-images" class="remove-image" style="display:none;" title="Remove Image">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="red" class="bi bi-x-circle"
                                                viewBox="0 0 16 16">
                                                <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.646 9.354a.5.5 0 0 1-.707 0L8 8.707l-2.939 2.939a.5.5 0 1 1-.707-.707l2.939-2.939L4.354 5.354a.5.5 0 1 1 .707-.707L8 7.293l2.939-2.939a.5.5 0 1 1 .707.707L8.707 8l2.939 2.939a.5.5 0 0 1 0 .707z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Additional Fields <img src="assets/img/shared%20image.jpg" alt="Description of image"> -->

                        <!-- condition start -->
                        <div class="container my-5">
                            <div class="row">
                                <div class="term_condition text-justify">
                                    हम शपथपूर्वक घोषणा करते हैं कि हमारे पुत्र/पुत्री के वैवाहिक सम्बन्ध हेतु दी गई
                                    जानकारी
                                    पूर्णतः सही व सत्य है एवं इसकी प्रमाणिकता के लिये हम स्वयं उत्तरदायी होंगे। आयोजक
                                    संस्था
                                    व पदाधिकारी किसी भी प्रकार से इस सम्बन्ध में उत्तरदायी नहीं होंगे। हम संस्था एवं
                                    उसके
                                    पदाधिकारियों को किसी भी प्रकार की क्षति/ वाद / दावा / विवाद से पूर्णतः मुक्त घोषित
                                    करते
                                    हैं। हम दिगम्बर जैन सोशल ग्रुप फेडरेशन द्वारा इस आयोजन के सम्बन्ध में समय-समय पर दी
                                    गई
                                    व्यवस्था / नियम / शर्तों का पूर्णतः पालन करेंगे। हम आयोजन संस्था को अनुमति प्रदान
                                    करते
                                    हैं कि इस अवसर पर प्रकाशित होने वाली परिचय पुस्तिका एवं सोशल मीडिया पर प्रचार-प्रसार
                                    हेतु उक्त विवरण का उपयोग कर सकेंगे।

                                    <p> <br>
                                        <label>
                                            <input type="checkbox" value="1" name="trem_condition" class="mr-2" required /> <strong>उक्त वर्णित सत्यापन
                                                मैनें पूर्णतः पढ़ व समझ लिया
                                                हैं</strong>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-6">
                            <div class="col-md-6 d-flex justify-content-center">
                                <button type="button" class="btn btn-primary"
                                    style="width: 100%; background-color: rgb(156, 153, 155); border: none; color: white;"
                                    onclick="showStep(1)">पीछे</button>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" id="submitButton"
                                    style="width: 100%; background-color: rgb(240, 53, 162); border: none; color: white;">
                                    <span id="buttonText">जमा करें</span>
                                    <span id="loader" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true" style="display:none;"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
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
    const imageInputPhoto = document.getElementById('image-input');
    const previewImagePhoto = document.getElementById('preview-image');
    const removeButtonPhoto = document.getElementById('remove-image');

    imageInputPhoto.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImagePhoto.src = e.target.result;
                previewImagePhoto.style.display = 'block'; // Show the image
                removeButtonPhoto.style.display = 'inline-block'; // Show the remove button
            };
            reader.readAsDataURL(file);
            imageInputPhoto.disabled = true; // Disable the input field after upload
        }
    });

    removeButtonPhoto.addEventListener('click', function() {
        previewImagePhoto.src = '#';
        previewImagePhoto.style.display = 'none';
        imageInputPhoto.value = '';
        imageInputPhoto.disabled = false;
        removeButtonPhoto.style.display = 'none';
    });


    // second image payment upload

    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image-inputs');
        const previewImage = document.getElementById('preview-images');
        const removeButton = document.getElementById('remove-images'); // Select the remove button

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block'; // Show the image
                    removeButton.style.display = 'inline-block'; // Show the remove button (cross icon)
                };
                reader.readAsDataURL(file);

                // Disable the input field after an image is uploaded
                imageInput.disabled = true;
            } else {
                previewImage.src = '#';
                previewImage.style.display = 'none'; // Hide the image if no file is selected
                removeButton.style.display = 'none'; // Hide the remove button
            }
        });

        // Add functionality for the remove button (cross icon)
        removeButton.addEventListener('click', function() {
            // Clear the image preview
            previewImage.src = '#';
            previewImage.style.display = 'none';

            // Enable the file input again
            imageInput.value = ''; // Reset the file input value
            imageInput.disabled = false; // Enable the file input

            // Hide the remove button
            removeButton.style.display = 'none';
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