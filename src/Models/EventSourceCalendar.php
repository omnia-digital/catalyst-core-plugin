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

    // we need the ability to pull in from external google calendars and sync with each of our calendars.
    // something like event_source_calendar->source_calendars
    // then have a job that runs nightly to sync the events from the external source calendars to the local source calendars.

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
