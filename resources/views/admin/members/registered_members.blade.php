@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Registrations')}}</h1>
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
  					  		<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type first name / last name / ID & Enter') }}">
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
                            <th data-breakpoints="md">{{translate('Name')}}</th>
                            <th data-breakpoints="md">{{translate('Email')}}</th>
                            <th data-breakpoints="md">{{translate('Mobile No.')}}</th>
                            <th data-breakpoints="md">{{translate('Marital Status')}}</th>
                            <th data-breakpoints="md">{{translate('D.O.B.')}}</th>
                            <th data-breakpoints="md">{{translate('AM/PM')}}</th>
                            <th data-breakpoints="md">{{translate('Citizenship.')}}</th>
                            <th data-breakpoints="md">{{translate('Place of Birth')}}</th>
                            <th data-breakpoints="md">{{translate('State')}}</th>
                            <th data-breakpoints="md">{{translate('Gotra_self')}}</th>
                            <th data-breakpoints="md">{{translate('Gotra_mama')}}</th>
                            <th data-breakpoints="md">{{translate('Caste.')}}</th>
                            <th data-breakpoints="md">{{translate('Subcaste')}}</th>
                            <th data-breakpoints="md">{{translate('Weight')}}</th>
                            <th data-breakpoints="md">{{translate('Height')}}</th>
                            <th data-breakpoints="md">{{translate('Complexion')}}</th>
                            <th data-breakpoints="md">{{translate('Category.')}}</th>
                            <th data-breakpoints="md">{{translate('Residence')}}</th>
                            <th data-breakpoints="md">{{translate('Dosh')}}</th>
                            <th data-breakpoints="md">{{translate('Education')}}</th>
                            <th data-breakpoints="md">{{translate('Occupation')}}</th>
                            <th data-breakpoints="md">{{translate('Fathers Name')}}</th>
                            <th data-breakpoints="md">{{translate('Fathers Mobile No.')}}</th>
                            <th data-breakpoints="md">{{translate('Fathers Occupation')}}</th>
                            <th data-breakpoints="md">{{translate('Fathers Income')}}</th>
                            <th data-breakpoints="md">{{translate('Mothers Name')}}</th>
                            <th data-breakpoints="md">{{translate('Mothers Mobile No.')}}</th>
                            <th data-breakpoints="md">{{translate('Mothers Occupation')}}</th>
                            <th data-breakpoints="md">{{translate('Mothers Income')}}</th>
                            <th data-breakpoints="md">{{translate('Permanent address')}}</th>
                            <th data-breakpoints="md">{{translate('Siblings')}}</th>
                            <th data-breakpoints="md">{{translate('Married Brother.')}}</th>
                            <th data-breakpoints="md">{{translate('Unmarried Brother')}}</th>
                            <th data-breakpoints="md">{{translate('Married Sister')}}</th>
                            <th data-breakpoints="md">{{translate('Unmarried Sister')}}</th>
                            <th data-breakpoints="md">{{translate('Contact')}}</th>
                            <th data-breakpoints="md">{{translate('Social Group')}}</th>
                            <th data-breakpoints="md">{{translate('Payment Type')}}</th>
                            <th data-breakpoints="md">{{translate('Total Payment')}}</th>
                            <th data-breakpoints="md">{{translate('Is Courier')}}</th>
                            <th data-breakpoints="md">{{translate('Payment Mode')}}</th>
                            <th>{{translate('Payment Picture')}}</th>
                           
               

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $key => $member)
                            <tr>
                                <td>{{ ($key + 1) + ($members->currentPage() - 1)*$members->perPage() }}</td>
                                <td>{{ $member->id }}</td>
                                <td>
                                    @if(static_asset($member->profile_picture) != null && !empty($member->profile_picture))
                                            <img class="img-md" src="{{ static_asset($member->profile_picture) }}" height="45px" alt="{{ translate('photo') }}"data-toggle="modal" data-target="#imageModal" onclick="showImage('{{ static_asset($member->profile_picture) }}')">
                                    @else
                                            <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}" height="45px" alt="{{ translate('photo') }}" data-toggle="modal" data-target="#imageModal" onclick="showImage('{{ static_asset('assets/img/avatar-place.png') }}')">
                                    @endif
                                </td>

                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->mobile }}</td>
                                <td>{{ $member->marriage }}</td>
                                <td>{{ $member->doc_date }}</td>
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
                                <td>{{ $member->dosh }}</td>
                                <td>{{ $member->education }}</td>
                                <td>{{ $member->occupation }}</td>
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
                                        <img class="img-md" src="{{ static_asset($member->payment_picture) }}" height="45px"  alt="{{translate('photo')}}"data-toggle="modal" data-target="#imageModal" onclick="showImage('{{ static_asset($member->payment_picture) }}')">
                                    @else
                                        <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}" height="45px"  alt="{{translate('photo')}}"data-toggle="modal" data-target="#imageModal" onclick="showImage('{{ static_asset('assets/img/avatar-place.png') }}')">
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
   <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <!-- <h5 class="modal-title" id="imageModalLabel">{{ translate('Image') }}</h5> -->
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
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
    function sort_members(el){
        $('#sort_members').submit();
    }
</script>
@endsection
