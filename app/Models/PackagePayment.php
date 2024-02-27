<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackagePayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'package_id',
        'payment_status',
        'payment_method',
        'payment_details',
        'amount',
        'payment_code',
        'offline_payment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function package()
    {
        return $this->belongsTo(Package::class)->withTrashed();
    }
}
