<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Projects;

use Livewire\Component;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Models\Project;
use OmniaDigital\CatalystCore\Models\User;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use OmniaDigital\CatalystLocation\Models\Location;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Show extends Component
{
    use WithGuestAccess;
    use WithMap;

    public $project;

    public $displayUrl = null;

    public $displayID = null;

    public ?User $userToAddAwardsTo;

    public $applicationsCount = 0;

    public $awardsToAdd = [];

    public $additionalInfo = [
        'likes',
        'comments',
        'members',
    ];

    public $activity = [
        'user' => [
            'avatar' => 'https://via.placeholder.com/150',
        ],
        'title' => 'Activity Title',
        'created_at' => 'June 1, 2022',
        'id' => 1,
        'message' => 'Activity Message',
        'project' => [
            'link' => '#',
        ],
        'members' => [
            [
                'avatar' => 'https://via.placeholder.com/150',
                'name' => 'Member Name',
                'link' => '#',
            ],
        ],
    ];

    protected $listeners = ['addUserAwards', 'modal-closed' => 'resetAwardsSelection'];

    public function mount(Project $project)
    {
        $this->displayUrl = $project->sampleImages()->first()->getFullUrl();
        $this->displayID = $project->sampleImages()->first()->id;
//        $this->applicationsCount = $project->projectApplications->count();
    }

    public function getPlacesProperty()
    {
        $places = Location::select(['lat', 'lng', 'model_id', 'model_type'])
            ->where('model_id', $this->project->id)
            ->where('model_type', Project::class)
            ->hasCoordinates()
            ->with('model')
            ->get()
            ->map(function (Location $location) {
                return [
                    'id' => $location->id,
                    'name' => $location->model->name,
                    'lat' => $location->lat,
                    'lng' => $location->lng,
                ];
            });

        return $places->all();
    }

    public function getRecentPostsProperty()
    {
        return $this->project->posts()->take(2)->get();
    }

    public function showPost($post)
    {
        return $this->redirectroute('catalyst-social.posts.show', $post['id']);
    }

    public function setImage(Media $media)
    {
        $this->displayUrl = $media->getFullUrl();
        $this->displayID = $media->id;
    }

    public function resetAwardsSelection()
    {
        $this->reset('awardsToAdd');
    }

    public function addUserAwards($userID)
    {
        $this->dispatch('add-awards-modal', type: 'open');
        $this->userToAddAwardsTo = User::find($userID);
    }

    public function addAward(User $user)
    {
        $user->awards()->attach($this->awardsToAdd);

        $this->dispatch('notify', message: 'Awards Added', type: 'success');
        $this->dispatch('add-awards-modal', type: 'close');
    }

    public function getRemainingAwards(User $user)
    {
        return Award::whereNotIn('id', $user->awards()->pluck('awards.id')->toArray())->get();
    }

    /**
     * If we decide to allow the project owners to decide if their project is public
     * or private then we can edit this method to account for that.
     */
    public function getIsPublicProperty()
    {
        return false;
    }

    public function getIsMemberProperty()
    {
        return $this->project->hasUser(auth()->user());
    }

    public function getCanViewProjectContentProperty()
    {
        if (Catalyst::isAllowingGuestAccess()) {
            return true;
        }

        return $this->isPublic || $this->isMember;
    }

    public function render()
    {
        return view('catalyst::livewire.pages.projects.show');
    }
}
