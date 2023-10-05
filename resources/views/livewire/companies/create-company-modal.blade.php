<x-library::modal id="create-company">
    <x-slot name="title">{{ Translate::get('Create Company') }}</x-slot>

    <x-slot name="content">
        <div>
            <div class="flex items-center">
                <x-library::input.label value="{{ Translate::get('Name') }}"/>
                <span class="text-red-600 text-sm ml-1">*</span>
            </div>
            <x-library::input.text wire:model.live="name" class="bg-secondary"
                                   placeholder="{{ Translate::get('Enter your Company Name') }}" required/>
            <x-library::input.error for="name"/>
        </div>
        <div class="mt-6">
            <div class="flex items-center">
                <x-library::input.label value="{{ Translate::get('What is your Company associated with?') }}"/>
                <span class="text-red-600 text-sm ml-1">*</span>
            </div>
            <p class="text-neutral-dark">{{ Translate::get('(you can choose more than one)') }}</p>
            <x-library::input.selects wire:model.live="companyTypes" :options="$companyTags"/>
        </div>
        {{--        <div class="mt-6">--}}
        {{--            // @TODO [Josh] - we can allow the user to choose a resource within the platform like a User, Game, Post, etc.--}}
        {{--            We should probably have this listed as an array somewhere like--}}
        {{--            $companyFocusResources = ['User', 'Game', 'Post', 'Event', 'Other'];--}}
        {{--            <div class="flex items-center">--}}
        {{--                <x-library::input.label value="{{ \Translate::get('Company Focus') }}" /><span class="text-red-600 text-sm ml-1">*</span>--}}
        {{--            </div>--}}
        {{--            <p class="text-neutral-dark">{{ \Translate::get('Do you want this Company to be focused on something?') }}</p>--}}
        {{--            <x-library::input.selects wire:model.live="companyFocus" :options="$companyFocuses" max="1"/>--}}
        {{--        </div>--}}
        {{--        <div class="mt-6">--}}
        {{--            <div class="flex items-center">--}}
        {{--                <x-library::input.label value="{{ \Translate::get('Start Date (can be changed later)') }}"/><span class="text-red-600 text-sm ml-1">*</span>--}}
        {{--            </div>--}}
        {{--            <x-library::input.date wire:model.live="startDate" placeholder="{{ \Translate::get('Company Launch Date') }}"/>--}}
        {{--            <x-library::input.error for="startDate"/>--}}
        {{--        </div>--}}
        {{--        <div class="mt-6">--}}
        {{--            <div class="flex items-center">--}}
        {{--                <x-library::input.label value="{{ \Translate::get('Summary') }}"/><span class="text-red-600 text-sm ml-1">*</span>--}}
        {{--            </div>--}}
        {{--            <x-library::input.textarea wire:model.live="summary" maxlength="280" placeholder="{{ \Translate::get('Summary') }}" />--}}
        {{--            <x-library::input.error for="summary"/>--}}
        {{--        </div>--}}
        {{--        <div class="mt-6">--}}
        {{--            <hr class="border-neutral-dark mt-6 mb-4"/>--}}
        {{--            <x-library::heading.3 class="text-xl mb-4">{{ \Translate::get('Media') }}</x-library::heading.3>--}}
        {{--            <div class="flex items-center">--}}
        {{--                <x-library::input.label value="{{ \Translate::get('Banner Image') }}" /><span class="text-red-600 text-sm ml-1">*</span>--}}
        {{--            </div>--}}
        {{--            <div class="flex justify-between items-center relative min-w-0 w-full border-neutral placeholder-neutral-dark bg-secondary rounded focus:ring-primary focus:border-primary text-sm p-2">--}}
        {{--                <input type="text" class="flex-1 border-none" wire:model.live="bannerImageName" placeholder="{{ \Translate::get('Upload file for banner') }}" readonly>--}}
        {{--                <label>--}}
        {{--                    <input type="file" wire:model.live="bannerImage" hidden required />--}}
        {{--                    <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-secondary bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-primary">{{ \Translate::get('Browse') }}</span>--}}
        {{--                </label>--}}
        {{--            </div>--}}
        {{--            <x-library::input.error for="bannerImage" />--}}
        {{--            @if ($bannerImage)--}}
        {{--                <div>--}}
        {{--                    <p>{{ \Translate::get('Banner Preview') }}:</p>--}}
        {{--                    <img class="w-full h-52" src="{{ $bannerImage->temporaryUrl() }}" alt="{{ $bannerImageName }} Preview">--}}
        {{--                </div>--}}
        {{--            @endif--}}

        <!-- Profile Photo -->
        {{--            <hr class="my-4 border-neutral-light">--}}
        {{--            <div>--}}
        {{--                <div class="flex items-center">--}}
        {{--                    <x-library::input.label value="{{ Translate::get('Company') }} Profile Photo" />--}}
        {{--                </div>--}}
        {{--                <div class="flex justify-between items-center relative min-w-0 w-full border-gray-300 placeholder-gray-500 bg-secondary rounded focus:ring-primary focus:border-primary text-sm p-2">--}}
        {{--                    <input type="text" class="flex-1 border-none" wire:model.live="profilePhotoName" placeholder="Upload file for profile photo" readonly>--}}
        {{--                    <label>--}}
        {{--                        <input type="file" wire:model.live="profilePhoto" hidden />--}}
        {{--                        <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white-text-color bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-primary">Browse</span>--}}
        {{--                    </label>--}}
        {{--                </div>--}}
        {{--                <x-library::input.error for="profilePhoto" />--}}
        {{--                @if ($profilePhoto)--}}
        {{--                    <div>--}}
        {{--                        <p>New Photo:</p>--}}
        {{--                        <img class="w-full h-32" src="{{ $profilePhoto->temporaryUrl() }}" alt="{{ $profilePhotoName }}">--}}
        {{--                    </div>--}}
        {{--                @endif--}}
        {{--            </div>--}}

        <!-- Main Image -->
        {{--            <hr class="my-4 border-neutral-light">--}}
        {{--            <div class="flex items-center mt-4">--}}
        {{--                <x-library::input.label value="{{ \Translate::get('Main Image') }}" /><span class="text-red-600 text-sm ml-1">*</span>--}}
        {{--            </div>--}}
        {{--            <div class="flex justify-between items-center relative min-w-0 w-full border-neutral placeholder-neutral-dark bg-secondary rounded focus:ring-primary focus:border-primary text-sm p-2">--}}
        {{--                <input type="text" class="flex-1 border-none" wire:model.live="mainImageName" placeholder="{{ \Translate::get('Upload file for banner') }}" readonly>--}}
        {{--                <label>--}}
        {{--                    <input type="file" wire:model.live="mainImage" hidden required />--}}
        {{--                    <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-secondary bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-primary">{{ \Translate::get('Browse') }}</span>--}}
        {{--                </label>--}}
        {{--            </div>--}}
        {{--            <x-library::input.error for="mainImage" />--}}
        {{--            @if ($mainImage)--}}
        {{--                <div>--}}
        {{--                    <p>{{ \Translate::get('Main Preview') }}:</p>--}}
        {{--                    <img class="w-full h-52" src="{{ $mainImage->temporaryUrl() }}" alt="{{ $mainImageName }}">--}}
        {{--                </div>--}}
        {{--            @endif--}}

        {{--            <!-- Sample Images -->--}}
        {{--            <hr class="my-4 border-neutral-light">--}}
        {{--            <div class="flex items-center mt-4">--}}
        {{--                <x-library::input.label value="{{ \Translate::get('Sample Media') }}" /><span class="text-red-600 text-sm ml-1">*</span>--}}
        {{--            </div>--}}
        {{--            <div class="flex justify-between items-center relative min-w-0 w-full border-neutral placeholder-neutral-dark bg-secondary rounded focus:ring-primary focus:border-primary text-sm p-2">--}}
        {{--                <p class="flex-1 py-2 px-3 text-[1rem] text-base-text-color">{{ \Translate::get('Upload multiple images to show off your company') }}</p>--}}
        {{--                <label>--}}
        {{--                    <input type="file" wire:model.live="sampleMedia" hidden multiple required />--}}
        {{--                    <span class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-secondary bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-primary">{{ \Translate::get('Browse') }}</span>--}}
        {{--                </label>--}}
        {{--            </div>--}}
        {{--            <x-library::input.error for="sampleMedia" />--}}
        {{--            @if (sizeof($sampleMedia))--}}
        {{--                <div>--}}
        {{--                    <p>{{ \Translate::get('Sample Media Preview') }}:</p>--}}
        {{--                    <div class="mt-3 rounded-lg overflow-hidden">--}}
        {{--                        <div class="grid grid-cols-{{ sizeof($sampleMedia) > 1 ? '2' : '1' }} grid-rows-{{ sizeof($sampleMedia) > 2 ? '2 h-80' : '1' }} gap-px">--}}
        {{--                            @foreach ($sampleMedia as $key => $media)--}}
        {{--                                <div class="w-full overflow-hidden @if ($loop->odd && $loop->last) col-span-2 fill-row-span @endif">--}}
        {{--                                    <img src="{{ $media->temporaryUrl() }}" title="{{ $sampleMediaNames[$key] }}" alt="{{ $sampleMediaNames[$key] }}" class="object-cover w-full">--}}
        {{--                                </div>--}}
        {{--                            @endforeach--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            @endif--}}
        {{--        </div>--}}
    </x-slot>

    <x-slot name="actions">
        <x-library::button wire:click.prevent="create"
                           wire:target="create">{{ Translate::get('Create') }}</x-library::button>
    </x-slot>

</x-library::modal>
