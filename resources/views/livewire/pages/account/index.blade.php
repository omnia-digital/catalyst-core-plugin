@extends('social::livewire.layouts.pages.account-page-layout')

@section('content')
    <x-social::page-heading>
        <x-slot name="title">{{ Translate::get('Account Settings') }}</x-slot>
        {{ Translate::get('Manage all your account settings in one place.') }}
    </x-social::page-heading>
    <x-vertical-tabs>
        <x-slot:items>
            <x-vertical-tabs.item icon="cog" class="text-lg font-medium">Account</x-vertical-tabs.item>
            <x-vertical-tabs.item icon="bell" class="text-lg font-medium">Notification Settings</x-vertical-tabs.item>
        </x-slot:items>
        <x-slot:panels>
            <x-vertical-tabs.panel>
                <x-slot:title>{{ Translate::get('Account') }}</x-slot:title>
                <x-slot:description>Change your account settings.</x-slot:description>
                <div class="mt-6 grid grid-cols-4 gap-6">
                    <div class="col-span-4 sm:col-span-2">
                        <x-library::input.label value="Email" class="inline"/>
                        <span class="text-red-600 text-sm">*</span>
                        <x-library::input.text id="email" wire:model.live="email" required/>
                        <x-library::input.error for="email"/>
                    </div>
                    <div class="col-span-4 sm:col-span-2">
                        <x-library::input.label value="Username" class="inline"/>
                        <span class="text-red-600 text-sm">*</span>
                        <x-library::input.text id="handle" wire:model.live="handle" required/>
                        <x-library::input.error for="handle"/>
                    </div>
                </div>
                <x-slot:footer>
                    <x-action-message class="mr-3 text-success-600" on="account_saved">
                        {{ Translate::get('Saved.') }}
                    </x-action-message>

                    <x-button wire:click="updateAccount" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updateAccount">{{ Translate::get('Save') }}</span>
                        <span wire:loading wire:target="updateAccount">{{ Translate::get('Saving...') }}</span>
                    </x-button>
                </x-slot:footer> {{-- Additional Cards --}}
                <x-slot:additional>
                    <x-vertical-tabs.panel-section>
                        <x-slot:title>Password</x-slot:title>
                        <x-slot:description>{{ Translate::get('Ensure your account is using a long, random password to stay secure.') }}</x-slot:description>
                        <div class="mt-6 grid grid-cols-4 gap-6">
                            <div class="col-span-4">
                                <x-label for="current_password" value="{{ Translate::get('Current Password') }}"/>
                                <x-input id="current_password" type="password" class="mt-1 block w-full"
                                         wire:model.live="state.current_password"
                                         autocomplete="current-password"/>
                                <x-input-error for="current_password" class="mt-2"/>
                            </div>

                            <div class="col-span-4">
                                <x-label for="password" value="{{ Translate::get('New Password') }}"/>
                                <x-input id="password" type="password" class="mt-1 block w-full"
                                         wire:model.live="state.password" autocomplete="new-password"/>
                                <x-input-error for="password" class="mt-2"/>
                            </div>

                            <div class="col-span-4">
                                <x-label for="password_confirmation" value="{{ Translate::get('Confirm Password') }}"/>
                                <x-input id="password_confirmation" type="password" class="mt-1 block w-full"
                                         wire:model.live="state.password_confirmation"
                                         autocomplete="new-password"/>
                                <x-input-error for="password_confirmation" class="mt-2"/>
                            </div>
                        </div>
                        <x-slot:footer>
                            <x-action-message class="mr-3 text-success-600" on="password_saved">
                                {{ Translate::get('Saved.') }}
                            </x-action-message>

                            <x-button wire:click="updatePassword" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="updatePassword">{{ Translate::get('Save') }}</span>
                                <span wire:loading wire:target="updatePassword">{{ Translate::get('Saving...') }}</span>
                            </x-button>
                        </x-slot:footer>
                    </x-vertical-tabs.panel-section>
                </x-slot:additional>
            </x-vertical-tabs.panel>
            <x-vertical-tabs.panel>
                <x-slot:title>{{ Translate::get('Notification Settings') }}</x-slot:title>
                <x-slot:description>{{ Translate::get('Change your notification settings.') }}</x-slot:description>

                <x-slot:footer>
                    <x-action-message class="mr-3 text-success-600" on="account_saved">
                        {{ Translate::get('Saved.') }}
                    </x-action-message>
                    <livewire:notification-manager/>
                    <x-button wire:click="updateAccount" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updateAccount">{{ Translate::get('Save') }}</span>
                        <span wire:loading wire:target="updateAccount">{{ Translate::get('Saving...') }}</span>
                    </x-button>
                </x-slot:footer>
            </x-vertical-tabs.panel>
        </x-slot:panels>
    </x-vertical-tabs>
@endsection
