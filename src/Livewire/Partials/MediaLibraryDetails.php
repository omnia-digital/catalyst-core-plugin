<?php

namespace OmniaDigital\CatalystCore\Livewire\Partials;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Post;
use OmniaDigital\CatalystCore\Models\Profile;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Traits\WithSlideOver;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\ImageFactory;

class MediaLibraryDetails extends Component
{
    use WithNotification;
    use WithSlideOver;

    public ?Media $media = null;

    public $showDeleteMediaModal = false;

    protected $listeners = [
        'mediaSelected' => 'findMedia',
        'media-deselected' => 'resetMedia',
    ];

    public function mount($mediaId = null)
    {
        $this->findMedia($mediaId);
    }

    public function findMedia($mediaId)
    {
        // Don't do anything when user select same media.
        if ($mediaId === $this->media?->id) {
            return;
        }

        $this->media = Media::find($mediaId);

        // Dispatch event for open the over-slide on mobile
        $this->showSlideOver();
    }

    public function deleteMedia()
    {
        if (is_null($this->media)) {
            return;
        }

        $this->media->delete();

        $this->showDeleteMediaModal = false;

        $this->media = null;

        $this->dispatch('refreshMedia');

        $this->success('Media deleted');
    }

    public function resetMedia()
    {
        $this->reset('media');
    }

    public function getModelTitleAttribute($model)
    {
        $column = match (get_class($model)) {
            Post::class => 'body',
            Team::class => 'name',
            Profile::class => 'handle',
            default => 'name'
        };

        return $model->$column;
    }

    public function getWidth(Media $media)
    {
        $image = ImageFactory::load($media->getPath());

        return $image->getWidth();
    }

    public function getHeight(Media $media)
    {
        $image = ImageFactory::load($media->getPath());

        return $image->getHeight();
    }

    public function render()
    {
        return view('livewire.partials.media-library-details');
    }
}
