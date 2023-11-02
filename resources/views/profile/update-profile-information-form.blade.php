<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ Translate::get('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ Translate::get('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                       wire:model.live="photo"
                       x-ref="photo"
                       x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            "/>

                <catalyst::components.label for="photo" value="{{ Translate::get('Photo') }}"/>

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                         class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <catalyst::components.secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent.stop="$refs.photo.click()">
                    {{ Translate::get('Select A New Photo') }}
                </catalyst::components.secondary-button>

                @if ($this->user->profile_photo_path)
                    <catalyst::components.secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ Translate::get('Remove Photo') }}
                    </catalyst::components.secondary-button>
                @endif

                <catalyst::components.input-error for="photo" class="mt-2"/>
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <catalyst::components.label for="name" value="{{ Translate::get('Name') }}"/>
            <catalyst::components.input id="name" type="text" class="mt-1 block w-full" wire:model.live="state.name" autocomplete="name"/>
            <catalyst::components.input-error for="name" class="mt-2"/>
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <catalyst::components.label for="email" value="{{ Translate::get('Email') }}"/>
            <catalyst::components.input id="email" type="email" class="mt-1 block w-full" wire:model.live="state.email"/>
            <catalyst::components.input-error for="email" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ Translate::get('Saved.') }}
        </x-action-message>

        <catalyst::components.button wire:loading.attr="disabled" wire:target="photo">
            {{ Translate::get('Save') }}
        </catalyst::components.button>
    </x-slot>
</x-form-section>
