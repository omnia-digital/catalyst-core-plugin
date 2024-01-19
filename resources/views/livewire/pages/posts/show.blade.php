{{--@extends('catalyst::livewire.layouts.pages.default-page-layout')--}}

{{--@section('content')--}}
    <x-filament-panels::page>
    <div class="flex items-center mt-6 max-w->post-card-max-w mx-auto">
        <div class="mr-6 w-8">
            <div class="hover:bg-neutral-light p-2 rounded-full bg-secondary hover:text-secondary flex justify-center items-center">
                <a href="{{ route('resources.home') }}">
                    <x-heroicon-o-arrow-left class="h-4"/>
                </a>
            </div>
        </div>
        <div class="text-2xl">
            {{ ucfirst(strtolower($this->post->type?->name ?? 'Post')) }}
        </div>
    </div>
    <div class="mt-6 max-w->post-card-max-w mx-auto divide-y">
        <livewire:catalyst::components.post-card-dynamic wire:key="post-{{ $this->post->id }}" :post="$this->post"
                                                       :clickable="false"/>

                @if ($this->post->type == \OmniaDigital\CatalystCore\Enums\PostType::RESOURCE)
                    <x-library::card class="px-4 py-2 sm:px-6 flex items-center sm:rounded-t-none justify-between flex-wrap sm:flex-nowrap">{!! $this->post->body !!}</x-library::card>
                @endif
        @auth
            <livewire:catalyst::comment-section :post="$this->post"/>
            <livewire:media-manager/>
        @endauth
    </div>

    <livewire:authentication-modal/>
    </x-filament-panels::page>
{{--@endsection--}}
