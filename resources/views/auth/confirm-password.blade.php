<catalyst::components.guest-layout>
    <catalyst::components.authentication-card>
        <x-slot name="logo">
            <catalyst::components.authentication-card-logo/>
        </x-slot>

        <div class="mb-4 text-sm text-base-text-color">
            {{ Translate::get('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <catalyst::components.validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <catalyst::components.label for="password" value="{{ Translate::get('Password') }}"/>
                <catalyst::components.input id="password" class="block mt-1 w-full" type="password" name="password" required
                         autocomplete="current-password" autofocus/>
            </div>

            <div class="flex justify-end mt-4">
                <catalyst::components.button class="ml-4">
                    {{ Translate::get('Confirm') }}
                </catalyst::components.button>
            </div>
        </form>
    </catalyst::components.authentication-card>
</catalyst::components.guest-layout>
