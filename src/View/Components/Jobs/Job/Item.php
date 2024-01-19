<?php

namespace OmniaDigital\CatalystCore\View\Component\Jobs\Job;

use Illuminate\View\Component;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;

class Item extends Component
{
    public JobPosition $job;
    public function __construct($job)
    {
        $this->job = $job;
    }

    public function render()
    {
        return view('catalyst::components.jobs.job.item');
    }
}
