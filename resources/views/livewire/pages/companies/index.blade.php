@php use App\Models\Company; @endphp
@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="sticky top-[55px] z-40 rounded-b-lg px-4 flex items-center bg-primary items-center justify-between">
        <a href="{{ route('social.companies.home', []) }}">
            <div class="flex-1 flex items-center space-x-2 -ml-1">
                <x-library::icons.icon name="fa-regular fa-users" size="w-8 h-8" color="text-white-text-color"/>
                <x-library::heading.1 class="py-4"
                                      text-color="text-white-text-color">{{ $lens ? Translate::get('Companies') : Translate::get('Companies') }}
                </x-library::heading.1>
            </div>
        </a>
        @can('create', Company::class)
            <x-library::button.index x-data=""
                                     x-on:click.prevent="$openModal('create-company')"
                                     bg-color="primary"
                                     text-color="text-primary"
                                     size="w-60 h-10" py="py-2 "
                                     class="hidden sm:block">
                {{ Translate::get('Create Company') }}
            </x-library::button.index>
        @endcan
    </div>

    <div class="px-4 sm:px-2 lg:px-0">
        @if (count($categories))
            <div class="flex justify-between space-x-2 pt-4 mb-4">
                @foreach ($categories as $category)
                    <x-library::button.link
                            :href="route('social.companies.home', ['lens' => str($category['slug'])->slug()->value()])"
                            class="w-full h-16 {{ str($lens) == str($category['slug'])->slug()
                ->value() ? 'border-primary text-base-text-color' : 'text-base-text-color' }}">
                        {{ $category['name'] }}
                    </x-library::button.link>
                @endforeach
            </div>
        @endif

        <!-- Filters -->
        @include('livewire.partials.filters', ['skipFilters' => ['has_attachment', 'members']])

        {{-- Sorting & Filters --}}
        {{-- <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <p class="font-bold">Sort</p>
                <x-library::dropdown>
                    <x-slot name="trigger" class="flex items-center cursor-pointer text-gray-600">
                        <span class="text-sm"> {{ Translate::get('By') . ' ' .  $sortField }}</span>

                        @if ($sortDirection === 'asc')
                            <x-heroicon-s-arrow-down class="w-4 h-4 ml-1"/>
                        @else
                            <x-heroicon-s-arrow-up class="w-4 h-4 ml-1"/>
                        @endif
                    </x-slot>

                    <x-library::dropdown.item wire:click.prevent="sortBy('name')">{{ Translate::get('By name') }}</x-library::dropdown.item>
                    <x-library::dropdown.item wire:click.prevent="sortBy('members')">{{ Translate::get('By members') }}</x-library::dropdown.item>
                    {{--                        <x-library::dropdown.item wire:click.prevent="sortBy('rating')">By rating</x-library::dropdown.item>}}
                </x-library::dropdown>
            </div>
            <div class="min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-6">
                <div class="flex items-center px-6 py-4 md:max-w-3xl md:mx-auto lg:max-w-none lg:mx-0 xl:px-0">
                    <div class="w-full">
                        <label for="search" class="sr-only">{{ Translate::get('Search') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-library::icons.icon name="fa-duotone fa-magnifying-glass" class="h-5 w-5 text-light-text-color dark:text-light-text-color" aria-hidden="true"/>
                            </div>
                            <input wire:model.live.debounce.400ms="filters.search" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-neutral bg-neutral rounded-md leading-5 dark:bg-gray-700 text-light-text-color placeholder-light-text-color focus:outline-none focus:ring-dark-text-color sm:text-sm" placeholder="Search" type="search">
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


        @if ($lens)
            <x-library::heading.2 class="pt-3">{{ str($lens)->headline() }}</x-library::heading.2>
        @endif
        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-4">
            @forelse ($companies as $company)
                <livewire:social::components.company-card :company="$company" wire:key="company-{{ $company->id }}"/>
            @empty
                <p class="p-4 bg-secondary rounded-md text-base-text-color">{{ Translate::get('No Companies Found') }}</p>
            @endforelse
        </div>
        <livewire:companies.create-company-modal/>
    </div>
@endsection
