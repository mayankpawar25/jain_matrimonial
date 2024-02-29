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
                            'password'          => Hash::make($row[55]), // Assuming password is in the 54th column
                            'phone'             => $row[2],
                            'membership'        => 2,
                        ]
                    );
                   
                    $package = Package::where('id', $row[54])->first();
                    $children = 0;
                    $no_of_daughter = 0;
                    if(in_array(strtolower($row[17]), ['married'])) {
                        $input_marital_status = 'Married';
                        $children = !empty($row[18]) ? $row[18] : 0;
                        $no_of_daughter = !empty($row[19]) ? $row[19] : 0;
                    } else if(in_array(strtolower($row[17]), ['unmarried'])) {
                        $input_marital_status = 'Unmarried';
                    } else {
                        $input_marital_status = 'Divorcee';
                        $children = !empty($row[18]) ? $row[18] : 0;
                        $no_of_daughter = !empty($row[19]) ? $row[19] : 0;
                    }
                    $marital_status_id = MaritalStatus::where('name', 'LIKE', $input_marital_status)->whereNull('deleted_at')->first()->id;
                    
                    // Create Member
                    Member::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'gender' => $row[52], // Assuming Gender model exists
                            'on_behalves_id' => $row[53], // Assuming OnBehalf model exists
                            'birthday' => date('Y-m-d', strpos($row[4], '/') !== false ? strtotime(str_replace('/', '-', $row[4])) : strtotime($row[4])),
                            'current_package_id' => $package->id, // Assuming Package model exists
                            'remaining_interest' => $package->express_interest,
                            'remaining_contact_view' => $package->contact,
                            'remaining_photo_gallery' => $package->photo_gallery,
                            'auto_profile_match' => $package->auto_profile_match,
                            'package_validity' => Date('Y-m-d', strtotime($package->validity . ' days')),
                            'marital_status_id' => $marital_status_id ? $marital_status_id : null,
                            'children' => $children,
                            'no_of_daughter' => $no_of_daughter,
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
                            'house' => $row[20],
                            'occupation' => $row[23],
                            'job_description' => $row[24],
                            'position' => $row[25],
                            'organization_name' => $row[26],
                            'annual_income' => $row[27],
                            'father_mobile_no_1' => $row[29],
                            'father_mobile_no_2' => is_numeric($row[30]) ? $row[30] : null,
                            'father_occupation' => $row[31],
                            'father_annual_income' => is_numeric($row[32]) ? $row[32] : null,
                            'mother_mobile_no_1' => is_numeric($row[34]) ? $row[34] : null,
                            'mother_mobile_no_2' => is_numeric($row[35]) ? $row[35] : null,
                            'mother_occupation' => $row[36],
                            'mother_annual_income' => is_numeric($row[37]) ? $row[37] : null,
                            'present_address' => $row[1],
                            'permanent_address' => $row[38],
                            'unmarried_brother' => is_numeric($row[39]) ? $row[39] : null,
                            'married_brother' => is_numeric($row[40]) ? $row[40] : null,
                            'unmarried_sister' => is_numeric($row[41]) ? $row[41] : null,
                            'married_sister' => is_numeric($row[42]) ? $row[42] : null,
                            'grandfather_uncle_info' => $row[43],
                            'known_person_1' => $row[44],
                            'known_person_2' => $row[45],
                            'known_member_digamber_jain_social_group' => $row[46],
                            'candidates_guardian_name' => $row[47],
                            'relation_with_candidate' => $row[48],
                            'transaction_id' => $row[49],
                            'transaction_amount' => is_numeric($row[50]) ? $row[50] : null,
                            'transaction_date' => date('Y-m-d', strpos($row[51], '/') !== false ? strtotime(str_replace('/', '-', $row[51])) : strtotime($row[51])),
                        ],
                    );

                    // Create or update Career
                    Career::updateOrCreate(
                        ['user_id' => $user->id], // Assuming designation is in the Career model
                        [
                            'designation' => $row[25],
                            'company' => $row[26],
                            'present' => 1, // Assuming present is a boolean in the Excel data
                        ]
                    );

                    // Create or update Family
                    Family::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'father' => $row[28],
                            'mother' => $row[33],
                        ],
                    );

                    $castdata = Caste::where('name', 'LIKE', $row[12])->whereNull('deleted_at')->first();
                    try {
                        //code...
                        $sub_caste_id = SubCaste::where('name', 'LIKE', trim($row[13]))->whereNull('deleted_at')->first()->id; 
                    } catch (\Throwable $th) {
                        //throw $th;
                        dd($th, $row[13]);
                    }

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
                            'height'         => !empty($row[15]) ? $row[15] : 0, // Assuming height column is in PhysicalAttribute model
                            'weight'         => !empty($row[14]) ? $row[14] : 0,
                            'complexion'     => !empty($row[16]) ? $row[16] : '',
                            'disability'     => !empty($row[21]) ? $row[21] : '',
                        ]
                    );

                    // Create or update Education
                    Education::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'degree' => $row[22],
                            'present' => 1,
                        ],
                    );

                    $additional_content = json_encode(['transaction_id' => $row[49], 'amount' => !empty($row[50]) ? $row[50] : 0, 'date' => date('Y-m-d', strtotime($row[51]))]);
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
                            'amount' => !empty($row[50]) ? $row[50] : 0,
                            'payment_code' => $row[56],
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
    }
}
