<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenClass extends Model
{
    use HasUuids,HasFactory;

    protected $fillable = [
        'registrant_id',
        'package_id',
    ];

    public function registrant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EventParticipant::class, 'registrant_id', 'id');
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PackageData::class, 'package_id', 'id');
    }
}
