<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs;

use Filament\Pages\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Jobs\ApplyType;
use OmniaDigital\CatalystCore\Models\Jobs\ExperienceLevel;
use OmniaDigital\CatalystCore\Models\Jobs\HoursPerWeek;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;
use OmniaDigital\CatalystCore\Models\Jobs\JobPositionLength;
use OmniaDigital\CatalystCore\Models\Jobs\PaymentType;
use OmniaDigital\CatalystCore\Models\Jobs\ProjectSize;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class UpdateJob extends Page
{
    use WithNotification;

    protected static string $view = 'catalyst::livewire.jobs.pages.jobs.update-job';

    public JobPosition $job;

    public $selected_skills;

    protected $rules = [
        'job.title' => 'required|max:254',
        'job.description' => 'required|min:50',
        'job.apply_type' => 'required|in:link,email',
        'job.apply_value' => 'required',
        'job.payment_type' => 'required|in:hourly,fixed',
        'job.budget' => 'required|numeric|min:0',
        'job.location' => 'required|max:254',
        'selected_skills' => 'required',
        'job.hours_per_week_id' => 'required',
        'job.experience_level_id' => 'required',
        'job.job_length_id' => 'required',
        'job.is_active' => 'boolean',
    ];

    public function mount(JobPosition $job)
    {
        // Cannot access job of another user or company.
        if ($job->user_id !== auth()->id() || $job->team_id !== auth()->user()->currentTeam->id) {
            abort(403);
        }

        $this->job = $job;
        $this->selected_skills = $job->skills->pluck('id')
            ->all();
    }

    /**
     * Update a job.
     */
    public function save()
    {
        $this->validate();

        if (empty($this->job->is_active)) {
            $this->job->is_active = false;
        }
        $this->job->save();

        $this->job->skills()
            ->sync($this->selected_skills);

        $this->success('Update the job successfully!');

        $this->redirectRoute('filament.jobs.pages.show', [
            'team' => $this->job->company->id,
            'job' => $this->job,
        ]);
    }

    public function getJobPositionSkillOptionsProperty()
    {
        return Tag::getWithType('job_position_skill')
            ->pluck('name', 'id');
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|mixed[]
     */
    public function getViewData(): array
    {
        return view('catalyst::livewire.jobs.pages.jobs.update-job', [
            'companies' => auth()->user()
                ->allTeams(),
            'applyTypes' => ApplyType::pluck('name', 'code'),
            'paymentTypes' => PaymentType::pluck('name', 'code'),
            'currentJobPositionSkills' => $this->job->skills->pluck('name', 'id'),
            'jobPositionSkillOptions' => $this->jobPositionSkillOptions,
            'jobLengths' => JobPositionLength::all(),
            'hoursPerWeek' => HoursPerWeek::pluck('value', 'id'),
            'experienceLevels' => ExperienceLevel::all(),
            'projectSizes' => ProjectSize::orderBy('order')
                ->get()
                ->toArray(),
        ]);
    }
}
