<catalyst::components.guest-layout>
    <catalyst::components.authentication-card>
        <x-slot name="logo">
            <catalyst::components.authentication-card-logo/>
        </x-slot>

        <catalyst::components.validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <catalyst::components.label for="email" value="{{ Translate::get('Email') }}"/>
                <catalyst::components.input id="email" class="block mt-1 w-full" type="email" name="email"
                         :value="old('email', $request->email)" required autofocus/>
            </div>

            <div class="mt-4">
                <catalyst::components.label for="password" value="{{ Translate::get('Password') }}"/>
                <catalyst::components.input id="password" class="block mt-1 w-full" type="password" name="password" required
                         autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <catalyst::components.label for="password_confirmation" value="{{ Translate::get('Confirm Password') }}"/>
                <catalyst::components.input id="password_confirmation" class="block mt-1 w-full" type="password"
                         name="password_confirmation" required autocomplete="new-password"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <catalyst::components.button>
                    {{ Translate::get('Reset Password') }}
                </catalyst::components.button>
            </div>
        </form>
    </catalyst::components.authentication-card>
</catalyst::components.guest-layout>
