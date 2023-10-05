<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Pages\Teams\Admin;

use Illuminate\Validation\Rule;
use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Traits\Team\WithTeamManagement;
use Spatie\Permission\Models\Role;

class ManageTeamMembers extends Component
{
    use WithTeamManagement;

    public $team;

    public $roleName;

    public $applicationsCount = 0;

    public $invitationsCount = 0;

    protected $listeners = [
        'member_added' => '$refresh',
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->applicationsCount = $this->team->teamApplications->count();
        $this->invitationsCount = $this->team->teamInvitations->count();
    }

    public function createRole()
    {
        $this->validate([
            'roleName' => [
                'required',
                'string',
                Rule::unique(config('permission.table_names.roles'), 'name')->where(fn ($q) => $q->where(
                    'team_id',
                    $this->team->id
                )),
            ],
        ]);

        Role::create([
            'team_id' => $this->team->id,
            'name' => $this->roleName,
        ]);

        $this->reset('roleName');
    }

    public function getTeamRolesProperty()
    {
        return Role::where('team_id', $this->team->id)->get();
    }

    public function render()
    {
        return view('social::livewire.pages.teams.admin.manage-team-members');
    }
}
