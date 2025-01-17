<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id', 
        'transaction_number', 
        'image', 
        'transaction_date', 
        'created_at',
        'updated_at',
        ];
}
