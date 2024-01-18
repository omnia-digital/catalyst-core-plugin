<?php

namespace OmniaDigital\CatalystCore\View\Component\Job;

use Illuminate\View\Component;
use OmniaDigital\CatalystCore\Models\JobPosition;

class Item extends Component
{
    public JobPosition $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function render()
    {
        return view('catalyst-jobs::components.job.item');
    }
}
