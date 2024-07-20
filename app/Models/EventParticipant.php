<?php

namespace App\Models;

use App\Enums\InformationSourceType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EventParticipant extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'event_registrants';
    protected $fillable = [
        'user_id',
        'event_id',
        'information_source',
        'payment_id',
    ];

    protected $casts = [
        'information_source' => InformationSourceType::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function coaching():HasOne
    {
        return $this->hasOne(Coaching::class, 'registrant_id', 'id');
    }

    public function openClass():HasOne
    {
        return $this->hasOne(OpenClass::class, 'registrant_id', 'id');
    }
}
