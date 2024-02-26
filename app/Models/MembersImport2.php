<?php

namespace App\Models;
use App\Models\Member;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Auth;
use Hash;

class MembersImport2 implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key !== 0) {
                try {
                    $validity_days = 365;
                    // Create User
                    $user = User::create([
                        'user_type'         => 'member',
                        'code'              => unique_code(),
                        'first_name'        => $row[0],
                        'last_name'         => $row[1],
                        'email'             => $row[3],
                        'email_verified_at' => now(),
                        'password'          => Hash::make($row[57]), // Assuming password is in the 58th column
                        'phone'             => $row[2],
                        'membership'        => $row[58] == '1' ? 1 : 2,
                    ]);

                    // Create Member
                    $member = Member::create([
                        'user_id'                 => $user->id,
                        'gender'                  => Gender::where('name', $row[57])->first()->id, // Assuming Gender model exists
                        'on_behalves_id'          => OnBehalf::where('name', $row[56])->first()->id, // Assuming OnBehalf model exists
                        'birthday'                => date('Y-m-d', strtotime($row[4])),
                        'current_package_id'      => Package::where('id', $row[55])->first()->id, // Assuming Package model exists
                        'remaining_interest'      => $row[56],
                        'remaining_contact_view'  => $row[57],
                        'remaining_photo_gallery' => $row[58],
                        'auto_profile_match'      => $row[59],
                        'package_validity'        => now()->addDays($validity_days),
                    ]);

                    // Create or update MemberOtherDetail
                    MemberOtherDetail::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'state_id'                  => State::where('name', $row[7])->first()->id, // Assuming State model exists
                            'nationality'               => $row[8],
                            'manglik'                   => $row[9],
                            'self_gotra'                => $row[10],
                            'nanihals_gotra'            => $row[11],
                            'house'                     => $row[12],
                            'qualification'             => $row[13],
                            'occupation'                => $row[14],
                            'job_description'           => $row[15],
                            'position'                  => $row[16],
                            'organization_name'         => $row[17],
                            'annual_income'             => $row[18],
                            'father_mobile_no_1'        => $row[19],
                            'father_mobile_no_2'        => $row[20],
                            'father_occupation'         => $row[21],
                            'father_annual_income'      => $row[22],
                            'mother_mobile_no_1'        => $row[23],
                            'mother_mobile_no_2'        => $row[24],
                            'mother_occupation'         => $row[25],
                            'mother_annual_income'      => $row[26],
                            'permanent_address'         => $row[41],
                            'unmarried_brother'         => $row[42],
                            'married_brother'           => $row[43],
                            'unmarried_sister'          => $row[44],
                            'married_sister'            => $row[45],
                            'grandfather_uncle_info'    => $row[46],
                            'known_person_1'            => $row[47],
                            'known_person_2'            => $row[48],
                            'known_member_digamber_jain_social_group' => $row[49],
                            'candidates_guardian_name'  => $row[50],
                            'relation_with_candidate'   => $row[51],
                            'transaction_id'            => $row[52],
                            'transaction_amount'        => $row[53],
                            'transaction_date'          => date('Y-m-d', strtotime($row[54])),
                        ]
                    );

                    // Create or update Family
                    Family::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'father'                => $row[27],
                            'father_mobile_no_1'    => $row[28],
                            'father_mobile_no_2'    => $row[29],
                            'father_occupation'     => $row[30],
                            'father_annual_income'  => $row[31],
                            'mother'                => $row[32],
                            'mother_mobile_no_1'    => $row[33],
                            'mother_mobile_no_2'    => $row[34],
                            'mother_occupation'     => $row[35],
                            'mother_annual_income'  => $row[36],
                        ]
                    );

                    // Create or update SpiritualBackground
                    SpiritualBackground::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'caste_id'          => $row[37],
                            'sub_caste_id'      => $row[38],
                            'weight'            => $row[39],
                            'height'            => $row[40],
                            'complexion'        => $row[41],
                            'marital_status_id' => MaritalStatus::where('name', $row[42])->first()->id, // Assuming MaritalStatus model exists
                            'house'             => $row[43],
                            'disability'        => $row[44],
                        ]
                    );

                    // Create or update Education
                    Education::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'degree' => $row[45],
                        ]
                    );

                    // Create or update KnownPerson
                    KnownPerson::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'name'  => $row[46],
                            'phone' => $row[47],
                        ]
                    );

                    // Create or update Transaction
                    Transaction::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'amount' => $row[53],
                            'date'   => date('Y-m-d', strtotime($row[54])),
                            'utr'    => $row[52],
                        ]
                    );

                } catch (\Exception $e) {
                    // Handle exceptions
                }
            }
        }
        /* foreach ($rows as $key => $row)
        {
            if($key != 0)
            {
                try{
                    $membership = $row[7] == 1 ? 1 : 2;
                    $user = User::create([
                        'user_type'         => 'member',
                        'code'              => unique_code(),
                        'first_name'        => $row[0],
                        'last_name'         => $row[1],
                        'email'             => $row[2],
                        'email_verified_at' => date('Y-m-d H:m:s'),
                        'password'          => Hash::make($row[8]),
                        'phone'             => $row[5],
                        'membership'        => $membership,
                    ]);

                    $package    = Package::where('id',$row[7])->first();
                    
                    Member::create([
                        'user_id'                 => $user->id,
                        'gender'                  => $row[3],
                        'on_behalves_id'          => $row[6],
                        'birthday'                => date('Y-m-d', strtotime($row[4])),
                        'current_package_id'      => $package->id,
                        'remaining_interest'      => $package->express_interest,
                        'remaining_contact_view'  => $package->contact,
                        'remaining_photo_gallery' => $package->photo_gallery,
                        'auto_profile_match'      => $package->auto_profile_match,
                        'package_validity'        => Date('Y-m-d', strtotime($package->validity." days")),
                    ]);
                }
                catch (\Exception $e) {
                    //
                }
            }
            $key = $key+1;
        } */

    }
}
