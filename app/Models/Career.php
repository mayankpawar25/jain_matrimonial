<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'user_id', 'designation','company', 'present'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
