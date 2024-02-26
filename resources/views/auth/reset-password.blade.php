<x-catalyst::guest-layout>
    <x-catalyst::authentication-card>
        <x-slot name="logo">
            <x-catalyst::authentication-card-logo/>
        </x-slot>

        <x-catalyst::validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-catalyst::label for="email" value="{{ Translate::get('Email') }}"/>
                <x-catalyst::input id="email" class="block mt-1 w-full" type="email" name="email"
                         :value="old('email', $request->email)" required autofocus/>
            </div>

            <div class="mt-4">
                <x-catalyst::label for="password" value="{{ Translate::get('Password') }}"/>
                <x-catalyst::input id="password" class="block mt-1 w-full" type="password" name="password" required
                         autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <x-catalyst::label for="password_confirmation" value="{{ Translate::get('Confirm Password') }}"/>
                <x-catalyst::input id="password_confirmation" class="block mt-1 w-full" type="password"
                         name="password_confirmation" required autocomplete="new-password"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-catalyst::button>
                    {{ Translate::get('Reset Password') }}
                </x-catalyst::button>
            </div>
        </form>
    </x-catalyst::authentication-card>
</x-catalyst::guest-layout>
