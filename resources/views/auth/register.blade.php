@php use \OmniaDigital\CatalystForms\Models\Form; @endphp
<catalyst::catalyst::components.guest-layout>
    <catalyst::catalyst::components.authentication-card>
        <x-slot name="logo">
            <img src="{{ config('app.logo_path') }}" class="h-16"/>
        </x-slot>

        <x-slot name="slogan">
            <x-library::heading.2 text-color="text-heading-default-color "
                                  class="mt-6">{{ Translate::get(config('app.slogan', '')) }}</x-library::heading.2>
        </x-slot>

        <x-library::heading.2 class="text-center">{{ Translate::get('Create your account') }}</x-library::heading.2>

        <catalyst::catalyst::components.validation-errors class="mb-4"/>

        @if (Form::getRegistrationForm())
            <livewire:catalyst-forms::user-registration-form
                    :form="Form::getRegistrationForm()"
                    submitText="Sign Up"
            />
        @else
            <catalyst::components.forms.register-default-form/>
        @endif

        <x-slot name="additionalCard">
            <div class="flex items-center justify-center">
                <p class=" text-base-text-color">
                    {{ Translate::get('Already have an account?') }}
                    <a class="underline text-lg font-bold text-base-text-color hover:text-dark-text-color"
                       href="{{ route('login') }}">
                        {{ Translate::get('Log In') }}
                    </a>
                </p>
            </div>
        </x-slot>
    </catalyst::catalyst::components.authentication-card>
</catalyst::catalyst::components.guest-layout>
