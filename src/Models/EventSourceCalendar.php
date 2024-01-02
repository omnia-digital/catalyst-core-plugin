<?php

namespace OmniaDigital\CatalystCore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class EventSourceCalendar extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'event_source_calendar_type_id',
        'ext_calendar_id',
        'calendar_url',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function eventSourceCalendarType()
    {
        return $this->belongsTo(EventSourceCalendarType::class);
    }
}
