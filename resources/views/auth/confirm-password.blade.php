<x-catalyst::guest-layout>
    <x-catalyst::authentication-card>
        <x-slot name="logo">
            <x-catalyst::authentication-card-logo/>
        </x-slot>

        <div class="mb-4 text-sm text-base-text-color">
            {{ Translate::get('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <x-catalyst::validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-catalyst::label for="password" value="{{ Translate::get('Password') }}"/>
                <x-catalyst::input id="password" class="block mt-1 w-full" type="password" name="password" required
                         autocomplete="current-password" autofocus/>
            </div>

            <div class="flex justify-end mt-4">
                <x-catalyst::button class="ml-4">
                    {{ Translate::get('Confirm') }}
                </x-catalyst::button>
            </div>
        </form>
    </x-catalyst::authentication-card>
</x-catalyst::guest-layout>
