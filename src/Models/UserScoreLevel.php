<?php

namespace OmniaDigital\CatalystCore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OmniaDigital\CatalystCore\Database\factories\UserScoreLevelFactory;

class UserScoreLevel extends Model
{
    use HasFactory;

    protected $fillable = ['min_points', 'name', 'level'];

    protected static function newFactory()
    {
        return UserScoreLevelFactory::new();
    }
}
