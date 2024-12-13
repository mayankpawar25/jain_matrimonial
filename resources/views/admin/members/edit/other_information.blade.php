<div class="card-header bg-dark text-white">
    <h5 class="mb-0 h6">{{translate('Other Information')}}</h5>
</div>
<div class="card-body">
    <form action="{{ route('member_other_details.update', $member->id) }}" method="POST">
        <input name="_method" type="hidden" value="PATCH">
        @csrf
        <div class="form-group row">
                <div class="col-md-6">
                    <label for="nationality">{{translate('Nationality')}}</label>
                    <input type="text" name="nationality" value="{{ !empty($member->member_other_detail->nationality) ? $member->member_other_detail->nationality : ''}}" class="form-control" placeholder="{{translate('Nationality')}}">
                </div>
                <div class="col-md-6">
                    <label for="manglik">{{translate('Manglik')}}</label>
                    <input type="text" name="manglik" value="{{ !empty($member->member_other_detail->manglik) ? $member->member_other_detail->manglik : '' }}" class="form-control" placeholder="{{translate('Manglik')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="self_gotra">{{translate('Self Gotra')}}</label>
                    <input type="text" name="self_gotra" value="{{ !empty($member->member_other_detail->self_gotra) ? $member->member_other_detail->self_gotra : '' }}" class="form-control" placeholder="{{translate('Self Gotra')}}">
                </div>
                <div class="col-md-6">
                    <label for="nanihals_gotra">{{translate('Nanihal\'s Gotra')}}</label>
                    <input type="text" name="nanihals_gotra" value="{{ !empty($member->member_other_detail->nanihals_gotra) ? $member->member_other_detail->nanihals_gotra : '' }}" class="form-control" placeholder="{{translate('Nanihal\'s Gotra')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="house">{{translate('House')}}</label>
                    <input type="text" name="house" value="{{ !empty($member->member_other_detail->house) ? $member->member_other_detail->house : '' }}" class="form-control" placeholder="{{translate('House')}}">
                </div>
                <div class="col-md-6">
                    <label for="qualification">{{translate('Qualification')}}</label>
                    <input type="text" name="qualification" value="{{ !empty($member->member_other_detail->qualification) ? $member->member_other_detail->qualification : '' }}" class="form-control" placeholder="{{translate('Qualification')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="occupation">{{translate('Occupation')}}</label>
                    <input type="text" name="occupation" value="{{ !empty($member->member_other_detail->occupation) ? $member->member_other_detail->occupation : '' }}" class="form-control" placeholder="{{translate('Occupation')}}">
                </div>
                <div class="col-md-6">
                    <label for="job_description">{{translate('Job Description')}}</label>
                    <input type="text" name="job_description" value="{{ !empty($member->member_other_detail->job_description) ? $member->member_other_detail->job_description : '' }}" class="form-control" placeholder="{{translate('Job Description')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="position">{{translate('Position')}}</label>
                    <input type="text" name="position" value="{{ !empty($member->member_other_detail->position) ? $member->member_other_detail->position : '' }}" class="form-control" placeholder="{{translate('Position')}}">
                </div>
                <div class="col-md-6">
                    <label for="organization_name">{{translate('Organization Name')}}</label>
                    <input type="text" name="organization_name" value="{{ !empty($member->member_other_detail->organization_name) ? $member->member_other_detail->organization_name : '' }}" class="form-control" placeholder="{{translate('Organization Name')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="annual_income">{{translate('Annual Income')}}</label>
                    <input type="text" name="annual_income" value="{{ !empty($member->member_other_detail->annual_income) ? $member->member_other_detail->annual_income : '' }}" class="form-control" placeholder="{{translate('Annual Income')}}">
                </div>
                <div class="col-md-6">
                    <label for="father_mobile_no_1">{{translate('Father Mobile No 1')}}</label>
                    <input type="text" name="father_mobile_no_1" value="{{ !empty($member->member_other_detail->father_mobile_no_1) ? $member->member_other_detail->father_mobile_no_1 : '' }}" class="form-control" placeholder="{{translate('Father Mobile No 1')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="father_mobile_no_2">{{translate('Father Mobile No 2')}}</label>
                    <input type="text" name="father_mobile_no_2" value="{{ !empty($member->member_other_detail->father_mobile_no_2) ? $member->member_other_detail->father_mobile_no_2 : '' }}" class="form-control" placeholder="{{translate('Father Mobile No 2')}}">
                </div>
                <div class="col-md-6">
                    <label for="father_occupation">{{translate('Father Occupation')}}</label>
                    <input type="text" name="father_occupation" value="{{ !empty($member->member_other_detail->father_occupation) ? $member->member_other_detail->father_occupation : '' }}" class="form-control" placeholder="{{translate('Father Occupation')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="father_annual_income">{{translate('Father Annual Income')}}</label>
                    <input type="text" name="father_annual_income" value="{{ !empty($member->member_other_detail->father_annual_income) ? $member->member_other_detail->father_annual_income : '' }}" class="form-control" placeholder="{{translate('Father Annual Income')}}">
                </div>
                <div class="col-md-6">
                    <label for="mother_mobile_no_1">{{translate('Mother Mobile No 1')}}</label>
                    <input type="text" name="mother_mobile_no_1" value="{{ !empty($member->member_other_detail->mother_mobile_no_1) ? $member->member_other_detail->mother_mobile_no_1 : '' }}" class="form-control" placeholder="{{translate('Mother Mobile No 1')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="mother_mobile_no_2">{{translate('Mother Mobile No 2')}}</label>
                    <input type="text" name="mother_mobile_no_2" value="{{ !empty($member->member_other_detail->mother_mobile_no_2) ? $member->member_other_detail->mother_mobile_no_2 : '' }}" class="form-control" placeholder="{{translate('Mother Mobile No 2')}}">
                </div>
                <div class="col-md-6">
                    <label for="mother_occupation">{{translate('Mother Occupation')}}</label>
                    <input type="text" name="mother_occupation" value="{{ !empty($member->member_other_detail->mother_occupation) ? $member->member_other_detail->mother_occupation : '' }}" class="form-control" placeholder="{{translate('Mother Occupation')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="mother_annual_income">{{translate('Mother Annual Income')}}</label>
                    <input type="text" name="mother_annual_income" value="{{ !empty($member->member_other_detail->mother_annual_income) ? $member->member_other_detail->mother_annual_income : '' }}" class="form-control" placeholder="{{translate('Mother Annual Income')}}">
                </div>
                <div class="col-md-6">
                    <label for="unmarried_brother">{{translate('Unmarried Brother')}}</label>
                    <input type="number" name="unmarried_brother" value="{{ !empty($member->member_other_detail->unmarried_brother) ? $member->member_other_detail->unmarried_brother : '' }}" class="form-control" placeholder="{{translate('Unmarried Brother')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="married_brother">{{translate('Married Brother')}}</label>
                    <input type="number" name="married_brother" value="{{ !empty($member->member_other_detail->married_brother) ? $member->member_other_detail->married_brother : '' }}" class="form-control" placeholder="{{translate('Married Brother')}}">
                </div>
                <div class="col-md-6">
                    <label for="unmarried_sister">{{translate('Unmarried Sister')}}</label>
                    <input type="number" name="unmarried_sister" value="{{ !empty($member->member_other_detail->unmarried_sister) ? $member->member_other_detail->unmarried_sister : '' }}" class="form-control" placeholder="{{translate('Unmarried Sister')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="married_sister">{{translate('Married Sister')}}</label>
                    <input type="number" name="married_sister" value="{{ !empty($member->member_other_detail->married_sister) ? $member->member_other_detail->married_sister : '' }}" class="form-control" placeholder="{{translate('Married Sister')}}">
                </div>
                <div class="col-md-6">
                    <label for="grandfather_uncle_info">{{translate('Grandfather Uncle Info')}}</label>
                    <textarea name="grandfather_uncle_info" class="form-control" placeholder="{{translate('Grandfather Uncle Info')}}">{{ !empty($member->member_other_detail->grandfather_uncle_info) ? $member->member_other_detail->grandfather_uncle_info : '' }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="known_person_1">{{translate('Known Person 1')}}</label>
                    <input type="text" name="known_person_1" value="{{ !empty($member->member_other_detail->known_person_1) ? $member->member_other_detail->known_person_1 : '' }}" class="form-control" placeholder="{{translate('Known Person 1')}}">
                </div>
                <div class="col-md-6">
                    <label for="known_person_2">{{translate('Known Person 2')}}</label>
                    <input type="text" name="known_person_2" value="{{ !empty($member->member_other_detail->known_person_2) ? $member->member_other_detail->known_person_2 : '' }}" class="form-control" placeholder="{{translate('Known Person 2')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="known_member_digamber_jain_social_group">{{translate('Known Member Digamber Jain Social Group')}}</label>
                    <input type="text" name="known_member_digamber_jain_social_group" value="{{ !empty($member->member_other_detail->known_member_digamber_jain_social_group) ? $member->member_other_detail->known_member_digamber_jain_social_group : '' }}" class="form-control" placeholder="{{translate('Known Member Digamber Jain Social Group')}}">
                </div>
                <div class="col-md-6">
                    <label for="candidates_guardian_name">{{translate('Candidate\'s Guardian Name')}}</label>
                    <input type="text" name="candidates_guardian_name" value="{{ !empty($member->member_other_detail->candidates_guardian_name) ? $member->member_other_detail->candidates_guardian_name : '' }}" class="form-control" placeholder="{{translate('Candidate\'s Guardian Name')}}">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="relation_with_candidate">{{translate('Relation with Candidate')}}</label>
                    <input type="text" name="relation_with_candidate" value="{{ !empty($member->member_other_detail->relation_with_candidate) ? $member->member_other_detail->relation_with_candidate : '' }}" class="form-control" placeholder="{{translate('Relation with Candidate')}}">
                </div>
                <div class="col-md-6">
                    <label for="present_address">{{translate('Present Address')}}</label>
                    <textarea name="present_address" class="form-control" placeholder="{{translate('Present Address')}}">{{ !empty($member->member_other_detail->present_address) ? $member->member_other_detail->present_address : '' }}</textarea>
                </div>
                
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="permanent_address">{{translate('Permanent Address')}}</label>
                    <textarea name="permanent_address" class="form-control" placeholder="{{translate('Permanent Address')}}">{{ !empty($member->member_other_detail->permanent_address) ? $member->member_other_detail->permanent_address : '' }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="transaction_id">{{translate('Transaction ID')}}</label>
                    <input type="text" name="transaction_id" value="{{ !empty($member->member_other_detail->transaction_id) ? $member->member_other_detail->transaction_id : '' }}" class="form-control" placeholder="{{translate('Transaction ID')}}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="transaction_amount">{{translate('Transaction Amount')}}</label>
                    <input type="number" name="transaction_amount" value="{{ !empty($member->member_other_detail->transaction_amount) ? $member->member_other_detail->transaction_amount : '' }}" class="form-control" placeholder="{{translate('Transaction Amount')}}">
                </div>
                <div class="col-md-6">
                    <label for="transaction_date">{{translate('Transaction Date')}}</label>
                    <input type="date" name="transaction_date" value="{{ !empty($member->member_other_detail->transaction_date) ? $member->member_other_detail->transaction_date : '' }}" class="form-control" placeholder="{{translate('Transaction Date')}}">
                </div>
            </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
        </div>
    </form>
</div>
