<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Media;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use OmniaDigital\CatalystCore\Models\MediaFile;
use OmniaDigital\CatalystCore\Models\Team;
use OmniaDigital\CatalystCore\Traits\Filter\WithBulkActions;
use OmniaDigital\CatalystCore\Traits\Filter\WithPerPagePagination;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;
use OmniaDigital\OmniaLibrary\Livewire\WithLayoutSwitcher;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use OmniaDigital\OmniaLibrary\Livewire\WithSorting;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Index extends Component
{
    use WithBulkActions;
    use WithCachedRows;
    use WithLayoutSwitcher;
    use WithNotification;
    use WithPerPagePagination;
    use WithSorting;

    public ?Media $editingMedia = null;

    public $showDeleteModal = false;

    public $showEditModal = false;

    public $showFilters = false;

    public $showCreateModal = false;

    public ?string $editorId = null;

    public array $images = [];

    public bool $openState = false;

    public ?int $selectedMedia = null;

    public $availableModelTypes = [
        Episode::class => 'Episodes',
    ];

    public $filters = [
        'search' => '',
        'collection' => '',
        'attached_type' => '',
        'date_min' => null,
        'date_max' => null,
    ];

    protected $listeners = [
        'media-deselected' => 'deselectMedia',
        'refreshMedia' => '$refresh',
    ];

    public function mount()
    {
        $this->editorId = uniqid();
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getAttachedTypes()
    {
        return Media::pluck('model_type')->unique()->map(function ($type) {
            return class_basename($type);
        })->toArray();
    }

    public function getCollectionNames()
    {
        return Media::pluck('collection_name')->unique()->toArray();
    }

    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->success('You\'ve deleted ' . $deleteCount . ' ' . Str::plural('item', $deleteCount));
    }

    public function editMedia(Media $media)
    {
        $this->useCachedRows();

        if ($this->editingMedia?->isNot($media) || is_null($this->editingMedia)) {
            $this->editingMedia = $media;
        }

        $this->showEditModal = true;
    }

    public function createMedia()
    {
        $mediaFile = MediaFile::create([
            'name' => 'Not Attached',
            'user_id' => auth()->id(),
        ]);

        $mediaFile->attachMedia($this->images);

        $this->reset('images');

        $this->emitImagesSet();

        $this->showCreateModal = false;

        $this->resetPage();

        $this->success('Media added successfully');
    }

    public function saveMedia()
    {
        $this->validate();

        $this->editingMedia->save();

        $this->showEditModal = false;
    }

    public function getAvailableModelIdsProperty()
    {
        if (is_null($this->editingMedia?->model_type)) {
            return [];
        }

        return $this->editingMedia->model_type::pluck('title', 'id')->toArray();
    }

    public function selectMedia($media)
    {
        $this->useCachedRows();

        $this->selectedMedia = $media;

        $this->dispatch('mediaSelected', $media)->to('partials.media-library-details');
    }

    public function deselectMedia()
    {
        $this->useCachedRows();

        $this->reset('selectedMedia');
    }

    public function setImage($image)
    {
        array_push($this->images, $image['url']);

        $this->emitImagesSet();
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
        }

        $this->emitImagesSet();
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function getRowsQueryProperty()
    {
        return Media::query()
            ->whereHasMorph('model', [Post::class, Profile::class], function ($q, $type) {
                return $q->where('user_id', auth()->id());
            })
            ->when(
                $this->filters['date_min'],
                fn ($query, $date) => $query->where('created_at', '>=', Carbon::parse($date))
            )
            ->when(
                $this->filters['date_max'],
                fn ($query, $date) => $query->where('created_at', '<=', Carbon::parse($date))
            )
            ->when($this->filters['search'], function ($query, $search) {
                return $query
                    ->whereHasMorph('model', '*', function ($query, $type) use ($search) {
                        $column = match ($type) {
                            Post::class => 'body',
                            Profile::class => ['handle', 'first_name', 'last_name'],
                            default => 'name'
                        };

                        if (is_array($column)) {
                            foreach ($column as $key => $attribute) {
                                $query = ($key === 0) ?
                                    $query->where($attribute, 'like', '%' . $search . '%') :
                                    $query->orWhere($attribute, 'like', '%' . $search . '%');
                            }
                        } else {
                            $query = $query->where($column, 'like', '%' . $search . '%');
                        }

                        return $query;
                    })
                    ->orWhere('name', 'like', '%' . $search . '%');
            })->whereNot('model_type', Team::class);
    }

    public function render()
    {
        return view('catalyst::livewire.pages.media.index', ['mediaList' => $this->rows]);
    }

    protected function rules()
    {
        return [
            'editingMedia.name' => ['nullable', 'max:254'],
            'editingMedia.model_type' => [
                'string',
                'in:' . collect($this->availableModelTypes)->map(fn ($type, $key) => $key)->implode(','),
            ],
            'editingMedia.model_id' => ['integer'],
            'editingMedia.collection_name' => ['string'],
        ];
    }

    private function emitImagesSet(): void
    {
        $this->dispatch(
            'media-library:image-set',
            id: $this->editorId,
            images: $this->images,
        );
    }
}
