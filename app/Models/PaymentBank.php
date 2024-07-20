<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'bank_number',
        'owner_name',
        'is_active'
    ];

}
