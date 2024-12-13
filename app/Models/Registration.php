<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name', 
        'email', 
        'mobile', 
        'marriage', 
        'doc_date', 
        'time', 
        'ampm',
        'citizenship',
        'place_of_birth', 
        'state', 
        'gotra_self', 
        'gotra_mama', 
        'caste',
        'subCaste', 
        'weight', 
        'height', 
        'complexion', 
        'category',
        'residence', 
        'dosh', // Added field for 'dosh'
        'education', 
        'occupation', 
        'name_of_org',
        'annual_income',
        'fatherName',
        'father_mobile', // Updated from 'mob'
        'father_occupation', // Updated from 'work'
        'father_income', // Updated from 'income2'
        'mothername', 
        'mother_mobile', // Updated from 'mob2'
        'mother_occupation', // Updated from 'work2'
        'mother_income', // Updated from 'income2'
        'permanent_address', // Updated from 'addres'
        'sibling', 
        'married_brother', 
        'unmarried_brother', 
        'married_sister',
        'unmarried_sister', 
        'contact', 
        'social_group',
        'profile_picture', // Added for profile picture path
        'payment_picture', // Added for payment picture path
        'payment_type', // Added for payment type
        'total_payment', // Added for total payment
        'is_courier', // Added for courier option
        'is_attendance', // Added for attendance option
        'is_kit', // Added for kit option
        'payment_mode', // Added for payment mode
        'created_at',
    ];
}
