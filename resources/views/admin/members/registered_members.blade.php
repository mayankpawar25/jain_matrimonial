@extends('admin.layouts.app')
@section('content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('Registrations')}}</h1>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <a href="{{ route('registrations.export') }}" class="btn btn-primary ">Export to Excel</a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('All registered members') }}</h5>
                    </div>
                    <div class="col-md-3">
                        <form class="" id="sort_members" action="" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="search" name="search" @isset($sort_search)
                                value="{{ $sort_search }}" @endisset
                                    placeholder="{{ translate('Type first name / last name / ID & Enter') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body aiz-table-overflow">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th data-breakpoints="md">{{translate('ID')}}</th>
                                <th>{{translate('Image')}}</th>
                                <th data-breakpoints="md">{{('प्रत्यशी का नाम')}}</th>
                                <th data-breakpoints="md">{{('ईमेल आईडी')}}</th>
                                <th data-breakpoints="md">{{('प्रत्याशी का मोबाइल नंबर')}}</th>
                                <th data-breakpoints="md">{{('लिंग')}}</th>
                                <th data-breakpoints="md">{{('मांगलिक')}}</th>
                                <th data-breakpoints="md">{{('जन्म तिथि')}}</th>
                                <th data-breakpoints="md">{{('समय')}}</th>
                                <th data-breakpoints="md">{{'नागरिकता'}}</th>
                                <th data-breakpoints="md">{{('जन्म स्थान')}}</th>
                                <th data-breakpoints="md">{{('राज्य')}}</th>
                                <th data-breakpoints="md">{{('गोत्र स्व')}}</th>
                                <th data-breakpoints="md">{{('गोत्र मामा')}}</th>
                                <th data-breakpoints="md">{{('जाति')}}</th>
                                <th data-breakpoints="md">{{('उपजाति')}}</th>
                                <th data-breakpoints="md">{{('वज़न')}}</th>
                                <th data-breakpoints="md">{{('ऊंचाई')}}</th>
                                <th data-breakpoints="md">{{('वर्ण')}}</th>
                                <th data-breakpoints="md">{{'श्रेणी'}}</th>
                                <th data-breakpoints="md">{{('निवास')}}</th>
                                <th data-breakpoints="md">{{('निवास का विवरण')}}</th>
                                <!-- <th data-breakpoints="md">{{('Dosh')}}</th> -->
                                <th data-breakpoints="md">{{('शिक्षा')}}</th>
                                <th data-breakpoints="md">{{('व्यवसाय')}}</th>
                                <th data-breakpoints="md">{{('सस्थान का नाम')}}</th>
                                <th data-breakpoints="md">{{('वार्षिक आय')}}</th>
                                <th data-breakpoints="md">{{'पिता का नाम'}}</th>
                                <th data-breakpoints="md">{{'पिता का मोबाइल नंबर'}}</th>
                                <th data-breakpoints="md">{{'पिता का व्यवसाय'}}</th>
                                <th data-breakpoints="md">{{'पिता की वार्षिक आय'}}</th>
                                <th data-breakpoints="md">{{'माँ का नाम'}}</th>
                                <th data-breakpoints="md">{{'माँ का मोबाइल नंबर'}}</th>
                                <th data-breakpoints="md">{{'माँ का व्यवसाय'}}</th>
                                <th data-breakpoints="md">{{'माँ की वार्षिक आय'}}</th>
                                <th data-breakpoints="md">{{('स्थायी पता')}}</th>
                                <th data-breakpoints="md">{{('भाई /बहन का विवरण')}}</th>
                                <th data-breakpoints="md">{{('विवाहित भाई')}}</th>
                                <th data-breakpoints="md">{{('अविवाहित भाई')}}</th>
                                <th data-breakpoints="md">{{('विवाहित बहन')}}</th>
                                <th data-breakpoints="md">{{('अविवाहित बहन')}}</th>
                                <th data-breakpoints="md">{{('सम्पर्क सूत्र')}}</th>
                                <th data-breakpoints="md">{{('सोशल ग्रुप')}}</th>
                                <th data-breakpoints="md">{{('भुगतान')}}</th>
                                <th data-breakpoints="md">{{('कुल भुगतान')}}</th>
                                <th data-breakpoints="md">{{('कूरियर द्वारा स्मारिका')}}</th>
                                <th data-breakpoints="md">{{('पेमेंट मॉड')}}</th>
                                <th>{{('Payment Picture')}}</th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $key => $member)
                                <tr>
                                    <td>{{ ($key + 1) + ($members->currentPage() - 1) * $members->perPage() }}</td>
                                    <td>{{ $member->id }}</td>
                                    <td>
                                        @php
                                            // Assuming $member->profile_picture is a JSON encoded string if it's an array
                                            $profilePictures = json_decode($member->profile_picture, true);
                                        @endphp
                                        @if(is_array($profilePictures) && !empty($profilePictures))
                                            @foreach($profilePictures as $image)
                                                <img class="img-md" src="{{ static_asset($image) }}" height="45px"
                                                    alt="{{ translate('photo') }}" data-toggle="modal" data-target="#imageModal"
                                                    onclick="showImage('{{ static_asset($image) }}')">
                                            @endforeach
                                        @elseif(!empty($member->profile_picture))
                                            <img class="img-md" src="{{ static_asset($member->profile_picture) }}" height="45px"
                                                alt="{{ translate('photo') }}" data-toggle="modal" data-target="#imageModal"
                                                onclick="showImage('{{ static_asset($member->profile_picture) }}')">
                                        @else
                                            <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}"
                                                height="45px" alt="{{ translate('photo') }}" data-toggle="modal"
                                                data-target="#imageModal"
                                                onclick="showImage('{{ static_asset('assets/img/avatar-place.png') }}')">
                                        @endif
                                    </td>

                                    <td><a href="{{ route('registered_member_details', $member->id) }}">{{ $member->name }}</a>
                                    </td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->mobile }}</td>
                                    <td>{{ $member->gender === 'male' ? 'युवक' : 'युवती' }}</td>
                                    <td>{{ $member->marriage === 'no' ? 'नहीं' : 'हाँ' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($member->doc_date)->format('d-m-Y') }}</td>
                                    <td>{{ $member->time }}</td>
                                    <td>{{ $member->citizenship }}</td>
                                    <td>{{ $member->place_of_birth }}</td>
                                    <td>{{ $member->state }}</td>
                                    <td>{{ $member->gotra_self }}</td>
                                    <td>{{ $member->gotra_mama }}</td>
                                    <td>{{ $member->caste }}</td>
                                    <td>{{ $member->subCaste }}</td>
                                    <td>{{ $member->weight }}</td>
                                    <td>{{ $member->height }}</td>
                                    <td>{{ $member->complexion }}</td>
                                    <td>{{ $member->category }}</td>
                                    <td>{{ $member->residence }}</td>
                                    <td>{{ $member->residence_category }}</td>
                                    <!-- <td>{{ $member->dosh }}</td> -->
                                    <td>{{ $member->education }}</td>
                                    <td>{{ $member->occupation }}</td>
                                    <td>{{ $member->name_of_org }}</td>
                                    <td>{{ $member->annual_income }}</td>
                                    <td>{{ $member->fatherName }}</td>
                                    <td>{{ $member->father_mobile }}</td>
                                    <td>{{ $member->father_occupation }}</td>
                                    <td>{{ $member->father_income }}</td>
                                    <td>{{ $member->mothername }}</td>
                                    <td>{{ $member->mother_mobile }}</td>
                                    <td>{{ $member->mother_occupation }}</td>
                                    <td>{{ $member->mother_income }}</td>
                                    <td>{{ $member->permanent_address }}</td>
                                    <td>{{ $member->sibling }}</td>
                                    <td>{{ $member->married_brother }}</td>
                                    <td>{{ $member->unmarried_brother }}</td>
                                    <td>{{ $member->married_sister }}</td>
                                    <td>{{ $member->unmarried_sister }}</td>
                                    <td>{{ $member->contact }}</td>
                                    <td>{{ $member->social_group }}</td>

                                    <td>{{ $member->payment_type }}</td>
                                    <td>{{ $member->total_payment }}</td>
                                    <td>{{ ($member->is_courier == '1') ? "Yes" : "No" }}</td>
                                    <td>{{ $member->payment_mode }}</td>
                                    <td>
                                        @if(static_asset($member->payment_picture) != null && !empty($member->payment_picture))
                                            <img class="img-md" src="{{ static_asset($member->payment_picture) }}" height="45px"
                                                alt="{{translate('photo')}}" data-toggle="modal" data-target="#imageModal"
                                                onclick="showImage('{{ static_asset($member->payment_picture) }}')">
                                        @else
                                            <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}"
                                                height="45px" alt="{{translate('photo')}}" data-toggle="modal"
                                                data-target="#imageModal"
                                                onclick="showImage('{{ static_asset('assets/img/avatar-place.png') }}')">
                                        @endif
                                    </td>

                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $members->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Image Modal -->
    <div class="modal fade " id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background : transparent; border: none">
                <div class="modal-body" style="overflow : hidden; max-height : 100%">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <img id="modalImage" src="" class="img-fluid w-100" alt="{{ translate('image') }}">
                </div>
            </div>
        </div>
    </div>
    <script>
        function showImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>


@endsection

@section('script')
    <script type="text/javascript">
        function sort_members(el) {
            $('#sort_members').submit();
        }
    </script>
@endsection