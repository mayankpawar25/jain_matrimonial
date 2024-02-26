<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Astrology extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'time_of_birth',
        'city_of_birth' 

    ];
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
