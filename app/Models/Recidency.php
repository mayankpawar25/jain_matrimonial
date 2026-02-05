<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recidency extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    protected $fillable = [
        'user_id',
        'birth_country_id',
        'residency_country_id',
        'immigration_status',
        'grow_up_country_id'
    ];
}
