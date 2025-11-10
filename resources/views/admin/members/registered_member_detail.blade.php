@extends('admin.layouts.app')

@section('content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Member Details') }}</h1>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-primary" onclick="printDiv('table-print')"> Print</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="table-print">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Details of') }} {{ $member->name }}</h5>

                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <tbody>
                            <tr style="background-color: var(--primary);color:white">
                                <th>{{translate('ID')}}</th>
                                <td style="font-weight:600">{{ $member->id }}</td>
                                <th></th>
                                <td></td>
                                <th></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>{{translate('प्रत्यशी का नाम')}}</th>
                                <td>{{ $member->name }}</td>
                                <th>{{translate('ईमेल आईडी')}}</th>
                                <td>{{ $member->email }}</td>
                                <th>{{('लिंग')}}</th>
                                <td>{{ $member->gender === 'male' ? 'युवक' : 'युवती' }}</td>
                            </tr>
                            <tr>
                                <th>{{('प्रत्याशी का मोबाइल नंबर')}}</th>
                                <td>{{ $member->mobile }}</td>
                                <th>{{('मांगलिक')}}</th>
                                <td>{{ $member->marriage === 'no' ? 'नहीं' : 'हाँ' }}</td>
                                <th>{{('जन्म तिथि')}}</th>
                                <td>{{ \Carbon\Carbon::parse($member->doc_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th>{{('समय')}}</th>
                                <td>{{ $member->time }}</td>
                                <th>{{('नागरिकता')}}</th>
                                <td>{{ $member->citizenship }}</td>
                                <th>{{('जन्म स्थान')}}</th>
                                <td>{{ $member->place_of_birth }}</td>
                            </tr>
                            <tr>
                                <th>{{('राज्य')}}</th>
                                <td>{{ $member->state }}</td>
                                <th>{{('गोत्र स्व')}}</th>
                                <td>{{ $member->gotra_self }}</td>
                                <th>{{('गोत्र मामा')}}</th>
                                <td>{{ $member->gotra_mama }}</td>
                            </tr>
                            <tr>
                                <th>{{('जाति')}}</th>
                                <td>{{ $member->caste }}</td>
                                <th>{{('उपजाति')}}</th>
                                <td>{{ $member->subCaste }}</td>
                                <th>{{('वज़न')}}</th>
                                <td>{{ $member->weight }}</td>
                            </tr>
                            <tr>
                                <th>{{('ऊंचाई')}}</th>
                                <td>{{ $member->height }}</td>
                                <th>{{('वर्ण')}}</th>
                                <td>{{ $member->complexion }}</td>
                                <th>{{('श्रेणी')}}</th>
                                <td>{{ $member->category }}</td>
                            </tr>
                            <tr>
                                <th>{{('निवास')}}</th>
                                <td>{{ $member->residence }}</td>
                                <th></th>
                                <td></td>
                                <th>{{('शिक्षा')}}</th>
                                <td>{{ $member->education }}</td>
                            </tr>
                            <tr>
                                <th>{{('व्यवसाय')}}</th>
                                <td>{{ $member->occupation }}</td>
                                <th>{{('सस्थान का नाम')}}</th>
                                <td>{{ $member->name_of_org }}</td>
                                <th>{{('वार्षिक आय')}}</th>
                                <td>{{ $member->annual_income }}</td>
                            </tr>
                            <tr>
                                <th>{{('पिता का नाम')}}</th>
                                <td>{{ $member->fatherName }}</td>
                                <th>{{('पिता का मोबाइल नंबर')}}</th>
                                <td>{{ $member->father_mobile }}</td>
                                <th>{{('पिता का व्यवसाय')}}</th>
                                <td>{{ $member->father_occupation }}</td>
                            </tr>
                            <tr>
                                <th>{{('पिता की वार्षिक आय')}}</th>
                                <td>{{ $member->father_income }}</td>
                                <th>{{('माँ का नाम')}}</th>
                                <td>{{ $member->mothername }}</td>
                                <th>{{('माँ का मोबाइल नंबर')}}</th>
                                <td>{{ $member->mother_mobile }}</td>
                            </tr>
                            <tr>
                                <th>{{('माँ का व्यवसाय')}}</th>
                                <td>{{ $member->mother_occupation }}</td>
                                <th>{{('माँ की वार्षिक आय')}}</th>
                                <td>{{ $member->mother_income }}</td>
                                <th>{{('स्थायी पता')}}</th>
                                <td>{{ $member->permanent_address }}</td>
                            </tr>
                            <tr>
                                <th>{{('भाई /बहन का विवरण')}}</th>
                                <td>{{ $member->sibling }}</td>
                                <th>{{('विवाहित भाई')}}</th>
                                <td>{{ $member->married_brother }}</td>
                                <th>{{('अविवाहित भाई')}}</th>
                                <td>{{ $member->unmarried_brother }}</td>
                            </tr>
                            <tr>
                                <th>{{('विवाहित बहन')}}</th>
                                <td>{{ $member->married_sister }}</td>
                                <th>{{('अविवाहित बहन')}}</th>
                                <td>{{ $member->unmarried_sister }}</td>
                                <th>{{('सम्पर्क सूत्र')}}</th>
                                <td>{{ $member->contact }}</td>
                            </tr>
                            <tr>
                                <th>{{('सोशल ग्रुप')}}</th>
                                <td>{{ $member->social_group }}</td>
                                <th>{{('भुगतान')}}</th>
                                <td>{{ $member->payment_type }}</td>
                                <th>{{('कुल भुगतान')}}</th>
                                <td>{{ $member->total_payment }}</td>
                            </tr>
                            <tr>
                                <th>{{('कूरियर द्वारा स्मारिका')}}</th>
                                <td>{{ ($member->is_courier == '1') ? "हाँ" : "नहीं" }}</td>
                                <th>{{('पेमेंट मॉड')}}</th>
                                <td>{{ $member->payment_mode }}</td>
                                <th></th>
                                <td>
                                </td>
                            </tr>
                        </tbody>
                    </table>



                    <!-- Profile Picture Section -->
                    <h5>{{ ('Profile Picture') }}</h5>
                    @php
                        // Assuming $member->profile_picture is a JSON encoded string if it's an array
                        $profilePictures = json_decode($member->profile_picture, true);
                    @endphp
                    @if(is_array($profilePictures) && !empty($profilePictures))
                        @foreach($profilePictures as $image)
                            <img class="img-md" src="{{ static_asset($image) }}" height="45px" alt="{{ translate('photo') }}"
                                data-toggle="modal" data-target="#imageModal" onclick="showImage('{{ static_asset($image) }}')">
                        @endforeach
                    @elseif(!empty($member->profile_picture))
                        <img class="img-md" src="{{ static_asset($member->profile_picture) }}" height="45px"
                            alt="{{ translate('photo') }}" data-toggle="modal" data-target="#imageModal"
                            onclick="showImage('{{ static_asset($member->profile_picture) }}')">
                    @else
                        <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}" height="45px"
                            alt="{{ translate('photo') }}" data-toggle="modal" data-target="#imageModal"
                            onclick="showImage('{{ static_asset('assets/img/avatar-place.png') }}')">
                    @endif

                    <hr>
                    <h5>{{translate('Payment Picture')}}</h5>

                    @if(static_asset($member->payment_picture) != null && !empty($member->payment_picture))
                        <img class="img-md" src="{{ static_asset($member->payment_picture) }}" height="45px"
                            alt="{{translate('photo')}}" data-toggle="modal" data-target="#imageModal"
                            onclick="showImage('{{ static_asset($member->payment_picture) }}')">
                    @else
                        <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}" height="45px"
                            alt="{{translate('photo')}}" data-toggle="modal" data-target="#imageModal"
                            onclick="showImage('{{ static_asset('assets/img/avatar-place.png') }}')">
                    @endif

                </div>
            </div>
        </div>
    </div>
    <script>
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection