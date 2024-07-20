<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkDetail extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'theme',
        'link',
        'date',
        'is_active',
        'event_id'
    ];

    protected $casts = [
        'date' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
