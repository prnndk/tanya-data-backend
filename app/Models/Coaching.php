<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coaching extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'competition_name',
        'deadline_date',
        'idea',
        'progress',
        'request',
        'file',
        'package_id',
        'registrant_id'
    ];

    protected $casts = [
        'deadline_date' => 'datetime'
    ];

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PackageData::class, 'package_id', 'id');
    }

    public function registrant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EventParticipant::class, 'registrant_id', 'id');
    }
}
