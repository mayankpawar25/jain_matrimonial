<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberOtherDetail extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'state_id',
        'nationality',
        'manglik',
        'self_gotra',
        'nanihals_gotra',
        'house',
        'qualification',
        'occupation',
        'job_description',
        'position',
        'organization_name',
        'annual_income',
        'father_mobile_no_1',
        'father_mobile_no_2',
        'father_occupation',
        'father_annual_income',
        'mother_mobile_no_1',
        'mother_mobile_no_2',
        'mother_occupation',
        'mother_annual_income',
        'unmarried_brother',
        'married_brother',
        'unmarried_sister',
        'married_sister',
        'grandfather_uncle_info', // Consider storing this information in JSON format or separate columns
        'known_person_1',
        'known_person_2',
        'known_member_digamber_jain_social_group',
        'candidates_guardian_name',
        'relation_with_candidate',
        'transaction_id',
        'transaction_amount',
        'transaction_date',
        'present_address',
        'permanent_address',
        // Add other fillable columns as needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
