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
            <div class="card-body" >
                <table class="table aiz-table mb-0">
                    <tbody>
                        <tr>
                            <th>{{translate('ID')}}</th>
                            <td>{{ $member->id }}</td>
                            <th>{{translate('Name')}}</th>
                            <td>{{ $member->name }}</td>
                            <th>{{translate('Email')}}</th>
                            <td>{{ $member->email }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Mobile No.')}}</th>
                            <td>{{ $member->mobile }}</td>
                            <th>{{translate('Manglik')}}</th>
                            <td>{{ $member->marriage }}</td>
                            <th>{{translate('Birthdate')}}</th>
                            <td>{{ \Carbon\Carbon::parse($member->doc_date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Time of Birth')}}</th>
                            <td>{{ $member->time }}</td>
                            <th>{{translate('Citizenship')}}</th>
                            <td>{{ $member->citizenship }}</td>
                            <th>{{translate('Birthplace')}}</th>
                            <td>{{ $member->place_of_birth }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('State')}}</th>
                            <td>{{ $member->state }}</td>
                            <th>{{translate('Self Gotra')}}</th>
                            <td>{{ $member->gotra_self }}</td>
                            <th>{{translate('Mama Gotra')}}</th>
                            <td>{{ $member->gotra_mama }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Caste')}}</th>
                            <td>{{ $member->caste }}</td>
                            <th>{{translate('Subcaste')}}</th>
                            <td>{{ $member->subCaste }}</td>
                            <th>{{translate('Weight')}}</th>
                            <td>{{ $member->weight }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Height')}}</th>
                            <td>{{ $member->height }}</td>
                            <th>{{translate('Complexion')}}</th>
                            <td>{{ $member->complexion }}</td>
                            <th>{{('Marital Status')}}</th>
                            <td>{{ $member->category }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Residence')}}</th>
                            <td>{{ $member->residence }}</td>
                            <th>{{translate('Dosh')}}</th>
                            <td>{{ $member->dosh }}</td>
                            <th>{{translate('Education')}}</th>
                            <td>{{ $member->education }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Occupation')}}</th>
                            <td>{{ $member->occupation }}</td>
                            <th>{{translate('Name of Org.')}}</th>
                            <td>{{ $member->name_of_org }}</td>
                            <th>{{translate('Annual Income')}}</th>
                            <td>{{ $member->annual_income }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Father’s Name')}}</th>
                            <td>{{ $member->fatherName }}</td>
                            <th>{{translate('Father’s Mobile No.')}}</th>
                            <td>{{ $member->father_mobile }}</td>
                            <th>{{translate('Father’s Occupation')}}</th>
                            <td>{{ $member->father_occupation }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Father’s Income')}}</th>
                            <td>{{ $member->father_income }}</td>
                            <th>{{translate('Mother’s Name')}}</th>
                            <td>{{ $member->mothername }}</td>
                            <th>{{translate('Mother’s Mobile No.')}}</th>
                            <td>{{ $member->mother_mobile }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Mother’s Occupation')}}</th>
                            <td>{{ $member->mother_occupation }}</td>
                            <th>{{translate('Mother’s Income')}}</th>
                            <td>{{ $member->mother_income }}</td>
                            <th>{{translate('Permanent address')}}</th>
                            <td>{{ $member->permanent_address }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Siblings')}}</th>
                            <td>{{ $member->sibling }}</td>
                            <th>{{translate('Married Brother.')}}</th>
                            <td>{{ $member->married_brother }}</td>
                            <th>{{translate('Unmarried Brother')}}</th>
                            <td>{{ $member->unmarried_brother }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Married Sister')}}</th>
                            <td>{{ $member->married_sister }}</td>
                            <th>{{translate('Unmarried Sister')}}</th>
                            <td>{{ $member->unmarried_sister }}</td>
                            <th>{{translate('Contact')}}</th>
                            <td>{{ $member->contact }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Social Group')}}</th>
                            <td>{{ $member->social_group }}</td>
                            <th>{{translate('Payment Type')}}</th>
                            <td>{{ $member->payment_type }}</td>
                            <th>{{translate('Total Payment')}}</th>
                            <td>{{ $member->total_payment }}</td>
                        </tr>
                        <tr>
                            <th>{{translate('Is Courier')}}</th>
                            <td>{{ ($member->is_courier == '1') ? "Yes" : "No" }}</td>
                            <th>{{translate('Payment Mode')}}</th>
                            <td>{{ $member->payment_mode }}</td>
                            <th></th>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>



                <!-- Profile Picture Section -->
                <h5>{{ translate('Profile Picture') }}</h5>
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