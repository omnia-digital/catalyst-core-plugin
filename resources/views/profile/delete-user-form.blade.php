<x-action-section>
    <x-slot name="title">
        {{ Translate::get('Delete Account') }}
    </x-slot>

    <x-slot name="description">
        {{ Translate::get('Permanently delete your account.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-base-text-color">
            {{ Translate::get('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <x-catalyst::danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ Translate::get('Delete Account') }}
            </x-catalyst::danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                {{ Translate::get('Delete Account') }}
            </x-slot>

            <x-slot name="content">
                {{ Translate::get('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                <div class="mt-4" x-data="{}"
                     x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-catalyst::input type="password" class="mt-1 block w-3/4"
                             placeholder="{{ Translate::get('Password') }}"
                             x-ref="password"
                             wire:model.live="password"
                             wire:keydown.enter="deleteUser"/>

                    <x-catalyst::input-error for="password" class="mt-2"/>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-catalyst::secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ Translate::get('Cancel') }}
                </x-catalyst::secondary-button>

                <x-catalyst::danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ Translate::get('Delete Account') }}
                </x-catalyst::danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
