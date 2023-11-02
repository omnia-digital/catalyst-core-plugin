<?php

namespace OmniaDigital\CatalystCore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OmniaDigital\CatalystCore\Database\Factories\AwardFactory;

class Award extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return app(AwardFactory::class);
    }

    protected $fillable = [
        'name',
        'icon',
        'bg_color',
        'text_color',
    ];

    protected $guarded = [];

    public function teams()
    {
        return $this->morphedByMany(Team::class, 'awardable');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'awardable');
    }
}
