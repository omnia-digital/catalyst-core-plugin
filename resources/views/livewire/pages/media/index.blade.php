@php use App\Models\MediaFile; @endphp
@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class=" pr-4 sm:pr-6 lg:pr-4">
        <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg px-4 pl-4 flex items-center justify-between bg-primary">
            <div class="py-2 pl-2">
                <div class="flex-1 flex items-center space-x-2 -ml-1">
                    <x-library::icons.icon name="fa-solid fa-images" size="w-8 h-8" color="text-white-text-color"/>
                    <x-library::heading.1 class="text-3xl hover:cursor-pointer" text-color="text-white-text-color">Media
                        Library
                    </x-library::heading.1>
                </div>
                <div>
                    <p class="text-white">Manage all of your media across the platform.</p>
                </div>
            </div>
            <div>
                @if (auth()->user()?->can('create', MediaFile::class))
                    @auth
                        <x-library::button wire:click="$set('showCreateModal', true)">
                            <span class="whitespace-nowrap">{{ Translate::get('Create Media') }}</span>
                        </x-library::button>
                    @else
                        <x-library::button wire:click="$set('showCreateModal', true)">
                            <span class="whitespace-nowrap">{{ Translate::get('Create Media') }}</span>
                        </x-library::button>
                        <livewire:authentication-modal/>
                    @endauth
                @endif

            </div>
        </div>

        <div>
            <!-- List of Media -->
            <main class="flex-1 overflow-y-auto">
                <div class="space-y-2">
                    <div class="flex justify-between gap-3 flex-wrap bg-secondary px-6 py-2 rounded-lg mb-2 border-t border-b border-gray-100 items-center">
                        <div class="flex justify-start items-center space-x-3">
                            <div class="font-bold">
                                {{ Translate::get('Filters') }}
                            </div>

                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" hidden>
                                <x-library::icons.icon name="fa-duotone fa-magnifying-glass" class="h-5 w-5 text-light-text-color dark:text-light-text-color"
                                                     aria-hidden="true"/>
                                <span class="sr-only">Search</span>
                            </div>
                            <div class="w-full relative">

                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-library::icons.icon name="fa-duotone fa-magnifying-glass"
                                            class="h-5 w-5 text-light-text-color dark:text-light-text-color"
                                            aria-hidden="true"/>
                                </div>
                                <x-library::input.text type="search" wire:model.live.debounce.500ms="filters.search"
                                                       placeholder="Search Media"
                                                       class="px-4 block w-full pl-10 pr-3 py-2 border border-neutral bg-neutral rounded-md leading-5 dark:bg-gray-700 text-light-text-color placeholder-light-text-color focus:outline-none focus:ring-dark-text-color sm:text-sm"/>
                            </div>
                            <a type="button" class="whitespace-nowrap hover:underline cursor-pointer"
                               wire:click="toggleShowFilters">@if ($showFilters)
                                    Hide
                                @endif Advanced Search...</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-auto flex space-x-4">
                            @if ($this->isUsingListLayout())
                                <button type="button"
                                        {{ empty($selected) ? 'disabled' : '' }} wire:click="$toggle('showDeleteModal')"
                                        class="p-1.5 rounded-md border border-gray-300 text-gray-400 flex items-center space-x-2 {{ empty($selected) ? '' : 'hover:shadow-md text-blue-500 border-blue-400' }} focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                    <x-heroicon-o-trash class="h-5 w-5"/>
                                    <span class="whitespace-nowrap">Delete Selected</span>
                                </button>
                            @endif
                        </div>
                    </div>
                    @forelse ($errors as $error)
                        <div class="flex justify-between flex-wrap">
                            <div class="mt-1 text-red-500 text-sm">{{ $error }}</div>
                        </div>
                    @empty
                    @endforelse

                    <!-- Advanced Search -->
                    <div>
                        <div class=" {{ ($showFilters) ? '' : 'hidden' }} bg-secondary p-4 rounded flex relative flex-wrap">
                            <div class="w-1/2 pl-2 space-y-4">
                                <label class="block" for="filter-attached-types">Attached Type</label>
                                <x-library::input.select wire:model.live="filters.attached_type"
                                                         id="filter-attached-types" :options="$this->getAttachedTypes()"
                                                         placeholder="All"
                                                         :enableDefaultOption="true"/>

                                <label class="block" for="filter-collection-names">Collection Name</label>
                                <x-library::input.select wire:model.live="filters.collection"
                                                         id="filter-collection-names"
                                                         :options="$this->getCollectionNames()" placeholder="All"
                                                         :enableDefaultOption="true"/>

                            </div>

                            <div class="w-1/2 pl-2 space-y-4">
                                <label class="block" for="filter-date-min">Minimum Date</label>
                                <x-library::input.date wire:model.live="filters.date_min" id="filter-date-min"/>

                                <label class="block" for="filter-date-max">Maximum Date</label>
                                <x-library::input.date wire:model.live="filters.date_max" id="filter-date-max"/>

                            </div>
                            <a type="button" wire:click="resetFilters"
                               class="ml-auto p-4 hover:underline cursor-pointer">Reset Filters</a>
                        </div>
                    </div>

                    <div class="flex-1 flex items-stretch gap-4">
                        <section class="pb-16 w-full">
                            <div class="flex items-center space-x-2 mb-4 ml-4">
                                <label for="perPage" class="text-sm font-medium leading-5 text-gray-700">
                                    Per Page
                                </label>

                                <div class="w-20">
                                    <x-library::input.select class="" wire:model.live="perPage" id="perPage"
                                                             :showDefaultOption="false"
                                                             :options="[10 => '10', 25 => '25', 50 => '50',]"/>
                                </div>
                            </div>
                            <!-- Media Gallery -->
                            @if ($mediaList->count() > 0)
                                <div>
                                    <div class="-mx-4 sm:-mx-6 md:mx-0">
                                        @if ($this->isUsingGridLayout())
                                            <ul role="list"
                                                class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6  md:grid-cols-4 md:gap-x-4 lg:grid-cols-3 xl:grid-cols-4">
                                                @foreach ($mediaList as $media)
                                                    <x-media.grid-item
                                                            wire:key="media-item-{{ $media->id }}"
                                                            wire:click="selectMedia({{ $media->id }})"
                                                            :media="$media"
                                                            :selected="$media->id === $selectedMedia"
                                                    />
                                                @endforeach
                                            </ul>
                                        @else
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-black sm:pl-6">
                                                        <x-library::input.checkbox wire:model.live="selectPage"/>
                                                    </th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4">
                                                        <span class="sr-only">Preview</span>
                                                    </th>
                                                    <th scope="col"
                                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-black sm:pl-0">
                                                        <span>File</span>
                                                    </th>
                                                    <th scope="col"
                                                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-black lg:table-cell">
                                                        <span>Attached to</span>
                                                    </th>
                                                    <th scope="col"
                                                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-black lg:table-cell">
                                                        <span>Collection</span>
                                                    </th>
                                                    <th scope="col"
                                                        class="hidden px-3 py-3.5 text-left text-sm font-semibold text-black lg:table-cell">
                                                        <span>Date</span>
                                                    </th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4">
                                                        <span class="sr-only">Action</span>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 bg-white">
                                                @if ($selectPage)
                                                    <tr wire:key="row-message">
                                                        <td colspan="7">
                                                            @unless ($selectAll)
                                                                <div>
                                                                    <span><strong>{{ $mediaList->count() }}</strong> of {{ $mediaList->total() }} files selected </span>
                                                                    <a class="ml-6 hover:underline cursor-pointer"
                                                                       type="button" wire:click="selectAll">Select
                                                                        All?</a>
                                                                </div>
                                                            @else
                                                                <span>You are currently selecting all <strong>{{ $mediaList->total() }}</strong> files.</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                                @foreach ($mediaList as $media)
                                                    <tr>
                                                        <td class="py-3.5 pl-4 pr-3 sm:pl-6">
                                                            <x-library::input.checkbox wire:model.live="selected"
                                                                                       value="{{ $media->id }}"/>
                                                        </td>
                                                        <td class="relative py-3.5 pl-3 pr-4">
                                                            <x-attachment-icon for="{{ $media->mime_type }}"/>
                                                        </td>
                                                        <td
                                                                class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-black sm:w-auto sm:max-w-full sm:pl-0">
                                                            {{ $media->name }}
                                                            <dl class="font-normal lg:hidden">
                                                                <dt class="sr-only">Attached to</dt>
                                                                <dd class="mt-1 text-dark-text-color">
                                                                    <a href="{{ $media->model->getUrl ?? '' }}">
                                                                        @isset($media->model)
                                                                            {{ class_basename($media->model) }}
                                                                            ({{ $media->model->id }}
                                                                            ): {{ $media->model->title }}
                                                                        @else
                                                                            <div>(Unattached)</div>
                                                                            <div><a href="#">Attach</a></div>
                                                                        @endisset
                                                                    </a>
                                                                </dd>
                                                                <dt class="sr-only lg:hidden">Collection</dt>
                                                                <dd class="mt-1 truncate text-dark-text-color lg:hidden">
                                                                    Collection: {{ $media->collection_name }}</dd>
                                                                <dt class="sr-only lg:hidden">Date</dt>
                                                                <dd class="mt-1 truncate text-dark-text-color lg:hidden">{{ $media->created_at->format('m/d/y') }}</dd>
                                                            </dl>
                                                        </td>
                                                        <td class="hidden px-3 py-4 text-sm text-dark-text-color lg:table-cell">
                                                            @isset($media->model)
                                                                {{ class_basename($media->model) }}
                                                                : {{ $media->model->title }}
                                                            @else
                                                                <div>(Unattached)</div>
                                                                <div><a href="#">Attach</a></div>
                                                            @endisset
                                                        </td>
                                                        <td class="hidden px-3 py-4 text-sm text-dark-text-color lg:table-cell">{{ $media->collection_name }}</td>
                                                        <td class="hidden px-3 py-4 text-sm text-dark-text-color lg:table-cell">{{ $media->created_at->format('m/d/y') }}</td>
                                                        <td class="py-4 pl-3 pr-4 text-right text-sm font-medium">
                                                            <a type="button" wire:click="editMedia('{{ $media->id }}')"
                                                               class="text-indigo-600 cursor-pointer hover:underline hover:text-indigo-900">Edit<span
                                                                        class="sr-only">, {{ $media->model->title }}</span></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif


                                        <div>
                                            {{ $mediaList->links() }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>No media to show...</p>
                            @endif
                        </section>

                        <!-- Selected Media Details -->
                        @if ($this->isUsingGridLayout())
                            <x-media.details-panel
                                    :selectedMedia="$selectedMedia"
                            />
                        @endif
                    </div>
                    <livewire:media-manager :handleUploadProcess="false"/>
            </main>

            <!-- Delete Modal -->
            <form wire:submit="deleteSelected">
                <x-dialog-modal wire:model.live="showDeleteModal">
                    <x-slot name="title">Delete Media</x-slot>
                    <x-slot name="content">
                        <div>Are you sure you? This action is irreversible.</div>
                    </x-slot>
                    <x-slot name="footer">
                        <x-secondary-button wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-button class="ml-2" type="submit" wire:loading.attr="disabled">
                            {{ __('Delete') }}
                        </x-button>
                    </x-slot>
                </x-dialog-modal>
            </form>

            <!-- Save Media Modal -->
            <form wire:submit="saveMedia">
                <x-dialog-modal wire:model.live="showEditModal">
                    <x-slot name="title">Edit Media</x-slot>
                    <x-slot name="content">
                        <div>
                            <x-library::input.label value="File"/>
                            <div class="bg-gray-200 rounded-md flex items-center space-x-2 p-4 h-20">
                                <x-attachment-icon for="{{ $editingMedia?->mime_type }}"/>
                                <p>{{ $editingMedia?->name ?? 'No file' }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-library::input.label value="Name"/>
                            <x-library::input.text id="editingMedia.name" wire:model.live="editingMedia.name"
                                                   placeholder="Name"/>
                            <x-input-error for="editingMedia.name" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-library::input.label value="Attached to Type"/>
                            <x-library::input.select class="" wire:model.live="editingMedia.model_type"
                                                     id="editingMedia.model_type" :showDefaultOption="false"
                                                     :options="$availableModelTypes"/>
                            <x-input-error for="editingMedia.model_type" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-library::input.label value="Attached to"/>
                            <x-library::input.select class="" wire:model.live="editingMedia.model_id"
                                                     id="editingMedia.model_id" :showDefaultOption="false"
                                                     :options="$this->availableModelIds"/>
                            <x-input-error for="editingMedia.model_id" class="mt-2"/>
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <x-secondary-button wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-button class="ml-2" type="submit" wire:loading.attr="disabled">
                            {{ __('Submit') }}
                        </x-button>
                    </x-slot>
                </x-dialog-modal>
            </form>

            <!-- Create Media Modal -->
            <form wire:submit="createMedia">
                <x-dialog-modal wire:model.live="showCreateModal">
                    <x-slot name="title">Create Media</x-slot>
                    <x-slot name="content">
                        <div
                                x-data="{
                            openState: false,
                            showImages: true,
                            images: [],
                            users: {},
                            showMediaManager(file, metadata) {
                                $dispatch('media-manager:show', {
                                        id: '{{ $editorId }}',
                                        file: file,
                                        metadata: metadata
                                    })->to('media-manager')
                                );
                            },

                            setImage(event) {
                                if (event.detail.id === '{{ $editorId }}') {
                                    this.$wire.call('setImage', event.detail);
                                }
                            },

                            setImages(event) {
                                if (event.detail.id === '{{ $editorId }}') {
                                    this.images = event.detail.images
                                }
                            },

                            removeImage(index) {
                                this.$wire.call('removeImage', index);
                            },

                        }"
                                x-on:media-manager:file-selected.window="setImage"
                                x-on:media-library:image-set.window="setImages"
                                class="mt-4"
                        >
                            @if ($openState == false)
                                <button
                                        x-on:click.prevent.stop="showMediaManager(null, {})"
                                        type="button"
                                        class="bg-gray-200 rounded-md w-full flex justify-center items-center space-x-2 p-4"
                                >
                                    <i class="fa-solid fa-image w-5 h-5 text-gray-500"></i>
                                    <span>Click here to start adding images</span>
                                </button>
                                <div>
                                    <x-library::input.error for="image" class="mt-2"/>
                                </div>
                            @endif
                            <ul
                                    x-show="showImages"
                                    x-transition
                                    role="list"
                                    class="mt-4 grid gap-x-4 gap-y-8 sm:gap-x-6 xl:gap-x-8"
                                    x-bind:class="{'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6': images.length > 2, 'grid-cols-2': images.length === 1, 'grid-cols-2': images.length === 2}"
                            >
                                <template x-for="(image, index) in images" :key="index">
                                    <li class="relative cursor-pointer">
                                        <button
                                                x-on:click.prevent.stop="removeImage(index)"
                                                type="button"
                                                class="absolute -top-2 -right-2 z-10 bg-red-100 rounded-full p-1 inline-flex items-center justify-center hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500"
                                        >
                                            <x-library::icons.icon name="x-mark"
                                                                   class="w-5 h-5 text-red-500 hover:text-red-400"/>
                                        </button>

                                        <div class="focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 overflow-hidden">
                                            <img x-bind:src="image" alt=""
                                                 class="group-hover:opacity-75 object-cover pointer-events-none">
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>

                    </x-slot>
                    <x-slot name="footer">
                        <x-secondary-button wire:click="$set('showCreateModal', false)" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-button class="ml-2" type="submit" wire:loading.attr="disabled">
                            {{ __('Submit') }}
                        </x-button>
                    </x-slot>
                </x-dialog-modal>
            </form>
        </div>
    </div>
@endsection
