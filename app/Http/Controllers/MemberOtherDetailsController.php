<?php

namespace App\Http\Controllers;

use App\Models\MemberOtherDetail;
use Illuminate\Http\Request;
use App\Models\MemberOtherDetails;
use App\Models\User;
use Validator;
use Redirect;

class MemberOtherDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->rules = [
            'state_id'                                => ['nullable'],
            'nationality'                             => ['nullable', 'max:255'],
            'manglik'                                 => ['nullable', 'max:50'],
            'self_gotra'                              => ['nullable', 'max:255'],
            'nanihals_gotra'                          => ['nullable', 'max:255'],
            'house'                                   => ['nullable', 'max:255'],
            'qualification'                           => ['nullable', 'max:255'],
            'occupation'                              => ['nullable', 'max:255'],
            'job_description'                         => ['nullable', 'max:255'],
            'position'                                => ['nullable', 'max:255'],
            'organization_name'                       => ['nullable', 'max:255'],
            'annual_income'                           => ['nullable', 'numeric'],
            'father_mobile_no_1'                      => ['nullable', 'max:255'],
            'father_mobile_no_2'                      => ['nullable', 'max:255'],
            'father_occupation'                       => ['nullable', 'max:255'],
            'father_annual_income'                    => ['nullable', 'numeric'],
            'mother_mobile_no_1'                      => ['nullable', 'max:255'],
            'mother_mobile_no_2'                      => ['nullable', 'max:255'],
            'mother_occupation'                       => ['nullable', 'max:255'],
            'mother_annual_income'                    => ['nullable', 'numeric'],
            'unmarried_brother'                       => ['nullable', 'numeric'],
            'married_brother'                         => ['nullable', 'numeric'],
            'unmarried_sister'                        => ['nullable', 'numeric'],
            'married_sister'                          => ['nullable', 'numeric'],
            'grandfather_uncle_info'                  => ['nullable', 'max:255'],
            'known_person_1'                          => ['nullable', 'max:255'],
            'known_person_2'                          => ['nullable', 'max:255'],
            'known_member_digamber_jain_social_group' => ['nullable', 'max:255'],
            'candidates_guardian_name'                => ['nullable', 'max:255'],
            'relation_with_candidate'                 => ['nullable', 'max:255'],
            'transaction_id'                          => ['nullable', 'max:255'],
            'transaction_amount'                      => ['nullable', 'numeric'],
            'transaction_date'                        => ['nullable', 'date'],
        ];

        $this->messages = [
            'state_id.nullable'                                      => translate('The state field must be a string.'),
            'nationality.max'                                        => translate('Max 255 characters'),
            'manglik.max'                                            => translate('Max 50 characters'),
            'self_gotra.max'                                         => translate('Max 255 characters'),
            'nanihals_gotra.max'                                     => translate('Max 255 characters'),
            'house.max'                                              => translate('Max 255 characters'),
            'qualification.max'                                      => translate('Max 255 characters'),
            'occupation.max'                                         => translate('Max 255 characters'),
            'job_description.max'                                    => translate('Max 255 characters'),
            'position.max'                                           => translate('Max 255 characters'),
            'organization_name.max'                                  => translate('Max 255 characters'),
            'annual_income.numeric'                                  => translate('The annual income must be a number.'),
            'father_mobile_no_1.max'                                 => translate('Max 255 characters'),
            'father_mobile_no_2.max'                                 => translate('Max 255 characters'),
            'father_occupation.max'                                  => translate('Max 255 characters'),
            'father_annual_income.numeric'                           => translate('The father annual income must be a number.'),
            'mother_mobile_no_1.max'                                 => translate('Max 255 characters'),
            'mother_mobile_no_2.max'                                 => translate('Max 255 characters'),
            'mother_occupation.max'                                  => translate('Max 255 characters'),
            'mother_annual_income.numeric'                           => translate('The mother annual income must be a number.'),
            'unmarried_brother.numeric'                              => translate('The unmarried brother must be a number.'),
            'married_brother.numeric'                                => translate('The married brother must be a number.'),
            'unmarried_sister.numeric'                               => translate('The unmarried sister must be a number.'),
            'married_sister.numeric'                                 => translate('The married sister must be a number.'),
            'grandfather_uncle_info.max'                             => translate('Max 255 characters'),
            'known_person_1.max'                                     => translate('Max 255 characters'),
            'known_person_2.max'                                     => translate('Max 255 characters'),
            'known_member_digamber_jain_social_group.max'            => translate('Max 255 characters'),
            'candidates_guardian_name.max'                           => translate('Max 255 characters'),
            'relation_with_candidate.max'                            => translate('Max 255 characters'),
            'transaction_id.max'                                     => translate('Max 255 characters'),
            'transaction_amount.numeric'                             => translate('The transaction amount must be a number.'),
            'transaction_date.date'                                  => translate('The transaction date must be a date.'),
        ];

        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $user = User::where('id', $id)->first();
        $member_other_details = MemberOtherDetail::where('user_id', $id)->first();

        if (empty($member_other_details)) {
            $member_other_details = new MemberOtherDetail;
            $member_other_details->user_id = $id;
        }

        // Map request data to the member_other_details fields
        $member_other_details->state_id = $request->state_id;
        $member_other_details->nationality = $request->nationality;
        $member_other_details->manglik = $request->manglik;
        $member_other_details->self_gotra = $request->self_gotra;
        $member_other_details->nanihals_gotra = $request->nanihals_gotra;
        $member_other_details->house = $request->house;
        $member_other_details->qualification = $request->qualification;
        $member_other_details->occupation = $request->occupation;
        $member_other_details->job_description = $request->job_description;
        $member_other_details->position = $request->position;
        $member_other_details->organization_name = $request->organization_name;
        $member_other_details->annual_income = $request->annual_income;
        $member_other_details->father_mobile_no_1 = $request->father_mobile_no_1;
        $member_other_details->father_mobile_no_2 = $request->father_mobile_no_2;
        $member_other_details->father_occupation = $request->father_occupation;
        $member_other_details->father_annual_income = $request->father_annual_income;
        $member_other_details->mother_mobile_no_1 = $request->mother_mobile_no_1;
        $member_other_details->mother_mobile_no_2 = $request->mother_mobile_no_2;
        $member_other_details->mother_occupation = $request->mother_occupation;
        $member_other_details->mother_annual_income = $request->mother_annual_income;
        $member_other_details->unmarried_brother = $request->unmarried_brother;
        $member_other_details->married_brother = $request->married_brother;
        $member_other_details->unmarried_sister = $request->unmarried_sister;
        $member_other_details->married_sister = $request->married_sister;
        $member_other_details->grandfather_uncle_info = $request->grandfather_uncle_info;
        $member_other_details->known_person_1 = $request->known_person_1;
        $member_other_details->known_person_2 = $request->known_person_2;
        $member_other_details->known_member_digamber_jain_social_group = $request->known_member_digamber_jain_social_group;
        $member_other_details->candidates_guardian_name = $request->candidates_guardian_name;
        $member_other_details->relation_with_candidate = $request->relation_with_candidate;
        $member_other_details->transaction_id = $request->transaction_id;
        $member_other_details->transaction_amount = $request->transaction_amount;
        $member_other_details->transaction_date = $request->transaction_date;

        if ($member_other_details->save()) {
            flash(translate('Member Other Details has been updated successfully'))->success();
            return back();
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
