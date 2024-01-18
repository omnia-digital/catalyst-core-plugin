<?php

namespace OmniaDigital\CatalystCore\Support\Jobs;


use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;

trait HasJobs
{
    public function jobs()
    {
        return $this->hasMany(JobPosition::class);
    }
}
