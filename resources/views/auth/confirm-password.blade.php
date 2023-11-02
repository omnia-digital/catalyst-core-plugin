<catalyst::x-guest-layout>
    <catalyst::x-authentication-card>
        <x-slot name="logo">
            <catalyst::x-authentication-card-logo/>
        </x-slot>

        <div class="mb-4 text-sm text-base-text-color">
            {{ Translate::get('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <catalyst::x-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <catalyst::x-label for="password" value="{{ Translate::get('Password') }}"/>
                <catalyst::x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                         autocomplete="current-password" autofocus/>
            </div>

            <div class="flex justify-end mt-4">
                <catalyst::x-button class="ml-4">
                    {{ Translate::get('Confirm') }}
                </catalyst::x-button>
            </div>
        </form>
    </catalyst::x-authentication-card>
</catalyst::x-guest-layout>
