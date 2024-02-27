<?php

namespace App\Models;
use App\Models\Member;
use App\Models\Package;
use App\Models\User;
use App\Models\State;
use App\Models\Family;
use App\Models\SpiritualBackground;
use App\Models\PhysicalAttribute;
use App\Models\Education;
use App\Models\MemberOtherDetail;
use App\Models\Transaction;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\OnBehalf;
use App\Models\Astrology;
use App\Models\Address;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Auth;
use DateTime;
use DateTimeZone;
use Hash;

class MembersImport2 implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key !== 0) {
                try {
                    // Split full name into first name and last name
                    $nameParts = explode(' ', $row[0], 2);
                    $firstName = $nameParts[0];
                    $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

                    // Create User
                    $user = User::firstOrCreate(
                        ['email' => $row[3]],
                        [
                            'user_type'         => 'member',
                            'code'              => unique_code(),
                            'first_name'        => $firstName,
                            'last_name'         => $lastName,
                            'email_verified_at' => date('Y-m-d H:m:s'),
                            'password'          => Hash::make($row[54]), // Assuming password is in the 54th column
                            'phone'             => $row[2],
                            'membership'        => 2,
                        ]
                    );
                   
                    $package = Package::where('id', $row[53])->first();
                    $marital_status_id = MaritalStatus::where('name', 'LIKE', $row[17])->whereNull('deleted_at')->first()->id;
                    
                    // Create Member
                    Member::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'gender' => $row[51], // Assuming Gender model exists
                            'on_behalves_id' => $row[52], // Assuming OnBehalf model exists
                            'birthday' => date('Y-m-d', strtotime($row[4])),
                            'current_package_id' => $package->id, // Assuming Package model exists
                            'remaining_interest' => $package->express_interest,
                            'remaining_contact_view' => $package->contact,
                            'remaining_photo_gallery' => $package->photo_gallery,
                            'auto_profile_match' => $package->auto_profile_match,
                            'package_validity' => Date('Y-m-d', strtotime($package->validity . ' days')),
                            'marital_status_id' => $marital_status_id ? $marital_status_id : null,
                        ],
                    );
                    
                    // Create or update MemberOtherDetail
                    MemberOtherDetail::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            // 'state_id' => State::where('name', $row[7])->first()->id, // Assuming State model exists
                            'nationality' => $row[8],
                            'manglik' => $row[9],
                            'self_gotra' => $row[10],
                            'nanihals_gotra' => $row[11],
                            'house' => $row[18],
                            'occupation' => $row[21],
                            'job_description' => $row[22],
                            'position' => $row[23],
                            'organization_name' => $row[24],
                            'annual_income' => $row[25],
                            'father_mobile_no_1' => $row[27],
                            'father_mobile_no_2' => is_numeric($row[28]) ? $row[28] : null,
                            'father_occupation' => $row[29],
                            'father_annual_income' => is_numeric($row[30]) ? $row[30] : null,
                            'mother_mobile_no_1' => is_numeric($row[32]) ? $row[32] : null,
                            'mother_mobile_no_2' => is_numeric($row[33]) ? $row[33] : null,
                            'mother_occupation' => $row[34],
                            'mother_annual_income' => is_numeric($row[35]) ? $row[35] : null,
                            'present_address' => $row[1],
                            'permanent_address' => $row[36],
                            'unmarried_brother' => is_numeric($row[37]) ? $row[37] : null,
                            'married_brother' => is_numeric($row[38]) ? $row[38] : null,
                            'unmarried_sister' => is_numeric($row[39]) ? $row[39] : null,
                            'married_sister' => is_numeric($row[40]) ? $row[40] : null,
                            'grandfather_uncle_info' => $row[41],
                            'known_person_1' => $row[42],
                            'known_person_2' => $row[43],
                            'known_member_digamber_jain_social_group' => $row[44],
                            'candidates_guardian_name' => $row[46],
                            'relation_with_candidate' => $row[47],
                            'transaction_id' => $row[48],
                            'transaction_amount' => is_numeric($row[49]) ? $row[49] : null,
                            'transaction_date' => date('Y-m-d', strtotime($row[50])),
                        ],
                    );

                    // Create or update Career
                    Career::updateOrCreate(
                        ['user_id' => $user->id], // Assuming designation is in the Career model
                        [
                            'designation' => $row[23],
                            'company' => $row[24],
                            'present' => 1, // Assuming present is a boolean in the Excel data
                        ]
                    );

                    // Create or update Family
                    Family::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'father' => $row[26],
                            'mother' => $row[31],
                        ],
                    );

                    $castdata = Caste::where('name', 'LIKE', $row[12])->whereNull('deleted_at')->first();
                    $sub_caste_id = SubCaste::where('name', 'LIKE', $row[13])->whereNull('deleted_at')->first()->id; 

                    // Create or update SpiritualBackground
                    SpiritualBackground::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'religion_id' => $castdata->religion_id, 
                            'caste_id' => $castdata->id, 
                            'sub_caste_id' => $sub_caste_id, 
                            'ethnicity'=> $row[8],
                        ],
                    );

                    // Create or update PhysicalAttribute
                    PhysicalAttribute::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'height'         => $row[15], // Assuming height column is in PhysicalAttribute model
                            'weight'         => $row[14],
                            'complexion'     => $row[16],
                            'disability'     => $row[19],
                        ]
                    );

                    // Create or update Education
                    Education::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'degree' => $row[20],
                            'present' => 1,
                        ],
                    );

                    $additional_content = json_encode(['transaction_id' => $row[48], 'amount' => $row[55], 'date' => date('Y-m-d', strtotime($row[50]))]);
                    // Update or create Transaction
                    Transaction::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'gateway' => $row[56], 
                            'payment_type' => $row[56],
                            'additional_content' => $additional_content, 
                        ],
                    );

                    // Create or update PackagePayment
                    PackagePayment::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'package_id' => $package->id,
                        ],
                        [
                            'payment_method' => 'UPI',
                            'payment_status' => 'Paid',
                            'payment_details' => $additional_content,
                            'amount' => $row[55],
                            'payment_code' => $row[48],
                            'offline_payment' => 1,
                        ]
                    );

                    // Create or update Astrology
                    Astrology::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'time_of_birth' => $row[5],
                            'city_of_birth' => $row[6],
                        ],
                    );

                    // Get state_id from State table
                    $stateData = State::where('name', 'LIKE', $row[7])->first();

                    // Create or update Address
                    Address::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'type' => 'present',
                            'state_id' => $stateData->id,
                            'country_id' => $stateData->country_id,
                        ],
                    );
                } catch (\Exception $e) {
                    // Handle exceptions
                    dd($e);
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
