<x-action-section>
    <x-slot name="title">
        {{ Translate::get('Two Factor Authentication') }}
    </x-slot>

    <x-slot name="description">
        {{ Translate::get('Add additional security to your account using two factor authentication.') }}
    </x-slot>

    <x-slot name="content">
        <x-library::heading.3 class="text-lg font-medium text-dark-text-color">
            @if ($this->enabled)
                {{ Translate::get('You have enabled two factor authentication.') }}
            @else
                {{ Translate::get('You have not enabled two factor authentication.') }}
            @endif
        </x-library::heading.3>

        <div class="mt-3 max-w-xl text-sm text-base-text-color">
            <p>
                {{ Translate::get('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-base-text-color">
                    <p class="font-semibold">
                        {{ Translate::get('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application.') }}
                    </p>
                </div>

                <div class="mt-4">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-base-text-color">
                    <p class="font-semibold">
                        {{ Translate::get('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-neutral rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button type="button" wire:loading.attr="disabled">
                        {{ Translate::get('Enable') }}
                    </x-button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-secondary-button class="mr-3">
                            {{ Translate::get('Regenerate Recovery Codes') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-secondary-button class="mr-3">
                            {{ Translate::get('Show Recovery Codes') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @endif

                <x-confirms-password wire:then="disableTwoFactorAuthentication">
                    <x-danger-button wire:loading.attr="disabled">
                        {{ Translate::get('Disable') }}
                    </x-danger-button>
                </x-confirms-password>
            @endif
        </div>
    </x-slot>
</x-action-section>
