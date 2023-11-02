<catalyst::x-guest-layout>
    <catalyst::x-authentication-card>
        <x-slot name="logo">
            <catalyst::x-authentication-card-logo/>
        </x-slot>

        <div class="mb-4 text-sm text-base-text-color">
            {{ Translate::get('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <catalyst::x-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <catalyst::x-label for="email" value="{{ Translate::get('Email') }}"/>
                <catalyst::x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                         autofocus/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <catalyst::x-button>
                    {{ Translate::get('Email Password Reset Link') }}
                </catalyst::x-button>
            </div>
        </form>
    </catalyst::x-authentication-card>
</catalyst::x-guest-layout>
