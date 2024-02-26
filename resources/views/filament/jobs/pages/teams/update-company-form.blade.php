<div>
    <x-catalyst::section-border/>

    <div class="mt-10 sm:mt-0">
        <x-catalyst-forms::forms.form-section submit="updateCompany">
            <x-slot name="title">
                {{ __('Company About') }}
            </x-slot>

            <x-slot name="description">
                {{ __('The company\'s information.') }}
            </x-slot>

            <x-slot name="form">
                <!-- About -->
                <div class="col-span-6">
                    <x-library::input.label for="name" value="{{ __('About') }}"/>

                    <x-library::input.textarea
                            id="about"
                            class="mt-1 block w-full"
                            wire:model="state.about"
                            :disabled="! Gate::check('update', $company)"/>

                    <x-catalyst::input-error for="about" class="mt-2"/>
                </div>
            </x-slot>

            @if (Gate::check('update', $company))
                <x-slot name="actions">
                    <x-catalyst::action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-catalyst::action-message>

                    <x-library::button>
                        {{ __('Save') }}
                    </x-library::button>
                </x-slot>
            @endif
        </x-catalyst-forms::forms.form-section>

    </div>

</div>
