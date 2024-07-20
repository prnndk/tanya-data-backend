<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasUuids,HasFactory;

    protected $fillable =['name','event_type','start_regist_time','end_regist_time','is_active'];

    protected $casts = [
        'start_regist_time' => 'datetime',
        'end_regist_time' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function registrants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventParticipant::class, 'event_id', 'id');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(EventAnnouncement::class, 'event_id', 'id');
    }

    public function talks(): HasOne
    {
        return $this->hasOne(TalkDetail::class, 'event_id', 'id');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(PackageData::class, 'event_id', 'id');
    }

}
