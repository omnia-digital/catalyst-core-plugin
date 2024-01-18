<?php

namespace OmniaDigital\CatalystCore\Models\Jobs;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OmniaDigital\CatalystCore\Support\Jobs\HasJobs;

class HoursPerWeek extends Model
{
    use HasFactory, HasJobs;

    public $table = 'hours_per_week';

    protected $fillable = [
        'value',
    ];

    public function users()
    {
        return $this->hasManyThrough(User::class, JobPosition::class, 'user_id', 'id');
    }
}
