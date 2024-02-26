<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'father',
        'mother',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
