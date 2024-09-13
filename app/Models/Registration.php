<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'mobile', 'marriage', 'doc_date', 'time', 'ampm',
        'place_of_birth', 'state', 'gotra_self', 'gotra_mama', 'caste',
        'subCaste', 'weight', 'height', 'complexion', 'category',
        'residence', 'education', 'occupation', 'maritalStatus', 'fatherName',
        'mob', 'work', 'mothername', 'mob2', 'work2', 'income2', 'addres',
        'sibling', 'married_brother', 'unmarried_brother', 'married_sister',
        'unmarried_sister', 'contact', 'social_group'
    ];
    
    
}
