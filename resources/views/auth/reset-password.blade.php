<catalyst::x-guest-layout>
    <catalyst::x-authentication-card>
        <x-slot name="logo">
            <catalyst::x-authentication-card-logo/>
        </x-slot>

        <catalyst::x-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <catalyst::x-label for="email" value="{{ Translate::get('Email') }}"/>
                <catalyst::x-input id="email" class="block mt-1 w-full" type="email" name="email"
                         :value="old('email', $request->email)" required autofocus/>
            </div>

            <div class="mt-4">
                <catalyst::x-label for="password" value="{{ Translate::get('Password') }}"/>
                <catalyst::x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                         autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <catalyst::x-label for="password_confirmation" value="{{ Translate::get('Confirm Password') }}"/>
                <catalyst::x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                         name="password_confirmation" required autocomplete="new-password"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <catalyst::x-button>
                    {{ Translate::get('Reset Password') }}
                </catalyst::x-button>
            </div>
        </form>
    </catalyst::x-authentication-card>
</catalyst::x-guest-layout>
