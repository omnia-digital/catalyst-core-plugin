<x-catalyst::guest-layout>
    <x-catalyst::authentication-card>
        <x-slot name="logo">
            <x-catalyst::authentication-card-logo/>
        </x-slot>

        <div x-data="{ recovery: false }">
            <div class="mb-4 text-sm text-base-text-color" x-show="! recovery">
                {{ Translate::get('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="mb-4 text-sm text-base-text-color" x-show="recovery">
                {{ Translate::get('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <x-catalyst::validation-errors class="mb-4"/>

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="mt-4" x-show="! recovery">
                    <x-catalyst::label for="code" value="{{ Translate::get('Code') }}"/>
                    <x-catalyst::input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus
                             x-ref="code" autocomplete="one-time-code"/>
                </div>

                <div class="mt-4" x-show="recovery">
                    <x-catalyst::label for="recovery_code" value="{{ Translate::get('Recovery Code') }}"/>
                    <x-catalyst::input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code"
                             x-ref="recovery_code" autocomplete="one-time-code"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="button"
                            class="text-sm text-base-text-color hover:text-dark-text-color underline cursor-pointer"
                            x-show="! recovery"
                            x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ Translate::get('Use a recovery code') }}
                    </button>

                    <button type="button"
                            class="text-sm text-base-text-color hover:text-dark-text-color underline cursor-pointer"
                            x-show="recovery"
                            x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ Translate::get('Use an authentication code') }}
                    </button>

                    <x-catalyst::button class="ml-4">
                        {{ Translate::get('Log in') }}
                    </x-catalyst::button>
                </div>
            </form>
        </div>
    </x-catalyst::authentication-card>
</x-catalyst::guest-layout>
