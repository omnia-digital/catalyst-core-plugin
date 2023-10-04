@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-primary items-center">
        <div class="flex-1 flex items-center">
            <x-library::heading.1 class="py-4 hover:cursor-pointer">Contacts</x-library::heading.1>
        </div>
    </div>
    <div class="px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
        @forelse (auth()->user()->followers as $item)
            <x-user-tile :user="$item->follower"/>
        @empty
            <p>No contacts to show.</p>
        @endforelse
    </div>
@endsection
