@props(['title' => Translate::get('Confirm Password'), 'content' => Translate::get('For your security, please confirm your password to continue.'), 'button' => Translate::get('Confirm')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
        {{ $attributes->wire('then') }}
        x-data
        x-ref="span"
        x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
        x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
    <x-dialog-modal wire:model.live="confirmingPassword">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="content">
            {{ $content }}

            <div class="mt-4" x-data="{}"
                 x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
                <x-catalyst::input type="password" class="mt-1 block w-3/4" placeholder="{{ Translate::get('Password') }}"
                         x-ref="confirmable_password"
                         wire:model.live="confirmablePassword"
                         wire:keydown.enter="confirmPassword"/>

                <x-catalyst::input-error for="confirmable_password" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-catalyst::secondary-button wire:click="stopConfirmingPassword" wire:loading.attr="disabled">
                {{ Translate::get('Cancel') }}
            </x-catalyst::secondary-button>

            <x-catalyst::button class="ml-2" dusk="confirm-password-button" wire:click="confirmPassword"
                      wire:loading.attr="disabled">
                {{ $button }}
            </x-catalyst::button>
        </x-slot>
    </x-dialog-modal>
@endonce
