<?php

namespace App\Models;

use App\Enums\ValidateStatusType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'sender_name',
        'sender_bank',
        'payment_bank_id',
        'nominal',
        'payment_proof',
        'validation_status',
        'revision_message',
        'validated_at',
    ];

    protected $casts = [
        'validation_status' => ValidateStatusType::class,
        'validated_at' => 'datetime',
    ];

    public function paymentBank(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PaymentBank::class, 'payment_bank_id', 'id');
    }

    public function eventParticipant():HasOne{
        return $this->hasOne(EventParticipant::class,'payment_id','id');
    }
}
