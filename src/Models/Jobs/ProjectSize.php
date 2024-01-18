<?php

namespace OmniaDigital\CatalystCore\Models\Jobs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OmniaDigital\CatalystCore\Support\HasJobs;

class ProjectSize extends Model
{
    use HasFactory, HasJobs;

    protected $fillable = [
        'title',
        'description',
        'order',
    ];

    public function users()
    {
        return $this->hasManyThrough(User::class, JobPosition::class, 'user_id', 'id');
    }
}
