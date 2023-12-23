<?php

namespace OmniaDigital\CatalystCore\Models;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFollow\Traits\Followable;

class Event extends Model
{
    use Followable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'timezone',
        'starts_at',
        'ends_at',
        'url',
        'is_public',
        'is_recurring',
        'is_published',
        'is_all_day',
        'status',
        'created_by',
        'team_id',
        'location_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_public' => 'boolean',
        'is_recurring' => 'boolean',
        'is_published' => 'boolean',
        'is_all_day' => 'boolean',
    ];

    public function scopePublicAndPublished($query)
    {
        return $query->where('is_published', true)->where('is_public', true);
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
