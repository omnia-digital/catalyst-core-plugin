<x-form-section submit="createTeam">
    <x-slot name="title">
        {{ Translate::get('Team Details') }}
    </x-slot>

    <x-slot name="description">
        {{ Translate::get('Create a new team to collaborate with others on teams.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <catalyst::components.label value="{{ Translate::get('Team Owner') }}"/>

            <div class="flex items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}"
                     alt="{{ $this->user->name }}">

                <div class="ml-4 leading-tight">
                    <div>{{ $this->user->name }}</div>
                    <div class="text-dark-text-color text-sm">{{ $this->user->email }}</div>
                </div>
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <catalyst::components.label for="name" value="{{ Translate::get('Team Name') }}"/>
            <catalyst::components.input id="name" type="text" class="mt-1 block w-full" wire:model.live="state.name" autofocus/>
            <catalyst::components.input-error for="name" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <catalyst::components.button>
            {{ Translate::get('Create') }}
        </catalyst::components.button>
    </x-slot>
</x-form-section>
